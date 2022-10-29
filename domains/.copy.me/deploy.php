<?php
/**
 * Created by PhpStorm.
 * User: Hiệp Nguyễn
 * Date: 25/11/2021
 * Time: 11:49
 */

namespace Deployer;

require __DIR__ . "/servers.php";

task("$domain:upload", function () {
    $stage = input()->getArgument('stage') ?: get("stage");
    invoke("$stage:upload");
});

$stages = glob(__DIR__ . "/stages/*", GLOB_ONLYDIR);
foreach ($stages as $stage) {
    $stage = str_replace(__DIR__ . "/stages/", "", $stage);
    task("$domain:$stage:upload", upload_file(__DIR__ . "/stages/$stage"));
}