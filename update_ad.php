<?php
$page = 'new_ad';
$title = 'New Post';

require_once 'inc/header.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    require_once 'inc/dbc.inc.php';

    if (!empty($_POST['fullname']) and !empty($_POST['email']) and !empty($_POST['subject']) and !empty($_POST['message'])) {

        $name = $_POST['fullname'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $tel = $_POST['tel']; //not required
        $message = $_POST['message'];
        $district = $_POST['district']; //not required
        $post_id = $_POST['pid'];


        if (filter_var($email, FILTER_VALIDATE_EMAIL) == TRUE) {


            // Image upload settings 

            $img_uploaded = 0;

            $file = '';

            $new_filename = '';

            // Check of er ook een img is geupload

            if (!empty($_FILES['name'])) {

                // ['image'] komt van input:name

                $file = $_FILES['image']['name'];

                $extension = pathinfo($file, PATHINFO_EXTENSION);

                echo $extension;

                $allowed_extensions = ['gif', 'png', 'jpg', 'jpeg'];

                if (!in_array($extension, $allowed_extensions)) {

                    $connection = '';
                    $error = 1;
                    header('Location: new_ad.php?error=1');
                } else {

                    $new_filename = rand(111, 999) . $_FILES['image']['name'];

                    $destination = "uploads/";

                    $destination .= basename($new_filename);

                    move_uploaded_file($_FILES['image']['tmp_name'], $destination);

                    $img_uploaded = 1;
                }
            } // file not uploaded

            // INSERT STMT

            $sql = "UPDATE posts SET full_name=?, email=?, subject=?, tel=?, message=?, district=?, img_uploaded=?, posted_at=?, image=?, image_stored=? WHERE post_id=?";
            $stmt = $connection->prepare($sql);

            $stmt->execute([
                $name,
                $email,
                $subject,
                $tel,
                $message,
                $district,
                $img_uploaded,
                date("Y-m-d H:i:s"),
                $file,
                $new_filename,
                $post_id
            ]);
            if ($stmt->rowCount() == 1) {

                $error = 10; //success
                unset($connection);
                Header('Location: my_ads.php?error=10');
            } //results selected



        } else {
            $erorr = 3; // invalid email
            Header('Location: my_ads.php?error=3');
            unset($connection);
        }
    } else { // empty fields
        $error = 3;
        Header('Location: my_ads.php?error=3');
        unset($connection);
    }
} else { //form not submitted
    header('Location: home.php');
}

require_once 'inc/footer.inc.php';
