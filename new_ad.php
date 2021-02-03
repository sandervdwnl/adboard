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


        if (filter_var($email, FILTER_VALIDATE_EMAIL) == TRUE) {



            // Image upload settings 

            $img_uploaded = 0;

            $file = '';

            $new_filename = '';

            // Check of er ook een img is geupload

            if (!empty($_FILES['image'])) {


                // ['image'] komt van input:name

                $file = $_FILES['image']['name'];

                $extension = pathinfo($file, PATHINFO_EXTENSION);


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

            $stmt = $connection->prepare('INSERT INTO posts (full_name, email, subject, tel, message, district, img_uploaded, posted_at, image, image_stored) 
            VALUES (?,?,?,?,?,?,?,?,?,?) ');
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
                $new_filename
            ]);
            if ($stmt->rowCount() == 1) {

                $error = 10; //success
                unset($connection);
            } //results selected
        } else {
            $erorr = 3; // invalid email
        }
    } else { // empty fields
        $error = 3;
    }
} //form not submitted



?>


<h3 class="text-center">New Post</h3>

<!-- Form for new ad -->
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-3">

            <?php if (isset($_SESSION['user_email'])) { ?>

                <p class="text-center">* = required</p>
                <form action="new_ad.php" method="POST" enctype="multipart/form-data">
                    <div class="row">

                        <div class="col">
                            <label for="`Full Name" class="form-label">Your Name:*</label>
                            <input type="text" name="fullname" class="form-control" value="<?php if (isset($fullname)) {
                                                                                                echo $fullname;
                                                                                            } ?>" required>
                        </div>

                        <div class="col">
                            <label for="Email" class="form-label">Email:*</label>
                            <input type="email" name="email" class="form-control" value="<?php if (isset($_SESSION['user_email'])) {
                                                                                                echo $_SESSION['user_email'];
                                                                                            } ?>" required>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col">
                            <label for="Tel" class="form-label">Tel:</label>
                            <input type="tel" name="tel" class="form-control" value="<?php if (isset($tel)) {
                                                                                            echo $tel;
                                                                                        } ?>">
                        </div>

                        <div class="col">
                            <label for="Subject" class="form-label">Subject:*</label>
                            <input type="text" name="subject" class="form-control" value="<?php if (isset($subject)) {
                                                                                                echo $subject;
                                                                                            } ?>" required>
                        </div>
                    </div>

                    <div class="col-12 mb-4">
                        <label for="District" class="form-label">District:</label>
                        <input type="text" name="district" class="form-control" value="<?php if (isset($district)) {
                                                                                            echo $district;
                                                                                        } ?>">
                    </div>

                    <div class="col-12 mb-4">
                        <label for="Message" class="form-label">Message:*</label>
                        <textarea name="message" class="form-control" required><?php if (isset($message)) {
                                                                                    echo $message;
                                                                                } ?></textarea>
                    </div>


                    <div class="row mb-4">

                        <div class="col-12">
                            <label for="Add Image" class="form-label">Add Image <small>(.jpeg, .jpg,.gif or .png)</small></label><br>
                            <input type="file" class="btn" id="browse" name='image'>
                            <input type="button" class="btn btn-secondary" id="clear" value="clear" onclick="clearFileUpload()">
                        </div>
                        <div class="col-12">
                            <label for="Submit Post" class="form-label">Submit Post:</label><br>
                            <button type="submit" class="btn btn-primary">Place Add</button>
                        </div>
                    </div>
                </form>

            <?php } else {
                header('Location: home.php');
            } ?>

            <div class="error mt-2">
                <?php

                if (isset($error)) {

                    switch ($error) {
                        case 0:
                            echo "<p></p>";
                            break;
                        case 1:
                            echo '<p class="warning">Filetype is not supported. Please upload an .jpg, .gif or .png image.</p>';
                            break;
                        case 2:
                            echo '<p class="warning">An error has occured while addidg the post. Please try again or contact the webmaster.</p>';
                            break;
                        case 3:
                            echo '<p class="warning">Please fill in all required fields.</p>';
                            break;
                        case 10:
                            echo '<p class="success">Post added successfully. Check the <a href="adboard.php">Adboard</a> to view your post.</p>';
                            $name = '';
                            $email = '';
                            $subject = '';
                            $tel = '';
                            $message = '';
                            $district = '';
                            break;
                    }
                }

                if (isset($_GET['error']) && $_GET['error'] == 1) {
                    echo '<p class="warning">Filetype is not supported. Please upload an .jpg, .gif or .png image.</p>';
                }


                ?>
            </div>

        </div>
    </div>
</div>

<?php

require_once 'inc/footer.inc.php';
