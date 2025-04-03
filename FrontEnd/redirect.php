<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_type = $_POST['user_type'];

    if ($user_type == "customer") {
        header("Location: Customer_sign_up.php");
        exit();
    } elseif ($user_type == "trader") {
        header("Location: Trader_sign_up.php");
        exit();
    } else {
        echo "Invalid selection!";
    }
}
?>
