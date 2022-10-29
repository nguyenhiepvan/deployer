<?php

namespace Deployer;


function laravel_version_compare($version, $comparator)
{
    return version_compare(get('laravel_version'), $version, $comparator);
}

function listFolderFiles(string $dir, array $ignores = []): array
{
    $ffs = scandir($dir);

    unset($ffs[array_search('.', $ffs, true)], $ffs[array_search('..', $ffs, true)]);
    if (count($ffs) < 1) {
        return [];
    }
    $files = [];
    foreach ($ffs as $ff) {
        if (is_dir($file = $dir . '/' . $ff)) {
            $files = array_merge($files, listFolderFiles($file, $ignores));
        } else {
            $ignore = false;
            foreach ($ignores as $value) {
                if (str_contains($file, $value)) {
                    $ignore = true;
                    break;
                }
            }
            if ($ignore) {
                continue;
            }
            $files[] = $file;
        }
    }
    return $files;
}

function upload_file(string $source, array $ignores = ["conf.d"]): \Closure
{
    return static function () use ($ignores, $source) {
        $files = listFolderFiles($source, $ignores);
        foreach ($files as $file) {
            $remote_file = str_replace("$source/", "", $file);
            upload($file, "{{release_path}}/$remote_file", [
                "options" => [
                    "--inplace",
                    "--quiet",
                ],
            ]);
            writeln("File $remote_file has been uploaded");
        }
    };
}

/**
 * Task deploy:public_disk support the public disk.
 * To run this task automatically, please add below line to your deploy.php file
 *
 *     before('deploy:symlink', 'deploy:public_disk');
 *
 * @see https://laravel.com/docs/5.2/filesystem#configuration
 */
desc('Make symlink for public disk');
task('deploy:public_disk', function () {
    // Remove from source.
    run('if [ -d $(echo {{release_path}}/public/storage) ]; then rm -rf {{release_path}}/public/storage; fi');

    // Create shared dir if it does not exist.
    run('mkdir -p {{deploy_path}}/shared/storage/app/public');

    // Symlink shared dir to release dir
    run('{{bin/symlink}} {{deploy_path}}/shared/storage/app/public {{release_path}}/public/storage');
});

desc('rollback previous version');
task('deploy:rollback', [
    "rollback",
    "opcache:reset"
]);


desc('certificate');
task('deploy:certificate', function () {
    // if certbot installed
    if (test('which certbot')) {
        // if certbot installed
        run('certbot --nginx -d {{domain}} --email {{email}} --agree-tos');
    } else {
        writeln('Please install certbot');
    }
});
