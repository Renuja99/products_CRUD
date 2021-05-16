<h1>Update</h1>
<?php if (!empty($errors)) {

    foreach ($errors as $error) {

        echo $error . '<br>';
    }
} ?>

<form action="/products/update" method="post" enctype="multipart/form-data">
    <label for="img">Product image:</label><br>
    <input type="file" id="image" name="image" value="Insert Image"><br>

    <label for="name">Product title:</label><br>
    <input type="text" id="title" name="title" value="<?php echo $product['title'] ?>"><br>

    <label for="name">Product description:</label><br>
    <input type="text" id="title" name="description" value="<?php echo $product['description'] ?>"><br>

    <label for="price">Product price:</label><br>
    <input type="text" id="price" name="price" value="<?php echo $product['price'] ?>"><br>

    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
    <button type="submit" class="waves-effect waves-light btn red">Edit</button>
</form>