<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$title = $_POST['title'] ?? '';
$description = $_POST['description'] ?? '';
$price = $_POST['price'] ?? '';
$date = date('Y-m-d H:i:s');
// $sql = "INSERT INTO users (name, surname, sex) VALUES (?,?,?)";
// $stmt= $pdo->prepare($sql);
// $stmt->execute([$name, $surname, $sex]);

try {
    $pdo->exec("INSERT INTO products (id,title, image, description, price, create_date)
                VALUES ('id','$title','', '$description', $price, '2022-07-26 14:42:58')");
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// echo "<pre>";
// var_dump($_POST);
// echo "</pre>";
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
  <body>
    <h1>Add Product</h1>
    <form action="" method="post">
  <div class="form-group" >
    <label>Product Image</label>
    <br>
    <input type="file" name="image">
</div>
  <div class="form-group">
    <label>Product Title</label>
    <input type="text" class="form-control" name="title">
</div>
  <div class="form-group">
    <label>Description</label>
    <textarea class="form-control" name="description"></textarea>
</div>

<div class="form-group">
    <label>Price</label>
    <input type="number" step = ".01" name="price" class="form-control">
</div>

  <button type="submit" class="btn btn-primary">Submit</button>
</form>
  </body>
</html>
