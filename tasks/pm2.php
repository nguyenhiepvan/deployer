<?php

namespace Deployer;

/**
 * Created by PhpStorm.
 * User: Hiệp Nguyễn
 * Date: 27/04/2022
 * Time: 13:33
 */

desc("restart pm2 task");
task("pm2:restart", pm2_restart());

function pm2_restart(): \Closure
{
    return static function () {
        $pm2_tasks = get("pm2_tasks", []);
        if (count($pm2_tasks) > 0) {
            foreach ($pm2_tasks as $pm2_task) {
                if (test("test -f {{release_path}}/$pm2_task")) {
                    run("cd {{release_path}} && pm2 flush && pm2 restart $pm2_task");
                } else {
                    writeln("$pm2_task does not exists");
                }
            }
        }
    };
}
