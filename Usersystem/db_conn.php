<?php

$server= "localhost:3300";
$user= "root";
$password = "";

$db_name = "userproduct";

$conn = mysqli_connect($server, $user, $password, $db_name);

if (!$conn) {
	echo "Connection failed!";
}