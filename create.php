<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$errors = [];
$title = '';
$description = '';
$price = '';
$imagePath = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $date = date('Y-m-d H:i:s');
    $imagePath = '';
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

        if ($image) {
            $imagePath = 'images/' . randomString(8) . '/' . $image['name'];
            mkdir(dirname($imagePath));
            var_dump($imagePath);

            move_uploaded_file($image['tmp_name'], $imagePath);
        }
        try {
            $statement = $pdo->prepare("INSERT INTO products (title, description, image, price, create_date)
                VALUES (:title, :description, :image , :price, :date)");

            $statement->bindValue(':title', $title);
            $statement->bindValue(':image', $imagePath);
            $statement->bindValue(':description', $description);
            $statement->bindValue(':price', $price);
            $statement->bindValue(':date', $date);
            $statement->execute();
            header('Location: index.php');
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
    <h1>Add Product</h1>
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
    <textarea class="form-control" name="description" value="<?php echo $description ?>"></textarea>
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
