<?php

require_once 'inc/header.inc.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    require_once 'inc/dbc.inc.php';

    $post_id = $_POST['pid'];

    $email = $_SESSION['user_email'];

    $sql = "DELETE FROM `posts` WHERE `post_id` = :post_id";
    $stmt = $connection->prepare($sql);
    $stmt->bindValue(':post_id', $post_id);
    $rows = $stmt->execute();

    if ($rows == 1) {
        $url = 'my_ads.php?error=0';
        header("Location: " . $url);
    } else {
        $url = 'my_ads.php?error=1';
        header("Location: " . $url);
    }




    // header('Location: my_ads.php?error=0');
} else {
    header('Location: home.php');
}
