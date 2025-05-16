<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$error = "";

// Handle OTP submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['otp']) || !is_array($_POST['otp'])) {
        $error = "Invalid OTP format.";
    } else {
        // Combine the 6 digits into one OTP string
        $entered_otp = implode("", array_map('trim', $_POST['otp']));

        if (isset($_SESSION['otp']) && isset($_SESSION['otp_expiry'])) {
            if (time() > $_SESSION['otp_expiry']) {
                $error = "OTP has expired. Please request a new one.";
                unset($_SESSION['otp']);
                unset($_SESSION['otp_expiry']);
            } elseif ($entered_otp === $_SESSION['otp']) {
                $_SESSION['otp_verified'] = true;

                // Use hidden form to redirect to register_process.php with POST
                echo '<form id="otp-redirect" method="POST" action="register_process.php">';
                echo '<input type="hidden" name="otp_verified" value="true">';
                echo '</form>';
                echo '<script>document.getElementById("otp-redirect").submit();</script>';
                exit();
            } else {
                $error = "Invalid OTP. Please try again.";
            }
        } else {
            $error = "No OTP session found. Please request a new one.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>OTP Verification</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-size: 12.8px;
            font-weight: 700;
        }

        button {
            width: 380px;
            padding: 20px 20px;
            border-radius: 11px;
            border: none;
            background: rgb(254, 148, 74);
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        /* Background Image with Overlay */
        .background {
            position: absolute;
            width: 100%;
            height: 70%;
            top: 0;
            left: 0;
            background:
                linear-gradient(rgba(2, 158, 156, 0.67), rgba(2, 158, 156, 0.67)),
                url('image/fresh.jpg');
            background-size: cover;
            background-position: center center;
            z-index: -1;
            clip-path: polygon(0 0, 100% 0, 100% 60%, 0 100%);
        }

        .otp-container {
            position: relative;
            width: 398px;
            padding: 20px;
            background: rgb(255, 255, 255);
            border-radius: 20px;
            box-shadow: 0px 0px 10px 14px rgba(97, 96, 96, 0.33);
            text-align: center;
            z-index: 1;
        }

        .otp-container a {
            color: rgb(254, 148, 74);
            text-decoration: none;
            transition: 0.15s;
        }

        .otp-container a:hover {
            color: rgb(236, 136, 83);
        }

        .otp-container h2 {
            margin-bottom: 10px;
        }

        .otp-inputs {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 20px 0;
        }

        .otp-inputs input {
            width: 40px;
            height: 50px;
            font-size: 24px;
            text-align: center;
            border: solid;
            border-radius: 8px;
            border-width: 1px;
        }

        .error {
            color: red;
            margin-bottom: 15px;
        }

        .resend {
            margin-top: 10px;
        }

        button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }

        img.otp-image {
            width: 100px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

    <div class="background">
        <div class="overlay"></div>
    </div>

    <div class="otp-container">
        <img src="image/otp-image.png" alt="OTP Image" class="otp-image">
        <h2>Verify Your Account</h2>
        <p>Enter the 6-digit OTP sent to your email.</p>

        <?php if ($error): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form method="POST" action="otp_verify_page.php">
            <div class="otp-inputs">
                <?php for ($i = 0; $i < 6; $i++): ?>
                    <input type="text" name="otp[]" maxlength="1" pattern="\d" required>
                <?php endfor; ?>
            </div>
            <button type="submit">Verify</button>
        </form>

        <p class="resend">Didn't receive the OTP? <a href="resend_otp.php">Resend OTP</a></p>
    </div>

    <script>
        const inputs = document.querySelectorAll(".otp-inputs input");

        inputs.forEach((input, index) => {
            input.addEventListener("input", (e) => {
                const value = e.target.value;
                if (value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });

            input.addEventListener("keydown", (e) => {
                if (e.key === "Backspace" && index > 0 && !e.target.value) {
                    inputs[index - 1].focus();
                }
            });
        });

        inputs[0].focus(); // Auto-focus on first input
    </script>

</body>

</html>