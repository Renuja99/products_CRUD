<h1 class="header center orange-text">Product List</h1>
<div class="row left-align">
    <a href="products/create" class="btn-large waves-effect waves-light cursorsHover amber darken-3"><b>Create </b></a>
</div>


<?php

// echo '<pre>';
// var_dump($products);
// echo '</pre>';

?>

<table class="striped responsive-table">
    <tr>
        <th></th>
        <th>Title</th>
        <th>Image</th>
        <th>Price</th>
        <th>Created date</th>
        <th style="width:200px;">Action</th>
    </tr>
    <?php foreach ($products as $i => $product) { ?>

        <tr>
            <td><?php echo $i + 1 ?></td>
            <td><?php echo $product['title'] ?></td>
            <td>
                <?php if ($product['image']) : ?>
                    <img src="<?php echo $product['image'] ?>" style="width: 100px;">
                <?php endif; ?>
            </td>
            <td><?php echo $product['price'] ?></td>
            <td><?php echo $product['create_date'] ?></td>
            <td style="display: flex; justify-content:space-between ">
                <a href="/products/update?id=<?php echo $product['id']; ?>" class="waves-effect waves-light btn">Edit</a>
                <form action="/products/delete" method="post">


                    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                    <button type="submit" class="waves-effect waves-light btn red">Delete</button>
                </form>


            </td>

        </tr>
    <?php } ?>
</table>