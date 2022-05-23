<?php

$db = mysqli_connect(
    $_ENV['DB_HOST'],
    $_ENV['DB_USER'],
    $_ENV['DB_PASS'] ?? '',
    $_ENV['DB_NAME']
);


if (!$db) {
    echo "Error: Connection to mySQL not successful.";
    echo "debug errno: " . mysqli_connect_errno();
    echo "debug error: " . mysqli_connect_error();
    exit;
}
