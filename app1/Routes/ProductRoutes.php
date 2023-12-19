<?php

namespace app1\routes;

include "../app1/controller/ProductController.php";

use app1\controller\ProductController;

class ProductRoutes
{
    public function handle($method, $path)
    {
        // JIKA REQUEST METHOD GET DAN PATH SAMA DENGAN "/api/products"
        if ($method == 'GET' && $path == '/api/produk') {
            $controller = new ProductController();
            echo $controller->index();
        }

        // JIKA REQUEST METHOD GET DAN PATH MENGANDUNG '/api/products/'
        if ($method == 'GET' && strpos($path, '/api/produk/') === 0) {
            // Extract ID dari path
            $pathParts = explode('/', $path);
            $id = $pathParts[count($pathParts) - 1];
            $controller = new ProductController();
            echo $controller->getById($id);
        }

        // JIKA REQUEST METHOD POST DAN PATH SAMA DENGAN "/api/products"
        if ($method == 'POST' && $path == '/api/produk') {
            $controller = new ProductController();
            echo $controller->insert();            
        }

        // JIKA REQUEST METHOD PUT DAN PATH MENGANDUNG '/api/products/'
        if ($method == 'PUT' && strpos($path, '/api/produk/') === 0) {
            // Extract ID dari path
            $pathParts = explode('/', $path);
            $id = $pathParts[count($pathParts) - 1];
            $controller = new ProductController();
            echo $controller->update($id);
        }

        // JIKA REQUEST METHOD DELETE DAN PATH MENGANDUNG '/api/products/'
        if ($method == 'DELETE' && strpos($path, '/api/produk/') === 0) {
            // Extract ID dari path
            $pathParts = explode('/', $path);
            $id = $pathParts[count($pathParts) - 1];
            $controller = new ProductController();
            echo $controller->delete($id);
        }
    }
}
?>
