<?php

namespace APP1;

require_once '../app1/Routes/ProductRoutes.php';

use app1\routes\ProductRoutes;

$request_method = $_SERVER['REQUEST_METHOD'];
$request_uri = $_SERVER['REQUEST_URI'];

// Handle Product Routes
$ProductRoutes = new ProductRoutes();
$ProductRoutes->handle($request_method, $request_uri);
?>
