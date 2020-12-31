<?php

require_once 'inc/header.inc.php';



if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    require_once 'inc/dbc.inc.php';

    $email = trim($_POST['email']);

    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {

        $stmt = $connection->prepare('SELECT * FROM users WHERE email = ? ');
        $stmt->execute([$email]);
        $rowCount = $stmt->rowCount();

        if ($rowCount > 0) {

            $otp = random_bytes(10);
            $otp = bin2hex($otp);
            $otp = substr($otp, 0, 6);

            $otp_send = time() + 300;

            $stmt = $connection->prepare('UPDATE users SET otp = ?, otp_send = ? WHERE email = ?');
            $stmt->execute([$otp, $otp_send, $email]);
            $rowCount = $stmt->rowCount();

            if ($rowCount == 1) {

                $to = $email;
                $subject = 'Password Reset OTP';
                $message = '
                <html>
                <head>
                <title>Password Reset OTP</title>
                </head>
                <body>
                <h3>Dear user</h3>
                <p>Hereby you receive your OTP.
                Enter this code to reset your password.
                This code will be valid for 5 minutes.
                </p>
                <h2>' . $otp . '</h2>
                <p>
                Kind regards,<br>
                Adboards webmaster
                </p>
                </html>';

                // To send HTML mail, the Content-type header must be set
                $additional_headers[] = 'MIME-Version: 1.0';
                $additional_headers[] = 'Content-type: text/html; charset=iso-8859-1';

                mail($to, $subject, $message, implode("\r\n", $additional_headers));

                $url = 'enter_otp.php';
                header("Location: " . $url);
            }
        } else {
            $error = 5;
        }
    } else {
        $error = 3;
    }
}
unset($connection);


?>

<h1 class="text-center">Request Password Reset</h1>

<div class="container">
    <div class="row">

        <!-- FORM -->

        <div class="col-md-6 offset-3">

            <form action="request_pw_reset.php" method="POST">

                <label for="Email" class="form-label">Email:</label>
                <input type="email" name="email" class="form-control" value="<?php if (isset($email)) {
                                                                                    echo $email;
                                                                                } ?>" minlength="6" required>

                <button type="submit" class="btn btn-primary mt-4">Request Reset</button>

            </form>

            <div class="error mt-2">
                <?php

                if (isset($error)) {

                    switch ($error) {
                        case 0:
                            echo "<p></p>";
                            break;
                        case 2:
                            echo '<p class="warning">Please fill in all fields.</p>';
                            break;
                        case 3:
                            echo '<p class="warning">Please use a valid email adress.</p>';
                            break;
                        case 4:
                            echo '<p class="warning">Please use a password with a minimal length of 10 characters.</p>';
                            break;
                        case 5:
                            echo '<p class="warning">Email adress not found.</p>';
                            break;
                        case 6:
                            echo '<p class="warning">Username or password incorrect. Please try again or register a new user.</p>';
                            break;
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php



require_once 'inc/footer.inc.php';
