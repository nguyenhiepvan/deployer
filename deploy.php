<?php

namespace Deployer;

use Deployer\Exception\Exception;

require 'recipe/common.php';
require 'config.php';

set('git_tty', true);
// Hosts

localhost()
    ->set('deploy_path', __DIR__);


// Tasks
desc('deploy childs project');
task('deploy:childs', function () {
    foreach (CHILDS as $child) {
        writeln("<info>Deploy project {$child['name']}</info>");
        try {
            run("cd {$child['folder']} && " . DEPLOYER_BIN . " deploy:force_unlock {$child['stage']} " . VERBOSITIES['DEBUG']);
            run("cd {$child['folder']} && " . DEPLOYER_BIN . " deploy {$child['stage']} " . VERBOSITIES['DEBUG']);
        }catch (Exception $exception){}

    }
    return;
});

desc('Deploy your project');
task('deploy', [
    'deploy:childs'
]);

