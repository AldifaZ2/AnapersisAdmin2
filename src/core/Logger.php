<?php
namespace NeyShiKu\CleanlyGo\Core;

use Monolog\Logger as MonoLogger;
use Monolog\Handler\StreamHandler;
use Monolog\Level;

class Logger
{
    public static function getLogger(string $channel = 'app'): MonoLogger
    {
        $log = new MonoLogger($channel);

        $log->pushHandler(new StreamHandler(__DIR__ . '/../../logs/app.log', Level::Debug));

        return $log;
    }
}
