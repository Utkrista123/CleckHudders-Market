<?php
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post" autocomplete="off">
        <input type="email" name="email" placeholder="Someone@gmail.com" >
        <input type="password" name="password" >
        <button type="submit">login</button>
        <button type="submit"><a href=""> Sign up</a></button>
    </form>
    <?php
        echo "<div>$email</div>";
        echo "<div>$password</div>";
    ?>
</body>
</html>