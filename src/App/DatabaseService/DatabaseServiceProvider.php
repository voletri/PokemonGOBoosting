<?php

namespace App\DatabaseService;

use Silex\ServiceProviderInterface;
use Silex\Application;

use PDO;

class DatabaseServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['database'] = $app->share(function () use ($app) {
            return new Database($app['database.options']);
        });
    }

    public function boot(Application $app)
    {
    }
}