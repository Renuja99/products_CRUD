<?php

namespace app\controllers;

use app\models\Product;
use app\Router;

class ProductController
{

    public function index(Router $router)
    {
        $search = $_GET['search'] ?? '';

        $products = $router->db->getProducts($search);

        $router->renderView(
            'products/index',
            [
                'products' => $products
            ]
        );
        // echo '<pre>';
        // var_dump($products);
        // echo '</pre>';
        // echo '<pre>';
        // var_dump($router->getRoutes);
        // echo '</pre>';

    }

    public function create(Router $router)
    {
        $errors = [];
        $productData = [
            'title' => '',
            'description' => '',
            'imageFile' => '',
            'price' => '',
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $productData['title'] = $_POST['title'];
            $productData['description'] = $_POST['description'];
            $productData['price'] = (float)$_POST['price'];
            $productData['imageFile'] = $_FILES['image'] ?? null;

            $product = new Product();
            $product->load($productData);
            $errors = $product->save();
            if (empty($errors)) {
                header('Location: /products');
                exit;
            }
        }
        $router->renderView('products/create', [
            'product' => $productData,
            'errors' => $errors
        ]);
    }

    public function update(Router $router)
    {
        $method = $_SERVER['REQUEST_METHOD'];

        $id = $_GET['id'] ?? null;
        $errors = [];
        if ($method === 'GET') {


            if (!$id) {
                header('Location: /products');
                exit;
            }

            $productData = $router->db->getProductById($id);
            $router->renderView(
                'products/update',
                [
                    'product' => $productData,
                    'errors' => $errors,
                ]

            );
        } else {

            $productData = [
                'id' => '',
                'title' => '',
                'description' => '',
                'imageFile' => '',
                'price' => '',
                'imagePath' => ''
            ];

            $productData['id'] = $_POST['id'];
            $productData['title'] = $_POST['title'];
            $productData['description'] = $_POST['description'];
            $productData['price'] = (float)$_POST['price'];
            $productData['imageFile'] = $_FILES['image'] ?? null;

            //get image path from database
            $productInfo = $router->db->getProductById($productData['id']);
            $productData['imagePath'] = $productInfo['image'];

            $product = new Product();
            $product->load($productData);
            $errors = $product->save();
            if (empty($errors)) {
                header('Location: /products');
                exit;
            } else {
                $router->renderView(
                    'products/update',
                    [
                        'product' => $productData,
                        'errors' => $errors,
                    ]

                );
            }
        }
    }

    public function delete(Router $router)
    {
        $product = [

            'imagePath' => ''

        ];

        $id = $_POST['id'] ?? null;
        $productData = $router->db->getProductById($id);
        $product['imagePath'] = $productData['image'];

        $deleteImageProduct = new Product();
        $deleteImageProduct->deleteImageDirectory($product['imagePath']);
        if (!$id) {
            header('Location: /products');
            exit;
        } else {
            $router->db->deleteProduct($id);
            header('Location: /products');
        }

        // echo $router->renderView('products/update');
    }
}
