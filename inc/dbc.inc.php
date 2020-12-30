<?php

$dsn = 'mysql:host=localhost;dbname=adboard';
$username = 'adroot';
$passwd = 'pass1234';
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false
];

try {
    $connection = new PDO($dsn, $username, $passwd, $options);
} catch (PDOException $e) {
    echo 'MESSAGE: <br>' . $e->getMessage();
}
