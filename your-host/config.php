<?php
namespace Deployer;

// Project name
set('application', '');
// Project repository
set('repository', '');
// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);
// Hosts
// Shared files/dirs between deploys
set('shared_dirs', []);
set('shared_files', []);
set('writable_dirs', []);
set('default_timeout', null);
