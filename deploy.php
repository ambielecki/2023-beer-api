<?php
namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', '');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('137.184.202.43')
    ->set('remote_user', 'deployer')
    ->set('deploy_path', '~/beer-api');

// Hooks

after('deploy:failed', 'deploy:unlock');
