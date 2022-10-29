<?php
/**
 * Created by PhpStorm.
 * User: Hiệp Nguyễn
 * Date: 25/11/2021
 * Time: 11:49
 */

$server_files = glob(__DIR__ . "/stages/*/conf.d/server.php");

foreach ($server_files as $server_file) {
    include_once $server_file;
}