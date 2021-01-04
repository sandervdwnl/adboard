<?php

$page = 'login';
$title = 'Login';

require_once 'inc/header.inc.php';

// FORM HANDLING

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    require_once 'inc/dbc.inc.php';

    $error = 0;

    // Check email

    $email = trim($_POST['email']);

    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {

        $password = trim($_POST['password']);

        if (strlen($password) > 9) {

            $stmt = $connection->prepare('SELECT * FROM users WHERE email = ?');
            $stmt->execute([$email]);
            $row = $stmt->fetch();

            if (!empty($row)) {

                $password_db_hash = $row['password'];

                $email_db = $row['email'];

                if (password_verify($password, $password_db_hash) && $email_db === $email) {

                    $_SESSION['user_email'] = $email;

                    unset($connection);

                    header('Location: home.php?status=loggedin');
                } else {
                    $error = 6;
                }
            } else {
                $error = 6;
            }
        } else {
            $error = 4;
        }
    } else {
        $error = 3;
    }
}
unset($connection);

?>

<h1 class="text-center">Login</h1>

<div class="container">
    <div class="row">

        <!-- FORM -->

        <div class="col-md-6 offset-3">

            <form action="login.php" method="POST">

                <label for="Email" class="form-label">Email:</label>
                <input type="email" name="email" class="form-control" value="<?php if (isset($email)) {
                                                                                    echo $email;
                                                                                } ?>" minlength="6" required>

                <label for="Password" class="form-label">Password:</label>
                <input type="password" id="password" name="password" class="form-control" value="" minlength="10" required placeholder="Minimum 10 characters">
                <input type="checkbox" name="checkbox" id="show-pw" onclick="showPass()"> Show password<br>

                <div class="reset-link mt-1">
                    <a href="request_pw_reset.php
                ">Reset password</a>
                </div>

                <button type="submit" class="btn btn-primary mt-4">Login</button>




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
                        case 6:
                            echo '<p class="warning">Username or password incorrect. Please try again or register a new user.</p>';
                            break;
                    }
                }

                if (isset($_GET['status']) && $_GET['status'] == 'pwresetok') {
                    echo '<p class="success">Password updated. Please login with your new password</p>';
                }
                ?>
            </div>

        </div>

    </div>
</div>

<?php

require_once 'inc/footer.inc.php';

?>