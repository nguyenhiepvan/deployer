<?php

namespace Deployer;

use Deployer\Task\Context;

/**
 * Created by PhpStorm.
 * User: Hiệp Nguyễn
 * Date: 29/06/2022
 * Time: 13:14
 */

desc("upload nginx config file");
task("sudo:upload", sudo_upload());

function sudo_upload(string $destination = "/etc/nginx/conf.d/", array $config = []): \Closure
{
    return static function () use ($config, $destination) {
        $rsync   = Deployer::get()->rsync;
        $host    = Context::get()->getHost();
        $sources = get("nginx_config_sources", []);
        if (count($sources) === 0) {
            return;
        }
        $username = ask("Username:");
        $password = askHiddenResponse("Password:");
        if ($username === "" || $password === "") {
            return;
        }
        //Hiepnguyen@123docserver
        dump($username, $password);
        $host->user($username);
//        rsync -R -avz -e ssh --rsync-path="echo mypassword | sudo -S  mkdir -p /remote/lovely/folder && sudo rsync" /home/ubuntu/my/lovely/folder ubuntu@x.x.x.x:/remote/lovely/folder --delete
        $config['options'] = [
            "--inplace",
            "--quiet",
            "-e 'ssh -A -p " . $host->getPort() . "'",
            "--rsync-path='echo \"{$password}\" | sudo -S -H -u {$username} rsync'",
        ];
        $destination       = parse($destination);
        foreach ($sources as $source) {
            $source = parse($source);
            $rsync->call($host->getHostname(), $source, "$host:$destination", $config);
            writeln("File $source has been uploaded");
        }
    };
}