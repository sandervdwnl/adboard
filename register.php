<?php
$page = 'register';
$title = 'Register';

require_once 'inc/header.inc.php';

// FORM HANDLING

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    require_once 'inc/dbc.inc.php';

    $error = 0;

    // Check email

    $email = trim($_POST['email']);

    if (strlen($email) > 5) {

        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {

            // Check if email is already in db 

            $stmt = $connection->prepare('SELECT * from users WHERE email = :email');
            $stmt->execute([
                ':email' => $email
            ]);
            $results = $stmt->fetchAll();

            if (empty($results)) {

                // Check password

                $password = $_POST['password'];

                if (strlen($password) > 9) {

                    if (filter_var($password, FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => "/.{6,25}/"]])) {

                        $password = trim($password);

                        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

                        $stmt = $connection->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
                        $affected_rows = $stmt->execute([
                            ':email' => $email,
                            ':password' => $password_hashed
                        ]);
                        if ($affected_rows = 1) {

                            $error = 10;

                            unset($connection);
                        } else {

                            $error = 5;
                        }
                    } else {
                        $error = 4;
                    }
                } else {
                    $error = 2;
                }
            } else {
                $error = 1;
            }
        } else {
            $error = 3;
        }
    } else {
        $error = 3;
    }
}
unset($connection);

?>

<h1 class="text-center">Register</h1>

<div class="container">
    <div class="row">

        <!-- FORM -->

        <div class="col-md-6 offset-3">

            <form action="register.php" method="POST">

                <label for="Email" class="form-label">Email:</label>
                <input type="email" name="email" class="form-control" value="" minlength="6" required>

                <label for="Password" class="form-label">Password:</label>
                <input type="password" name="password" id="password" class="form-control" value="" minlength="10" required placeholder="Minimum 10 characters">
                <input type="checkbox" name="checkbox" id="show-pw" onclick="showPass()"> Show password<br>

                <button type="submit" class="btn btn-primary mt-4">Register</button>

            </form>

            <div class="error mt-2">
                <?php

                if (isset($error)) {

                    switch ($error) {
                        case 0:
                            echo "<p></p>";
                            break;
                        case 1:
                            echo '<p class="warning">Email adress alreaddy registered. Please login.</p>';
                            break;
                        case 2:
                            echo '<p class="warning">Please fill in all fields.</p>';
                            break;
                        case 3:
                            echo '<p class="warning">Please fill in a valid emailadress.</p>';
                            break;
                        case 4:
                            echo '<p class="warning">Please use a valid password with a minimal length of 10 characters.</p>';
                            break;
                        case 5:
                            echo '<p class="warning">An error has occured. Please try again or contact the webmaster.</p>';
                            break;
                        case 10:
                            echo '<p class="success">You are registered. Please login now.</p>';
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

?>