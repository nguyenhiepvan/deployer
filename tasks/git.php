<?php

namespace Deployer;

task('git:pull', function () {
    run('cd {{current_path}}; git pull');
});

task('git:clean', function () {
    run('cd {{current_path}}; git clean -df');
});
task('git:reset:hard', function () {
    run('cd {{current_path}}; git reset --hard');
});

task('git:pull:hard',[
    'git:reset:hard',
    'git:pull',
]);

task('git:pull_only', function () {
    run('cd {{current_path}}; git pull');
});

task('git:pull:full', [
    'git:pull',
    'opcache:reset',
]);

//after('git:pull', 'opcache:reset');