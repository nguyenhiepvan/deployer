<?php
/**
 * Created by PhpStorm.
 * User: Hiệp Nguyễn
 * Date: 26/10/2021
 * Time: 13:44
 */

namespace Deployer;

task('composer:install', function () {
    run('cd {{current_path}}; {{bin/composer}} install', ['tty' => true, 'timeout' => null]);
});
task('composer:update', function () {
    run('cd {{current_path}}; {{bin/composer}} update', ['tty' => true, 'timeout' => null]);
});
task('composer:dumpautoload', function () {
    run('cd {{current_path}}; {{bin/composer}} dumpautoload', ['tty' => true, 'timeout' => null]);
});