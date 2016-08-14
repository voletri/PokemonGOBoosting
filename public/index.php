<?php

use App\PayPalService\PayPalServiceProvider;
use App\DataBaseService\DatabaseServiceProvider;
use App\MailingService\MailingServiceProvider;

use App\Entities\Email\EmailDirector;
use App\Entities\Order\OrderDirector;


use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\SwiftmailerServiceProvider;
use Silex\Provider\ValidatorServiceProvider;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\HttpKernel\HttpKernelInterface;


use Defuse\Crypto\Key;
use Defuse\Crypto\Crypto;


require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Class App
 * @property \Symfony\Component\Validator\Validator\RecursiveValidator $validator
 * @property \Symfony\Component\HttpFoundation\Session\Session $session
 * @property \Twig_Environment $twig
 * @property-read array $ranks
 * @property-read \Defuse\Crypto\Key $cryptoKey
 */
class App extends Silex\Application{

    use Silex\Application\UrlGeneratorTrait;
    use Silex\Application\TwigTrait;
    use App\DatabaseService\DatabaseTrait;
    use App\PayPalService\PayPalTrait;
    use App\MailingService\MailerTrait;

    const logDir = __DIR__ . '/../logs';
    const logFile = '/Service.log';

    public function __get($name) {
        return $this[$name];
    }
}

$app = new App;

$app['debug']= true;

ErrorHandler::register();

$app->register(new UrlGeneratorServiceProvider());

$app->register(new TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/../layouts',
    /*'twig.options' => ($app['debug']?null:array(
        'cache' => __DIR__ . '/../cache',
        'debug' => $app['debug']
    ))*/
));

$app->register(new SessionServiceProvider(), array(
    'session.storage.options' => array(
        'cookie_lifetime' => 1800,
        'cookie_httponly'=>true,
        'cookie_secure'=>!$app['debug']
    )
));

$app->register(new SwiftmailerServiceProvider());

$app->register(new ValidatorServiceProvider());

$dbCredentials = json_decode(file_get_contents(__DIR__.'/../assets/credentials.json'), true)['Database'];

$app->register(new DatabaseServiceProvider(), array(
    'database.options'=>array(
        'host' => $dbCredentials['host'],
        'dbname' => $dbCredentials['dbname'],
        'username' => $dbCredentials['username'],
        'password' => $dbCredentials['password']
    )
));

$payPalCredentials = json_decode(file_get_contents(__DIR__.'/../assets/credentials.json'),true)['PayPal']['sandbox'];

$app->register(new PayPalServiceProvider(), array(
    'payPal.options' => array(
        'live'=>false,
        'clientID'=>$payPalCredentials['clientID'],
        'secret'=>$payPalCredentials['secret'],
        'connectionTimeOut'=>30,
        'log'=>true,
        'currency'=>'EUR',
        'paymentMethod'=>'paypal'
    )
));

$mailerCredentials = json_decode(file_get_contents(__DIR__.'/../assets/credentials.json'), true)['Mailer'];

$app->register(new MailingServiceProvider(),array(
    'mailing.options'=>array(
        'host'=>$mailerCredentials['host'],
        'port'=>$mailerCredentials['port'],
        'username'=>$mailerCredentials['username'],
        'password'=>$mailerCredentials['password'],
        'log'=>true
    )
));

$app['key'] = $app->share(function () use ($app) {
    return Key::loadFromAsciiSafeString(json_decode(file_get_contents(__DIR__.'/../assets/credentials.json'), true)['CryptoKey']);
});

$app->session->start();

$app->error(function (PDOException $exp, $code) use ($app) {
    $log = $log = '[' . date("Y/m/d H:i:s") . '] ' . get_class($exp) . ' Code: ' . $code . ' ' . $exp->getMessage() . ' File: ' . $exp->getFile() . ' Line: ' . $exp->getLine() . PHP_EOL;
    if (!file_exists($app::logDir)) {
        mkdir($app::logDir);
    }
    file_put_contents($app::logDir . $app::logFile, $log, FILE_APPEND);
    if ($app['debug']) {
        return;
    }
    return $app->render('error.twig', array('code' => null, 'error' => 'Service temporarily unavailable'));
});

