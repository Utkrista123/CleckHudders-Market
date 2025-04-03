<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;

if (!isset($_SESSION['email'])) {
    header("Location: sign-up.php");
    exit();
}

// Check if otp_expiry is set before using it
$timeRemaining = isset($_SESSION['otp_expiry']) ? $_SESSION['otp_expiry'] - time() : 240;
if ($timeRemaining <= 0) {
    unset($_SESSION['otp']); // OTP expired
}

if(isset($_POST['verify'])){
    if (!isset($_SESSION['otp'])) {
        echo "<script>alert('OTP not set. Please request a new OTP.');</script>";
    } else {
        $enteredOtp = $_POST['otp'];
        if ($enteredOtp == $_SESSION['otp']) {
            echo "<script>alert('OTP Verified! Redirecting to Login.'); window.location.href='login.php';</script>";
            session_destroy();
            exit();
        } else {
            echo "<script>alert('Invalid OTP!');</script>";
        }
    }
}

if(isset($_POST['resend'])){
    require '../vendor/autoload.php';
    $newOtp = rand(10000, 99999);
    $_SESSION['otp'] = $newOtp;
    $_SESSION['otp_expiry'] = time() + 240; // Initialize otp_expiry

    $mail = new PHPMailer(true);
    try{
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'utkristashrestha984@gmail.com';
        $mail->Password = 'smvt hrux xvhu hgmr';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('utkristashrestha984@gmail.com', 'CheckHudders Market');
        $mail->addAddress($_SESSION['email']);

        $mail->isHTML(true);
        $mail->Subject = 'Resend OTP';
        $mail->Body = "<h1>Your new OTP is:</h1><p><strong>$newOtp</strong></p>";

        $mail->send();
        echo "<script>alert('New OTP Sent!');</script>";
    } catch(Exception $e) {
        echo "<script>alert('Error sending OTP: {$mail->ErrorInfo}');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <script>
        let timeLeft = <?php echo $timeRemaining; ?>;
        
        function updateTimer() {
            if (timeLeft > 0) {
                document.getElementById('timer').innerText = `Time Left: ${timeLeft} sec`;
                timeLeft--;
                setTimeout(updateTimer, 1000);
            } else {
                document.getElementById('resend-section').style.display = 'block';
                document.getElementById('otp-form').style.display = 'none';
            }
        }

        window.onload = updateTimer;
    </script>
</head>
<body>
    <h2>Enter OTP</h2>
    <p id="timer">Time Left: <?php echo $timeRemaining; ?> sec</p>

    <form id="otp-form" action="" method="POST">
        <input type="text" name="otp" placeholder="Enter OTP" required>
        <button type="submit" name="verify">Verify OTP</button>
    </form>

    <div id="resend-section" style="display: none;">
        <form action="" method="POST">
            <button type="submit" name="resend">Resend OTP</button>
        </form>
        <form action="login.php" method="POST">
            <button type="submit">Go to Login</button>
        </form>
    </div>
</body>
</html>