<?php
namespace Deployer;

// Project name
set('application', 'my_project');

// Project repository
set('repository', 'git@gitlab.com:HiepNguyenVan/deployer.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys
set('shared_files', []);
set('shared_dirs', []);

// Writable dirs by web server
set('writable_dirs', []);


// Hosts

host('project.com')
    ->set('deploy_path', '~/{{application}}');