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
    'artisan:event:clear',
    'artisan:event:cache',
    'artisan:queue:restart',
    // 'artisan:opcache:clear',
    'artisan:optimize',
    'deploy:symlink',
 //   'pm2:restart',
    'deploy:unlock',
    'cleanup',
     'opcache_reset',
    'opcache_status',
]);

