#!/usr/bin/env php
<?php

declare(strict_types=1);

namespace Ghostwriter\Mzo\Bin;

use Ghostwriter\Mzo\Console\Application;
use Ghostwriter\Mzo\Console\Command\HelpCommand;
use Ghostwriter\Mzo\Console\Command\ListCommand;
use Ghostwriter\Mzo\Console\Command\NewCommand;

use const DIRECTORY_SEPARATOR;
use const PHP_EOL;
use const STDERR;

use function dirname;
use function file_exists;
use function fwrite;
use function sprintf;

/** @var ?string $_composer_autoload_path */
(static function (string $composerAutoloadPath): never {
    if (! file_exists($composerAutoloadPath)) {
        fwrite(
            STDERR,
            sprintf(
                '[ERROR]Cannot locate "%s".%sPlease run "composer install" to generate autoload files.',
                $composerAutoloadPath,
                PHP_EOL
            )
        );
        exit(1);
    }

    require $composerAutoloadPath;

    /** #BlackLivesMatter */
    $exitCode = Application::new('Mzo', 'ghostwriter/mzo', 'Nathanael Esayeas')
        ->withCommands(NewCommand::class, ListCommand::class, HelpCommand::class)
        ->run($_SERVER['argv'] ?? $argv ?? []);

    exit($exitCode);
})($_composer_autoload_path ?? dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php');
