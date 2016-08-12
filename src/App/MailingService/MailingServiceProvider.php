<?php

namespace App\MailingService;

use Silex\ServiceProviderInterface;
use Silex\Application;

/**
 * Class MailingServiceProvider
 * @package App\MailingService
 */
class MailingServiceProvider implements ServiceProviderInterface {
    /**
     * @param Application $app
     */
    public function register(Application $app) {
        $app['mailer'] = $app->share(function () use($app){
            return new Mailer($app['mailing.options']);
        });
    }

    /**
     * @param Application $app
     */
    public function boot(Application $app) {
    }

}