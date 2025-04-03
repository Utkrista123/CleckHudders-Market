<?php
session_start();
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = []; // Initialize cart if not set
}

if(isset($_POST['add_to_cart'])){
    $name = $_POST['name'];
    $price = $_POST['price'];

    // Check if item already exists in cart
    $found = false;
    foreach($_SESSION['cart'] as &$item){
        if($item['name'] = $name){
            $item['quantity'] += 1;
            $found = true;
            break;
        }
    }
    if(!$found){
        $_SESSION['cart'][] = ['name' => $name, 'price' => $price, 'quantity' =>1];
    }

    header("Location: cart.php");
    exit();
}
?>

<h1>Your Cart</h1>
<?php
    if(!empty($_SESSION['cart']))
?>
