<?php
$page = 'new_ad';
$title = 'New Post';

require_once 'inc/header.inc.php';

?>

<h3 class="text-center">New Post</h3>


<!-- Form for new ad -->
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-3">

            <p class="text-center">* = required</p>
            <form action="ads.php" method="POST" enctype="multipart/form-data">
                <div class="row">

                    <div class="col">
                        <label for="`Full Name" class="form-label">Your Name:*</label>
                        <input type="text" name="fullname" class="form-control" value="<?php if (isset($fullname)) {
                                                                                            echo $fullname;
                                                                                        } ?>" required>
                    </div>

                    <div class="col">
                        <label for="Email" class="form-label">Email:*</label>
                        <input type="email" name="email" class="form-control" value="<?php if (isset($email)) {
                                                                                            echo $email;
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
                        <label for="Add Image" class="form-label">Add Image:</label><br>
                        <input type="file" class="btn" id="browse" name='image'>
                        <input type="button" class="btn btn-secondary" id="clear" value="clear" onclick="clearFileUpload()">
                    </div>
                    <div class="col-12">
                        <label for="Submit Post" class="form-label">Submit Post:</label><br>
                        <button type="submit" class="btn btn-primary">Place Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php

require_once 'inc/footer.inc.php';
