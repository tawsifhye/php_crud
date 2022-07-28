<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: index.php');
    exit;
}

$statement = $pdo->prepare('SELECT * FROM products WHERE id = :id');
$statement->bindValue(':id', $id);
$statement->execute();
$product = $statement->fetch(PDO::FETCH_ASSOC);

$errors = [];
$title = $product['title'];
$description = $product['description'] ?? '';
$price = $product['price'];
$imagePath = $product['image'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $imagePath = $product['image'] ?? 'tf';
    if (!$title) {
        $errors[] = 'Product title is required';
    }
    if (!$price) {
        $errors[] = 'Product price is required';
    }

    if (!is_dir('images')) {
        mkdir('images');
    }

    if (empty($errors)) {
        $image = $_FILES['image'] ?? null;
        $imagePath = $product['image'];

        if ($image && $image['tmp_name']) {
            if ($product['image']) {
                unlink($product['image']);

            }
            $imagePath = 'images/' . randomString(8) . '/' . $image['name'];
            mkdir(dirname($imagePath));
            var_dump($imagePath);

            move_uploaded_file($image['tmp_name'], $imagePath);
        }
        try {
            $statement = $pdo->prepare("UPDATE products SET title =:title, description=:description, image=:image, price:=price WHERE id=:id");

            $statement->bindValue(':title', $title);
            $statement->bindValue(':description', $description);
            $statement->bindValue(':image', $imagePath);
            $statement->bindValue(':price', $price);
            $statement->bindValue(':id', $id);
            $statement->execute();

            // header('Location: index.php');
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }

    }

}

function randomString($n)
{
    $characters = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $str = '';

    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $str .= $characters[$index];
    }

    return $str;
}
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
    <h1>Update Product <strong><?php echo $product['title'] ?></strong></h1>
    <?php if (!empty($errors)): ?>
      <div class="alert alert-warning" role="alert">
      <?php foreach ($errors as $error) {?>
       <strong>
         <?php echo $error ?> <br>
       </strong>
      <?php }?>
    </div>
      <?php endif?>



    <form action="" method="post" enctype="multipart/form-data">
  <?php if ($product['image']): ?>
    <img src="<?php echo $product['image'] ?>" alt="">
    <?php endif?>
    <div class="form-group">
    <label>Product Image</label>
    <br>
    <input type="file" name="image">
</div>
  <div class="form-group">
    <label>Product Title</label>
    <input type="text" class="form-control" name="title" value="<?php echo $title ?>">
</div>
  <div class="form-group">
    <label>Description</label>
    <textarea class="form-control" name="description">
    <?php echo $description ?>
</textarea>
</div>

<div class="form-group">
    <label>Price</label>
    <input type="number" step = ".01" name="price" class="form-control" value="<?php echo $price ?>" >
</div>

  <button type="submit" class="btn btn-primary">Submit</button>
</form>
<a name="" id="" class="btn btn-warning mt-3" href="index.php" role="button">Show Products</a>
  </body>
</html>