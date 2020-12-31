<?php

require_once 'inc/header.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    require_once 'inc/dbc.inc.php';

    $new_password = $_POST['password'];

    $post_otp = $_POST['postotp'];

    if (strlen($new_password) > 9) {

        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $stmt = $connection->prepare('UPDATE users SET password = ? WHERE otp = ?');
        $stmt->execute([$hashed_password, $post_otp]);
        $rowCount = $stmt->rowCount();

        if ($rowCount > 0) {

            $url = 'login.php?status=pwresetok';
            header('Location: ' . $url);
        } else {
            'error:<br>';
            var_dump($rowCount);

            // $url = 'change_pwd?error=9&postotp=' . $post_otp;
            // header('Location: ' . $url);
        }
    } else {
        $url = 'change_pwd?error=4&postotp=' . $post_otp;
        header('Location: ' . $url);
    }
}
unset($connection);


?>

<h1 class="text-center">Enter New Password</h1>

<div class="container">
    <div class="row">

        <!-- FORM -->

        <div class="col-md-6 offset-3">

            <form action="change_pw.php" method="POST">

                <label for="Password" class="form-label">New Password:</label>
                <input type="password" class="form-control" id="password" name="password" minlength="10" required>
                <input type="checkbox" name="checkbox" id="show-pw" onclick="showPass()"> Show password<br>


                <input type="hidden" name="postotp" value="<?php echo $_GET['postotp']; ?>">

                <button type="submit" class="btn btn-primary mt-4">Change Password</button>

            </form>

            <div class="error mt-2">
                <?php

                if (isset($_GET['error'])) {

                    switch ($_GET['error']) {
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
                        case 9:
                            echo '<p class="warning">Password update failed. Please try again or contact the webmaster.</a></p>';
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
