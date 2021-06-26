<?php
// $connection = mysqli_connect('localhost','root','','rtcamp');


$host = 'remotemysql.com';
$db = 'HudcH4kV6V';
$user = 'HudcH4kV6V';
$password = 'DMfAUKZr1U';

$connection = mysqli_connect("$host","$user","$password","$db");
if(!$connection) {
	die("Connection failed:".mysqli_connect_error());
}
?>