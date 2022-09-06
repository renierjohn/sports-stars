<?php
include('vendor/autoload.php');

use App\Request;
use App\Response;
use App\Controllers\PlayerController;

$request  = new Request();

$response = new Response($request);
echo $response->send();
