<?php

namespace app;

use PDO;
use app\models\Product;

class Database
{
    public PDO $pdo;
    public static Database $db; //singleton

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=127.0.0.1;dbname=products_crud', 'root', '');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //$this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_BOTH);


        self::$db = $this;
    }

    public function getProducts($search = '')
    {

        if ($search) {
            $statement = $this->pdo->prepare('SELECT * FROM products_table WHERE title LIKE :title ORDER BY create_date DESC');
            $statement->bindValue(':title', "%$search%");
        } else {


            $statement = $this->pdo->prepare('SELECT * FROM products_table ORDER BY create_date DESC');
        }

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($id)
    {
        $statement = $this->pdo->prepare('SELECT * FROM products_table WHERE id=:id');
        $statement->bindValue(':id', $id);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function createProduct(Product $product)
    {
        $statement = $this->pdo->prepare("INSERT INTO products_table(title,image,price, description, create_date) VALUES( :title,:image,:price,:description, :date)");

        $statement->bindValue(':title', $product->title);
        $statement->bindValue(':image', $product->imagePath);
        $statement->bindValue(':price', $product->price);
        $statement->bindValue(':description', $product->description);
        $statement->bindValue(':date', date('Y-m-d H:i:s'));
        $statement->execute();
    }

    public function updateProduct(Product $product)
    {

        $statement = $this->pdo->prepare("UPDATE products_table SET title= :title ,image = :image ,price= :price, description =:description WHERE id=:id");

        $statement->bindValue(':title', $product->title);
        $statement->bindValue(':image', $product->imagePath);
        $statement->bindValue(':price', $product->price);
        $statement->bindValue(':description', $product->description);
        $statement->bindValue(':id', $product->id);
        //$statement->bindValue(':date', date('Y-m-d H:i:s'));
        $statement->execute();
    }

    public function deleteProduct($id)
    {
        $statement = $this->pdo->prepare("DELETE FROM products_table WHERE id=:id");
        $statement->bindValue(':id', $id);
        $statement->execute();
    }
}
