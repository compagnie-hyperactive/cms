<?php
namespace Deployer;

require 'recipe/common.php';

// Project name
set('application', 'lch-cms');

// Project repository
set('repository', 'git@github.com:compagnie-hyperactive/cms.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true); 

// Shared files/dirs between deploys 
set('shared_files', ['.env', 'public/.htaccess', 'public/.htpasswd']);
set('shared_dirs', ['var', 'public/media', 'vendor']);

// Writable dirs by web server 
//set('writable_dirs', ['var']);


// Hosts

host('cms.preprod')
	->stage('preprod')
	->set('branch', 'master')
    ->set('deploy_path', '/var/www/lchcms/www');
    

// Tasks

desc('Deploy your project');
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:writable',
    'deploy:composer',
	'deploy:database_migration',
    'deploy:clear_paths',
    'deploy:assets',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
	'remove',
	'success'
]);

// [Optional] If deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');


desc('Execute Doctrine Migrations');
task('deploy:database_migration', function () {
	$output = run("cd {{release_path}}; /opt/php7/bin/php bin/console doctrine:migrations:diff; /opt/php7/bin/php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration");
	write($output);
});

desc('Remove all uneeded files');
task('remove', function () {
	run("rm -rf .env deploy.php");
//	run("rm -rf {{release_path}}/data {{release_path}}/docker {{release_path}}/.env {{release_path}}/deploy.php {{release_path}}/docker-compose.yml {{release_path}}/init.sh {{release_path}}/wp-cli.yml");
});

desc('Update composer in good path');
task('deploy:composer', function () {
	run("cd {{release_path}}; composer install --verbose --prefer-dist --no-progress --no-interaction --optimize-autoloader");
});

desc('Compile assets');
task('deploy:assets', function () {
//	run("cd {{release_path}}/app; yarn");
//	run("cd {{release_path}}/app; ./node_modules/.bin/encore dev");
});