<?php

use Shappy\Http\Kernel;
use Shappy\Http\Request;

session_start();

require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/config.php";
require_once __DIR__ . "/globals.php";

$request = Request::capture();

$kernel = new Kernel;
$response = $kernel->handle($request);
$response->send();
