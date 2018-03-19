<?php 
$host = "localhost";
$user = "root";
$pass = "";
$db = "schedule";

$conn = new mysqli($host,$user,$pass,$db);

if(!$conn){
	echo $conn->connect_errno;
	exit;
}
$conn -> set_charset("utf8");

date_default_timezone_set('Asia/Bangkok');
$istoday =  Date('Y-m-d H:i:s');
?>