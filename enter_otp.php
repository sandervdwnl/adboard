<?php

// Check if otp in mail == otp in db
// Check if timestamp send (+ 5min) does not exceed time()
// If ok, send to new pw form

require_once 'inc/header.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    require_once 'inc/dbc.inc.php';

    $otp_form = ($_POST['otp']);

    if (strlen(trim($otp_form)) == 6 && preg_match("/^[a-z0-9]+$/", $otp_form)) {

        $stmt = $connection->prepare('SELECT * from users WHERE otp = ?');
        $stmt->execute([$otp_form]);
        $row = $stmt->fetch();

        if (!empty($row)) {

            $otp_db = $row['otp'];

            $otp_send = $row['otp_send'];

            $now = time();

            // If Timestamp send + 5min is smaller then NOW, OTP invalid
            if ($otp_send < $now) {
                $error = 7;
            } else {

                if ($otp_db == $otp_form) {
                    $url = 'change_pw.php?postotp=' . $otp_form;
                    header('Location: ' . $url);

                    unset($connection);
                } else {

                    $error = 8;
                }
            }
        } else {
            $error = 8;
        }
    } else {
        $error = 8;
    }
}
unset($connection);


?>

<h1 class="text-center">Enter OTP</h1>

<div class="container">
    <div class="row">

        <!-- FORM -->

        <div class="col-md-6 offset-3">

            <form action="enter_otp.php" method="POST">

                <label for="Email" class="form-label">OTP:</label>
                <input type="text" name="otp" class="form-control" value="" minlength="6" maxlength="6" required>

                <button type="submit" class="btn btn-primary mt-4">Submit</button>

            </form>

            <div class="error mt-2">
                <?php

                if (isset($error)) {

                    switch ($error) {
                        case 0:
                            echo "<p></p>";
                            break;
                        case 2:
                            echo '<pre class="warning">Please fill in all fields.</pre>';
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
                        case 7:
                            echo '<p class="warning">OTP validation time passed. Please <a href="request_pw_reset.php">request a new OTP.</p>';
                            break;
                        case 8:
                            echo '<p class="warning">OTP is incorrect. Please try again or <a href="request_pw_reset.php">request a new OTP.</a></p>';
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
