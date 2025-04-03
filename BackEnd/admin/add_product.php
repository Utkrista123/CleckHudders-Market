<?php
    require '../database/connect.php';

    $conn = getDBConnection();
    if(!$conn) {
        die("Database connection failed");
    }

    if(isset($_POST['add'])){
        $product_name = $_POST['product_name'];
        $product_name = filter_var($product_name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        $description = $_POST['description'];
        $description = filter_var($description, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        $price = $_POST['price'];
        $price = filter_var($price, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        $stock = $_POST['stock'];
        $stock = filter_var($stock, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        $min_order = $_POST['min_order'];
        $min_order = filter_var($min_order, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        $max_order = $_POST['max_order'];
        $max_order = filter_var($max_order, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        $product_status = $_POST['product_status'];
        $product_status = filter_var($product_status, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        $image = $_FILES['product_image']['name'];
        $image = filter_var($image, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $ext = pathinfo($image, PATHINFO_EXTENSION);
        $rename = create_unique_id().'.'.$ext;
        $image_tmp_name = $_FILES['product_image']['tmp_name'];
        $image_size = $_FILES['product_image']['size'];
        $image_folder = 'uploaded_files/'.$rename;

        if($image_size > 2000000){
            $warning_msg[] = 'Image size is too large!';
         }else{
            $add_product = $conn->prepare("INSERT INTO `product`(product_name, description, price, stock, min_order, max_order, product_image, add_date, update_date, product_status) VALUES(?,?,?,?,?,?,?,?,?,?)");
            $add_product->execute([$product_name, $description, $price, $stock, $min_order, $max_order, $rename, $_POST['add_date'], $_POST['update_date'], $product_status]);
            move_uploaded_file($image_tmp_name, $image_folder);
            $success_msg[] = 'Product added!';
         }
     }
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Add Product</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   

<section class="product-form">

   <form action="" method="POST" enctype="multipart/form-data">
      <h3>Product Info</h3>
      
      <p>Product Name <span>*</span></p>
      <input type="text" name="product_name" placeholder="Enter product name" required maxlength="8" class="box">
      
      <p>Description <span>*</span></p>
      <textarea name="description" placeholder="Enter product description" required class="box"></textarea>
      
      <p>Price <span>*</span></p>
      <input type="number" name="price" placeholder="Enter product price" required min="0" class="box">
      
      <p>Stock Quantity <span>*</span></p>
      <input type="number" name="stock" placeholder="Enter stock quantity" required min="0" class="box">
      
      <p>Minimum Order <span>*</span></p>
      <input type="number" name="min_order" placeholder="Enter minimum order quantity" required min="1" class="box">
      
      <p>Maximum Order <span>*</span></p>
      <input type="number" name="max_order" placeholder="Enter maximum order quantity" required min="1" class="box">
      
      <p>Add Date <span>*</span></p>
      <input type="date" name="add_date" required class="box">
      
      <p>Update Date</p>
      <input type="date" name="update_date" class="box">
      
      <p>Product Status <span>*</span></p>
      <input type="text" name="product_status" placeholder="Enter status" required step="0.01" class="box">

      <p>Product Image <span>*</span></p>
      <input type="file" name="product_image" required accept="image/*" class="box">
      
      <input type="submit" class="btn" name="add" value="Add Product">
   </form>

</section>
