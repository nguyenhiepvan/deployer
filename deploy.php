<?php

namespace Deployer;

require_once 'vendor/autoload.php';

use Illuminate\Support\Arr;
use Symfony\Component\Process\Exception\ProcessFailedException;

const VERBOSITY = [
    64  => "-v",
    128 => "-vv",
    256 => "-vvv",
];

set('git_tty', true);

if ($dirs = array_diff(array_filter(glob('*'), 'is_dir'), ["vendor"])) {
    host(...$dirs);
}
// Tasks

desc('Deploy your projects');
task('deploy', function () {
    $verbosity = Deployer::get()->getOutput()->getVerbosity();
    $stage     = Deployer::get()->getInput()->getArgument("stage");
    if ($hosts = Deployer::get()->getInput()->getOption("hosts")) {
        $hosts = explode(",", $hosts);
        foreach ($hosts as $host) {
            deploy($host, $stage, $verbosity);
        }
    }
});

function deploy(string $host, string $stage, int $verbosity = 0): void
{
    writeln("<info>Deploy project $host</info>");
    try {
        run("cd $host && " . DEPLOYER_BIN . " deploy:force_unlock $stage " . Arr::get(VERBOSITY, $verbosity));
    } catch (ProcessFailedException $e) {
    }
    try {
        run("cd $host && " . DEPLOYER_BIN . " deploy $stage " . Arr::get(VERBOSITY, $verbosity));
    } catch (ProcessFailedException $e) {
    }
}
