<?php
/**
 * Created by PhpStorm.
 * User: Hiệp Nguyễn
 * Date: 04/10/2021
 * Time: 10:35
 */

namespace Deployer;

$tasks_dir   = __DIR__ . "/tasks/";
$domains_dir = __DIR__ . "/domains/";
set('git_tty', true);
set('forwardAgent', true);
set('multiplexing', true);
set('keep_releases', 5);
set("default_timeout", null);
set("laravel_version", function () {
    $result = run("{{bin/php}} {{release_path}}/artisan --version");
    preg_match_all("/(\d+\.?)+/", $result, $matches);
    return $matches[0][0] ?? 5.5;
});

function base_dir($path = ''): string
{
    return __DIR__ . "/" . ltrim($path, "/");
}

$task_files = glob($tasks_dir . "*.php");
foreach ($task_files as $task_file) {
    include_once $task_file;
}
$server_files = glob($domains_dir . "*/deploy.php");

foreach ($server_files as $server_file) {
    include_once $server_file;
}

desc("General deploy task");
task("deploy", [
    "deploy:info",
    "deploy:prepare",
    "deploy:lock",
    "deploy:release",
    "deploy:update_code",
    "deploy:shared",
    "deploy:vendors",
    "deploy:writable",
    "artisan:migrate",
    "artisan:storage:link",
    "artisan:cache:clear",
    "artisan:config:cache",
    "artisan:event:clear",
    "artisan:event:cache",
    "artisan:queue:restart",
    "deploy:symlink",
    "deploy:unlock",
    "pm2:restart",
    "cleanup",
    'opcache:status',
    'opcache:reset',
]);