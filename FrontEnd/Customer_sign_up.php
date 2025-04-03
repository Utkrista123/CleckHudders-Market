<?php
    session_start();
    require '../vendor/autoload.php'; // Load PHPMailer
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    if(isset($_POST['signup'])){
        $name = $_POST['name'];
        $email = $_POST['email'];

        $otp = sendConfirmationEmail($email, $name);
        if($otp){
            $_SESSION['otp'] = $otp;
            $_SESSION['email'] = $email;
            $_SESSION['otp_expire'] = time() +240;
            header("Location: verify-otp.php");
            exit();
        }else{
            echo "Error sending email.";
        }
    }

    function sendConfirmationEmail($email, $name){
        $mail = new PHPMailer(true);
        $otp = rand(10000, 99999); // Generates a 5 digit OTP

        try{
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'utkristashrestha984@gmail.com';
            $mail->Password = 'smvt hrux xvhu hgmr';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('utkristashrestha984@gmail.com', 'CheckHudders Market');
            $mail->addAddress($email, $name);

            $mail->isHTML(true);
            $mail->Subject = 'Sign up Confirmation';
            $mail->Body = "<h1>Welcome, $name!</h1><p>Your OTP is: <strong>$otp</strong></p>";

            $mail->send();
            return $otp;
        }catch(Exception $e){
            echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
            return false;
        }

    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="signupcss.css">
</head>
<body>
    <div class="background">
        <div class="overlay"></div>
    </div>
    
    <div class="signup-container">
        <h2>GETTING STARTED</h2>
        <p>CREATE A NEW ACCOUNT</p>
        
        <form action="" method="POST">
            <input type="text" name="name" placeholder="Full Name" required>
            
            <div class="contact-container">
                <input type="text" class="contact-code" placeholder="+44" required readonly>
                <input type="text" name="Phone Number" class="contact-input" placeholder="Enter Contact Number" required>
            </div>

            <input type="email" name="email" placeholder="Someone@gmail.com" required>

            <input type="password" name="password" placeholder="Password" required>

            <input type="password" name="password" placeholder="Confirm Password" required>

            <div class="terms">
                <input type="checkbox" required>
                <span>I agree to the Terms of Service and Privacy Policy.</span>
            </div>

            <div>
                <button type="submit" name="signup">Create an Account</button>
            </div>

            <p>OR</p>
        <div class="social-icons">
            <img src="image/google.svg" width="10" height="10" alt="Google">
            <img src="image/apple.svg"  alt="Apple">
            <img src="image/facebook.svg" alt="Facebook">
        </div>

        <p>Already have an account? <a href="login.php">Log in</a></p>
        </form>

    </div>
</body>
</html>


