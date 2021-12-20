<?php
$action = $_GET['action'];

switch ($action) {
    case "status":
        $status = opcache_get_status(false);
        echo "<pre>";
        print_r($status);
        break;
    case "reset":
        opcache_reset();
        $status = opcache_get_status(false);
        echo "<pre>";
        print_r($status);
        break;
}