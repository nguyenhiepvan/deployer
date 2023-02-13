<?php

namespace Deployer;

task('git:pull', function () {
    run('cd {{current_path}}; git pull', ['tty' => false, 'timeout' => null]);
});

task('git:clean', function () {
    run('cd {{current_path}}; git clean -df', ['tty' => false, 'timeout' => null]);
});
task('git:reset:hard', function () {
    run('cd {{current_path}}; git reset --hard', ['tty' => false, 'timeout' => null]);
});

task('git:pull:hard',[
    'git:reset:hard',
    'git:pull',
]);

task('git:pull_only', function () {
    run('cd {{current_path}}; git pull', ['tty' => false, 'timeout' => null]);
});

task('git:pull:full', [
    'git:pull',
    'opcache:reset',
]);

//after('git:pull', 'opcache:reset');