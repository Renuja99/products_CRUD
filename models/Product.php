<?php

namespace app\models;

use app\Database;
use app\helpers\UtilHelper;


class Product
{
    public ?int $id = null;
    public ?string $title = null;
    public ?string $description = null;
    public ?string $imagePath = null;
    public ?float $price = null;
    public ?array $imageFile = null;

    public function load($data)
    {
        $this->id = $data['id'] ?? null;
        $this->title = $data['title'];
        $this->description = $data['description'] ?? '';
        $this->price = $data['price'];
        $this->imageFile = $data['imageFile'] ?? '';
        $this->imagePath = $data['imagePath'] ?? '';
    }

    public function save()
    {
        $errors = [];
        if (!$this->title) {
            $errors[] = 'Product title is required';
        }

        if (!$this->price) {
            $errors[] = 'Product price is required';
        }

        if (!is_dir(__DIR__ . '/../public/images')) {

            mkdir(__DIR__ . '/../public/images');
        }

        if (empty($errors)) {


            if ($this->imageFile && $this->imageFile['tmp_name']) {
                if ($this->id && $this->imageFile['tmp_name']) {

                    $this->deleteImageDirectory($this->imagePath);
                }

                $this->imagePath = 'images/' . UtilHelper::randomString(9) . '/' . $this->imageFile['name'];

                mkdir(dirname(__DIR__ . '/../public/' . $this->imagePath));


                move_uploaded_file($this->imageFile['tmp_name'], __DIR__ . '/../public/' . $this->imagePath);
            }


            $db = Database::$db;
            if ($this->id) {

                $db->updateProduct($this);
            } else {
                $db->createProduct($this);
            }
        }
        return $errors;
    }

    public function deleteImageDirectory(string $imagePath)
    {

        unlink(__DIR__ . '/../public/' . $imagePath);
        rmdir(dirname(__DIR__ . '/../public/' . $imagePath));
    }
}
