<?php

$page = 'my_ads';
$title = 'My Ads';

require_once 'inc/header.inc.php';

?>

<h1 class="text-center">My Ads</h1>

<div class="container">
    <div class="row">
        <div class="col-md-10">

            <?php

            if (isset($_SESSION['user_email'])) {

                require_once 'inc/dbc.inc.php';

                $stmt = $connection->prepare('SELECT * FROM posts WHERE email = ?');
                $stmt->execute([$_SESSION['user_email']]);
                $row = $stmt->fetch();

                if ($row) {

            ?>
                    <table class="table">
                        <thead>
                            <tr>

                                <th scope="col">Subject</th>
                                <th scope="col">Message</th>
                                <th scope="col">Posted at</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>

                        <?php

                        while ($row = $stmt->fetch()) { ?>


                            <tbody>
                                <tr>

                                    <td><?php echo $row['subject']; ?></td>
                                    <td><?php echo $row['message'] ?></td>
                                    <td><?php echo $row['posted_at']; ?></td>
                                    <td>
                                        <form action="edit_ad.php" method="POST">
                                            <input type="hidden" name="pid" value="<?php echo $row['post_id']; ?>">
                                            <input type="submit" class="btn btn-primary" value="Edit">
                                        </form>
                                    </td>


                                    <td>
                                        <form action="delete_post.php" method="POST">
                                            <input type="hidden" name="pid" value="<?php echo $row['post_id']; ?>">
                                            <input type="submit" class="btn btn-danger" value="Delete">
                                            </input>
                                        </form>
                                    </td>
                                </tr>
                            </tbody>


                        <?php
                        }

                        echo '</table>';

                        ?>



                <?php
                } else {
                    echo '<h3>No ads found. Time to go to <a href="new_ad.php">New Ad</a> and post a new ad!';
                }
            } else {
                header('Location: home.php');
                exit();
            }





                ?>
        </div>

        <?php

        $error = '';

        if (isset($_GET['error'])) {
            $error = $_GET['error'];

            switch ($error) {
                case 0:
                    $error = "<p class='success'>Post deleted</p>";
                    break;
                case 1:
                    $error = "<p class='error'>Post could not be deleted due to an error</p>";
                    break;
                case 3:
                    $error = "<p class='warning'>Please fill in all fields correctly</p>";
                    break;
                case 10:
                    $error = "<p class='success'>Post updated</p>";
                    break;
            }
        }

        echo $error;

        ?>

    </div>
</div>

< <?php

    require_once 'inc/footer.inc.php';
