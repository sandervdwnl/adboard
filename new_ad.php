<?php
$page = 'new_ad';

require_once 'inc/header.inc.php';

?>

<h3 class="text-center">New add</h3>
<!-- Form for new ad -->
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-3">

            <form action="new_add" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col">
                        <label for="Name" class="form-label">Name:</label>
                        <input type="text" name="Name" class="form-control" value="" required>
                    </div>

                    <div class="col">
                        <label for="Email" class="form-label">Email:</label>
                        <input type="email" name="Email" class="form-control" value="" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="Tel" class="form-label">Tel:</label>
                        <input type="tel" name="Tel" class="form-control" value="">
                    </div>

                    <div class="col">
                        <label for="Subject" class="form-label">Subject</label>
                        <input type="text" name="Subject" class="form-control" value="" required>
                    </div>
                </div>


                <div class="col-12 mb-4">
                    <label for="Message" class="form-label">Message:</label>
                    <textarea name="Message" class="form-control" required></textarea>
                </div>


                <div class="row">
                    <div class="col-3">
                        <button type="submit" class="btn btn-secondary">Upload Image</button>
                    </div>
                    <div class="col-3">
                        <button type="submit" class="btn btn-primary">Place Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php

require_once 'inc/footer.inc.php';
