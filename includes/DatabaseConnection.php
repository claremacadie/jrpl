<?php
// Sets up a connection to the database>

// Get username and password from apache server files
$username = getenv('db_user');
$password = getenv ('db_password');
$pdo = new PDO('mysql:host=127.0.0.1;dbname=jrpl;charset=utf8', $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);