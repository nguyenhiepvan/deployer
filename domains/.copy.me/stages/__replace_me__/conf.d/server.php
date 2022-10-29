<?php
/**
 * Created by PhpStorm.
 * User: Hiệp Nguyễn
 * Date: 04/05/2022
 * Time: 13:57
 */

use Illuminate\Support\Arr;
use function Deployer\host;

$ip = "__REPLACE_ME__";
preg_match("/\/domains\/(?<domain>.*)\/stages\/(?<stage>.*)\/conf.d/u", __DIR__, $matches);
$domain = Arr::get($matches, "domain");
$stage  = Arr::get($matches, "stage");
host("$domain:$stage")
    ->hostname($ip)
    ->stage("$domain:$stage")
    ->set("domain", $domain)
    ->roles([$domain])
    ->port("__REPLACE_ME__")
    ->user("__REPLACE_ME__")
    ->set("branch", "__REPLACE_ME__")
    ->set("deploy_path", "__REPLACE_ME__")
    ->set('shared_files', [])
    ->set("web_url", "__REPLACE_ME__")
    ->set("web_ip", "__REPLACE_ME__")
    ->set("bin/php", "__REPLACE_ME__")
    ->set("application", "__REPLACE_ME__")
    ->set("repository", "__REPLACE_ME__")
    ->set("release_domain", "__REPLACE_ME__");