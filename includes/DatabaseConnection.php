<?php
// Sets up a connection to the database

// Retrieve password and username from apache environment
// (This prevents the username and password appearing in files on gitHub)
$password = getenv('db_password');
$user = getenv('db_user');

$pdo = new PDO('mysql:host=127.0.0.1;dbname=jrpl;
charset=utf8', $user, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
