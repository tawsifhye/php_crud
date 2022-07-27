<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$statement = $pdo->prepare('SELECT * FROM products ORDER BY create_date DESC');
$statement->execute();
$products = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="assets/style/style.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>PHP Crud</title>
  </head>
  <?php
function test()
{
    echo 'Hello';
}
?>
  <body>
    <h1>Product Crud</h1>
      <a href="create.php"type="button" class="btn btn-success mb-3">Add Product</a>
  <table class="table">
    <thead>
      <tr>
        <th>#</th>
        <th>Image</th>
        <th>Title</th>
        <th>Description</th>
        <th>Price</th>
        <th>Create Date</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($products as $i => $product) {?>
       <tr>
       <td scope="row"><?php echo $i + 1 ?></td>
       <td><img src="<?php echo $product['image'] ?>" alt=""></td>
       <td><?php echo $product['title'] ?></td>
       <td><?php echo $product['description'] ?></td>
       <td><?php echo $product['price'] ?></td>
       <td><?php echo $product['create_date'] ?></td>
       <td>
        <button type="button" class="btn btn-sm btn-outline-primary">Edit</button>
        <a href="delete.php?id=<?php echo $product['id'] ?>" type="button" class="btn btn-sm btn-outline-danger" data-toggle="button" aria-pressed="false" autocomplete="off">Delete</a>
       </td>
     </tr>
     <?php }?>
    </tbody>
  </table>

  </body>
</html>
