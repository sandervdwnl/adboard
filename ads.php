<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    echo 'form submitted<br>';

    require_once 'inc/dbc.inc.php';

    if (!empty($_POST['fullname']) and !empty($_POST['email']) and !empty($_POST['subject']) and !empty($_POST['message'])) {

        $name = $_POST['fullname'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $tel = $_POST['tel']; //not required
        $message = $_POST['message'];
        $district = $_POST['district']; //not required

        echo 'all required fields filled in <br>';


        if (filter_var($email, FILTER_VALIDATE_EMAIL) == TRUE) {

            echo 'email valid<br>';
        }

        // Image upload settings 

        // Check if image is uploaded

        if ($_FILES) {

            // ['image'] komt van input:name
            echo 'image submitted: ' . $_FILES['image']['name']  . '<br>';

            switch ($_FILES['image']['type']) {
                case 'image/jpeg':
                    $ext = 'jpg';
                    break;
                case 'image/gif':
                    $ext = 'gif';
                    break;
                case 'image/png':
                    $ext = 'png';
                    break;
                default:
                    $ext = '';
            }

            if ($ext) {

                $file = $_FILES['image']['name'];

                // $uploads_dir = getcwd() . '/uploads/';

                // echo "uploads path: $uploads_dir" . "<br>";

                $destination = "uploads/";

                $destination .= basename($_FILES['image']['name']);

                echo $destination . '<br>';

                if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                    echo 'file has been uploaded<br>';
                }

                $img_uploaded = 1;

                echo 'image uploaded: ' . $file . '<br>';
            } else {
                echo 'filetype not accepted<br>';
            }
        } else {

            echo 'no image uploaded<br>';

            $img_uploaded = 0;

            $file = '';
        }


        // INSERT STMT

        $stmt = $connection->prepare('INSERT INTO posts (full_name, email, subject, tel, message, district, img_uploaded, posted_at, image) 
        VALUES (?,?,?,?,?,?,?,?,?) ');
        $stmt->execute([
            $name,
            $email,
            $subject,
            $tel,
            $message,
            $district,
            $img_uploaded,
            date("Y-m-d H:i:s"),
            $file
        ]);
        if ($stmt->rowCount() == 1) {

            echo 'post added<br>';
        } else {

            echo 'post not added<br>';
        }
    } else {
        echo 'Please fill in all required fields<br>';
    }
}



?>

<h1>All Ads</h1>

<div class="container-fluid">
    <div class="row">

    </div>
</div>