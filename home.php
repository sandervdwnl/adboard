<?php

$page = 'home';

include_once 'inc/header.inc.php';

?>

<h1>Home</h1>

<div class="message">

    <?php

    if (isset($_GET['status']) && $_GET['status'] == 'loggedout')
        echo '<h3 class"succes">You are logged out</h3>';
    if (isset($_GET['status']) && $_GET['status'] == 'loggedin')
        echo '<h3 class"succes">Welcome back!</h3>';

    ?>

</div>

<?php

include_once 'inc/footer.inc.php';
