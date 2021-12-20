<?php
/**
 * Created by PhpStorm.
 * User: Hiệp Nguyễn
 * Date: 01/11/2021
 * Time: 13:38
 */

namespace Deployer;

/**
 * Run an artisan command.
 *
 * Supported options:
 * - 'min' => #.#: The minimum Laravel version required (included).
 * - 'max' => #.#: The maximum Laravel version required (included).
 * - 'skipIfNoEnv': Skip and warn the user if `.env` file is inexistant or empty.
 * - 'failIfNoEnv': Fail the command if `.env` file is inexistant or empty.
 * - 'runInCurrent': Run the artisan command in the current directory.
 * - 'showOutput': Show the output of the command if given.
 *
 * @param string $command The artisan command (with cli options if any).
 * @param array $options The options that define the behaviour of the command.
 * @return callable A function that can be used as a task.
 */
function artisan(string $command, array $options = [])
{
    return static function () use ($command, $options) {
        $versionTooEarly = array_key_exists('min', $options)
            && laravel_version_compare($options['min'], '<');

        $versionTooLate = array_key_exists('max', $options)
            && laravel_version_compare($options['max'], '>');

        if ($versionTooEarly || $versionTooLate) {
            return;
        }
        if (in_array('failIfNoEnv', $options) && !test('[ -s {{release_path}}/.env ]')) {
            throw new \Exception('Your .env file is empty! Cannot proceed.');
        }
        if (in_array('skipIfNoEnv', $options) && !test('[ -s {{release_path}}/.env ]')) {
            writeln("Your .env file is empty! Skipping...</>");
            return;
        }

        $artisan = in_array('runInCurrent', $options)
            ? '{{deploy_path}}/current/artisan'
            : '{{release_path}}/artisan';

        $output = run("{{bin/php}} $artisan $command");

        if (in_array('showOutput', $options)) {
            writeln("<info>$output</info>");
        }
    };
}


desc('Disable maintenance mode');
task('artisan:up', artisan('up', ['runInCurrent', 'showOutput']));

desc('Enable maintenance mode');
task('artisan:down', artisan('down', ['runInCurrent', 'showOutput']));

desc('Execute artisan migrate');
task('artisan:migrate', artisan('migrate --force', ['skipIfNoEnv']));

desc('Execute artisan migrate:fresh');
task('artisan:migrate:fresh', artisan('migrate:fresh --force'));

desc('Execute artisan migrate:rollback');
task('artisan:migrate:rollback', artisan('migrate:rollback --force', ['showOutput']));

desc('Execute artisan migrate:status');
task('artisan:migrate:status', artisan('migrate:status', ['showOutput']));

desc('Execute artisan db:seed');
task('artisan:db:seed', artisan('db:seed --force', ['showOutput']));

desc('Execute artisan cache:clear');
task('artisan:cache:clear', artisan('cache:clear'));

desc('Execute artisan config:clear');
task('artisan:config:clear', artisan('config:clear'));

desc('Execute artisan config:cache');
task('artisan:config:cache', artisan('config:cache'));

desc('Execute artisan route:cache');
task('artisan:route:cache', artisan('route:cache'));

desc('Execute artisan view:clear');
task('artisan:view:clear', artisan('view:clear'));

desc('Execute artisan view:cache');
task('artisan:view:cache', artisan('view:cache', ['min' => 5.6]));

desc('Execute artisan opcache:clear');
task('artisan:opcache:clear', artisan('opcache:clear', ['min' => 5.4]));

desc('Execute artisan optimize');
task('artisan:optimize', artisan('optimize', ['min' => 5.7]));

desc('Execute artisan optimize:clear');
task('artisan:optimize:clear', artisan('optimize:clear', ['min' => 5.7]));

desc('Execute artisan queue:restart');
task('artisan:queue:restart', artisan('queue:restart'));

desc('Execute artisan storage:link');
task('artisan:storage:link', artisan('storage:link', ['min' => 5.3]));

desc('Execute artisan horizon:assets');
task('artisan:horizon:assets', artisan('horizon:assets'));

desc('Execute artisan horizon:publish');
task('artisan:horizon:publish', artisan('horizon:publish'));

desc('Execute artisan horizon:terminate');
task('artisan:horizon:terminate', artisan('horizon:terminate'));

desc('Execute artisan telescope:clear');
task('artisan:telescope:clear', artisan('telescope:clear'));

desc('Execute artisan telescope:prune');
task('artisan:telescope:prune', artisan('telescope:prune'));

desc('Execute artisan telescope:publish');
task('artisan:telescope:publish', artisan('telescope:publish'));

desc('Execute artisan nova:publish');
task('artisan:nova:publish', artisan('nova:publish'));

desc('Execute artisan event:clear');
task('artisan:event:clear', artisan('event:clear', ['min' => '5.8.9']));

desc('Execute artisan event:cache');
task('artisan:event:cache', artisan('event:cache', ['min' => '5.8.9']));
