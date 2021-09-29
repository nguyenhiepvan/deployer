<?php
namespace Deployer;

require 'recipe/laravel.php';
require __DIR__ . '/config.php';
require __DIR__ . '/../shares/tasks.php';

/**
 * Main deploy task.
 */
desc('Deploy your project');
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:vendors',
    'deploy:writable',
    'artisan:migrate',
    'artisan:storage:link',
    'artisan:view:clear',
    'artisan:cache:clear',
    'artisan:config:cache',
    'artisan:route:cache',
    'artisan:event:clear',
    'artisan:event:cache',
    'artisan:queue:restart',
    'artisan:optimize',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
]);

