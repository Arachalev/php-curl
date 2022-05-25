<?php
// this code is to create a connection to the db. 
// I'm using a mysql local db

$host = "localhost";
$dbname = "fiverr_task";
$username = "root";
$password = "";

$mysqli = new mysqli(hostname: $host,
                     username: $username,
                     password: $password,
                     database: $dbname);
                     
if ($mysqli->connect_errno) {
    die("Connection error: " . $mysqli->connect_error);
}

return $mysqli;