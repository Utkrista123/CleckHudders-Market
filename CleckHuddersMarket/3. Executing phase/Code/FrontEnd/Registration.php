<?php
    require 'vendor/autoload.php'; // Load PHPMailer
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    if(isset($_POST['signup'])){
        $name = $_POST['name'];
        $email = $_POST['email'];

        sendConfirmationEmail($email, $name);
        echo "Sign-up successful! A confirmation email has been sent.";
    }

    function sendConfirmationEmail($email, $name){
        
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Sign Up</h2>
    <form action="signup.php" method="POST">
        <div>
            <p>User Name</p>
            <input type="text" name="name" placeholder="Full Name" required>
        <div>
            <p>Phone Number</p>
            <input type="text" name="Phone Number" required>
        </div>

        <div>
            <p>E-mail</p>
            <input type="email" name="email" placeholder="Someone@gmail.com" required>
        </div>

        <div>
            <p>Password</p>
            <input type="password" name="password">
        </div>

        <div>
            <p>Confirm Password</p>
            <input type="password" name="password">
        </div>

        <div>
            <button type="submit" name="signup">Sign Up</button>
        </div>
    </form>
</body>
</html>


