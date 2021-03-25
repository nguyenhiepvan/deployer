<?php
define("DEPLOYER_BIN",exec("which dep"));

define("VERBOSITIES", [
    "VERBOSE"      => "-v",
    "VERY_VERBOSE" => "-vv",
    "DEBUG"        => "-vvv",
]);

define("CHILDS", [
    ["name" => "This is example", "folder" => __DIR__ . "/example.com", "stage" => "development"],
]);