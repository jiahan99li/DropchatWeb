<?php

$servername = "localhost";
$dBUsername = "admin";
$dBPassword = "";
$dBName = "dropchat";

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);
$conn->set_charset("utf8mb4");

if (!$conn) {
    die("Connection failed: ".mysql_connect_error());
}
