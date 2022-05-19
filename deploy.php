<?php

namespace Deployer;

require 'recipe/laravel.php';
require 'recipe/rsync.php';

set('application', 'Bubblebath');
set('http_user', 'www-data');
set('ssh_multiplexing', true);

set('rsync_src', function () {
    return __DIR__;
});


add('rsync', [
    'exclude' => [
        '.git',
        '/.env',
        '/storage/',
        '/vendor/',
        '/node_modules/',
        '.github',
        'deploy.php',
    ],
]);

task('deploy:secrets', function () {
    file_put_contents(__DIR__ . '/.env', getenv('DOT_ENV'));
    upload('.env', get('deploy_path') . '/shared');
});
// Need to update the Production details here along with directory
host('myapp.io')
  ->hostname('104.248.172.220')
  ->stage('production')
  ->user('root')
  ->set('deploy_path', '/var/www/my-app');

host('staging.bubblebath.one')
  ->hostname('217.21.83.53')
  ->stage('staging')
  ->user('u893456827')
  ->port('65002')
  ->set('deploy_path', '/home/u893456827/domains/staging.bubblebath.one/public_html');

after('deploy:failed', 'deploy:unlock');

desc('Deploy the application');

task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'rsync',
    'deploy:secrets',
    'deploy:shared',
    'deploy:vendors',
    'deploy:writable',
    'artisan:storage:link',
    'artisan:view:cache',
    'artisan:config:cache',
    'artisan:migrate',
    'artisan:queue:restart',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
]);
/**
 * Prints success message
 */


 /**
 * Follows latest application logs.
 */
// desc('Shows application logs');
// task('logs:app', function () {
//     if (!has('log_files')) {
//         warning("Please, specify \"log_files\" option.");
//         return;
//     }
//     cd('{{current_path}}');
//     run('tail -f {{log_files}}');
// })->verbose();
