<?php
/**
 * Created by PhpStorm.
 * User: Hiệp Nguyễn
 * Date: 05/10/2021
 * Time: 17:25
 */

namespace Deployer;

function npm($command, $options = []): \Closure
{
    return function () use ($command, $options) {
        switch ($command) {
            case 'install':
                if (has('previous_release')) {
                    if (test('[ -d {{previous_release}}/node_modules ]')) {
                        run('cp -R {{previous_release}}/node_modules {{release_path}}');
                    }
                }

                run('cd {{release_path}} && npm install');
                break;
            case 'run':
                if (!isset($options['stage'])) {
                    $options['stage'] = "prod";
                }
                run("cd {{release_path}} && npm run {$options['stage']}");
                break;
            default:
                writeln("<error>command invalid</error>");
                break;
        }
        return;
    };
}

desc('npm install');
task('npm:install', npm("install"));

desc('npm run production');
task('npm:run_prod', npm("run"));

desc('npm run development');
task('npm:run_dev', npm("run", ["stage" => "dev"]));

