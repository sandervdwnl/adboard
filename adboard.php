<?php

$page = 'adboard';
$title = 'Adboard';

require_once 'inc/header.inc.php';

require_once 'inc/dbc.inc.php';

?>

<h1 class="text-center">All Ads</h1>

<div class="container-fluid">
    <div class="row mt-2">

        <?php

        $stmt = $connection->query('SELECT DISTINCT * from posts ORDER BY posted_at DESC');

        $row = $stmt->fetch();

        if (empty($row)) {

            echo '<div class="col text-center"><h3>No posts found</h3></div>';
        } else {

            while ($row = $stmt->fetch()) {

        ?>

                <div class="col-sm-12 col-lg-4 col-xl-3">

                    <div class="card h-400">
                        <img class="card-img-top" src="<?php if ($row['image_stored']) {
                                                            echo 'uploads/' . $row['image_stored'];
                                                        } else {
                                                            echo 'https://picsum.photos/300/200';
                                                        } ?>" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title"><?php if ($row['subject']) {
                                                        echo $row['subject'];
                                                    } ?></h5><br>

                            <p class="card-text"><b><?php if ($row['message']) {
                                                        echo $row['message'];
                                                    } ?></b></p><br>
                            <p class="card-district"><small><b>District:</b></small> <?php if ($row['district']) {
                                                                                            echo $row['district'];
                                                                                        } else {
                                                                                            echo 'Unknown';
                                                                                        } ?></p>
                            <p class="card-name"><small><b>Posted By:</b></small> <?php if ($row['full_name']) {
                                                                                        echo $row['full_name'];
                                                                                    } ?></p>
                            <p class="card-email"><small><b>Email:</b></small> <?php if ($row['email']) {
                                                                                    echo $row['email'];
                                                                                } ?></p>
                            <p class="card-tel"><small><b>Tel:</b></small> <?php if ($row['tel']) {
                                                                                echo $row['tel'];
                                                                            } else {
                                                                                echo 'Unknown';
                                                                            } ?></p>

                            <!-- <a href=" #" class="btn btn-primary">Go somewhere</a> -->
                        </div>
                    </div>

                </div>

        <?php

            }
        }

        ?>

    </div>
</div>

<?php

require_once 'inc/footer.inc.php';
