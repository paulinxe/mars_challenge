#!/usr/bin/php

<?php

require __DIR__ .'/vendor/autoload.php';

try {
    $app = new src\App($argv);
    $app->run();
} catch (Exception $e) {
    print("An error has occurred: {$e->getMessage()}.\n{$e->getTraceAsString()}\n");
}