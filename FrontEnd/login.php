<?php
session_start();
require_once '../BackEnd/database/dbconnection.php';
 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $db = getDBConnection();

    if ($db) {
        $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
            if ($user['role'] == 'admin') {
                header("Location: admin.php");
            } elseif ($user['role'] == 'trader') {
                header("Location: trader-dashboard.php");
            } elseif ($user['role'] == 'customer') {
                header("Location: http://localhost/Team Project/CleckHuddersMarket/3. Executing phase/Code/FrontEnd/home.php");
            }
            exit();
        } else {
            echo "Invalid email or password.";
        }
    } else {
        echo "Database connection failed.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login form</title>
    <link rel="stylesheet" href="logincss.css">
</head>
<body>

<div class="background">
        <div class="overlay"></div>
</div>
    
<div class="login-container">
    <h2>LOGIN</h2>
    <p>LOG IN TO YOUR ACCOUNT</p>

    <form action="login.php" method="POST">
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
       
        <div class="terms">
            <input type="checkbox">
            <span>Keep me Logged In.</span>
            <div class="forgotpw">
                <a href="#">Forgot Password</a>
            </div>
        </div>
        <button type="submit">Log In</button>
    </form>

    <p>OR</p>
    <div class="social-icons">
        <img src="image/google.svg" width="10" height="10" alt="Google">
        <img src="image/apple.svg" alt="Apple">
        <img src="image/facebook.svg" alt="Facebook">
    </div>

    <p>Don't have an account yet? <a href="user_selection.php">Sign up</a></p>
</div>

</body>
</html>
