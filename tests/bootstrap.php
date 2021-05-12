<?php

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Filesystem\Filesystem;

require dirname(__DIR__).'/vendor/autoload.php';

if (file_exists(dirname(__DIR__).'/config/bootstrap.php')) {
    require dirname(__DIR__).'/config/bootstrap.php';
} elseif (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(dirname(__DIR__).'/.env');
}

if (isset($_ENV['APP_FIXTURES_LOAD']) && $_ENV['APP_FIXTURES_LOAD']) {
    (new Filesystem())->remove(__DIR__.'/../var/cache/test');
    passthru(sprintf('php "%s/../bin/console" cache:warmup', __DIR__));
    passthru(sprintf('php "%s/../bin/console" doctrine:schema:drop --force -n', __DIR__));
    passthru(sprintf('php "%s/../bin/console" doctrine:schema:update --force -n', __DIR__));
    passthru(sprintf('php "%s/../bin/console" doctrine:fixtures:load -n', __DIR__));
}
