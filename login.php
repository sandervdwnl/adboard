<?php
$page = 'login';

require_once 'inc/header.inc.php';

// FORM HANDLING

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    require_once 'inc/dbc.inc.php';

    // Check email

    if (!empty($_POST['email']) && strlen($_POST['email'] > 5)) {

        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {

            $email = trim($_POST['email']);
        } else {
            echo 'Invalid email';
        }
    } else {
        echo 'Please fill in your email adress';
    }

    // Check password

    if (!empty($_POST['password']) && strlen($_POST['password'] > 9)) {


        if (filter_var($_POST['password'], FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => "/.{6,25}/"]])) {

            $password = trim($_POST['password']);
        } else {
            echo 'Invalid password';
        }
    } else {
        echo 'Please fill in your password';
    }
}


?>

<h1 class="text-center">Login</h1>

<div class="container">
    <div class="row">

        <div class="col-md-6 offset-3">

            <form action="login.php" method="POST">

                <label for="Email" class="form-label">Email:</label>
                <input type="email" name="Email" class="form-control" value="" minlength="6" required>

                <label for="Password" class="form-label">Password:</label>
                <input type="password" name="Password" class="form-control" value="" minlength="10" required>

                <button type="submit" class="btn btn-primary mt-4">Login</button>

            </form>
        </div>

    </div>
</div>

<?php

require_once 'inc/footer.inc.php';

?>