$app->error(function (\Exception $exp, $code) use ($app) {
    $log = '[' . date("Y/m/d H:i:s") . '] ' . get_class($exp) . ' Code: ' . $code . ' ' . $exp->getMessage() . ' File: ' . $exp->getFile() . ' Line: ' . $exp->getLine() . PHP_EOL;
    if (!file_exists($app::logDir)) {
        mkdir($app::logDir);
    }
    file_put_contents($app::logDir . $app::logFile, $log, FILE_APPEND);
    if ($app['debug']) {
        return;
    }
    switch ($code) {
        case 401:{
            $error ='Unauthorized';
            break;
        }
        case 403: {
            $error = 'Access forbidden';
            break;
        }
        case 404: {
            $error = 'Page not found';
            break;
        }
        default: {
            $error = 'Unknown error';
            break;
        }
    }
    return $app->render('error.twig', array(
        'code' => $code,
        'error' => $error
    ));
});

$app->get('/', function()use($app){
    return $app->render('main.twig');
})->bind('index');

$app->post('/contact', function (Request $request) use ($app) {

    $name = $request->get('name');
    $email = $request->get('email');
    $messageContent = $request->get('message');

    $message = array('name' => $name, 'email' => $email, 'message' => $messageContent);

    $messageConstraints = new Assert\Collection(array(
        'name' => array(
            new Assert\NotBlank(array(
                'message' => 'Name cannot be blank.'
            )),
            new Assert\NotNull(array(
                'message' => 'Unable to obtain your name.'
            )),
            new Assert\Length(array(
                'min' => 3,
                'max' => 50,
                'minMessage' => 'Given name must be at least {{ limit }} characters long.',
                'maxMessage' => 'Given name cannot be longer than {{ limit }} characters.'
            ))
        ),
        'email' => array(
            new Assert\NotBlank(array(
                'message' => 'Email cannot be blank.'
            )),
            new Assert\NotNull(array(
                'message' => 'Unable to obtain your email.'
            )),
            new Assert\Email(array(
                'message' => 'The email {{ value }} is not a valid email.', 'checkMX' => true
            ))
        ),
        'message' => array(
            new Assert\NotBlank(array(
                'message' => 'Message cannot be blank.'
            )),
            new Assert\NotNull(array(
                'message' => 'Unable to obtain your message.'
            )),
            new Assert\Length(array(
                'min' => 5,
                'max' => 1000,
                'minMessage' => 'Message must be at least {{ limit }} characters long.',
                'maxMessage' => 'Message cannot be longer than {{ limit }} characters.'
            ))
        )
    ));

    $validationErrors = $app->validator->validate($message, $messageConstraints);

    if (count($validationErrors) > 0) {
        $errorsMessages = array();
        foreach ($validationErrors as $validationError) {
            array_push($errorsMessages, $validationError->getMessage() . "\n");
        }
        $response = array(
            'status' => 'error',
            'msg' => $errorsMessages
        );
        return $app->json($response);
    }

    $title = "Message no. " . date("YmdHis");

    //Mail to Customer Service with Question
    $mailToCustomerService = EmailDirector::newInstance(new QuestionEmailBuilder())->createEmail(
        $title
        , array($email=>$email),
        array('contact@sboost.eu' => 'SBoost Customer Service'),
        array(
            '#name#' => $name,
            '#customerMessage#' => $messageContent
        )
    );

    //Mail to Customer with Question
    $mailToCustomer = EmailDirector::newInstance(new QuestionEmailBuilder())->createEmail(
        $title,
        array('contact@sboost.eu' => 'S Boost Customer Service'),
        array($email=>$email),
        array(
            '#name#' => $name,
            '#customerMessage#' => $messageContent
        )
    );
    if(!$app->sendMail($mailToCustomerService)){
        $response = array(
            'status' => 'critical_error',
            'msg' => array(
                'We were unable to receive your message. Try again later.'
            )
        );
        return $app->json($response);
    }
    $app->sendMail($mailToCustomer);
    $response = array(
        'status' => 'successful',
        'msg' => array(
            'Thank you for contact.'
        )
    );
    return $app->json($response);
})->bind('contact');


$app->run();