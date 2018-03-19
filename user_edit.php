<?php
if (!$_POST) {
	echo "เข้ามาเฮ็ดหยัง";
	exit();
}
session_start();
require_once('condb.php');
$Efname = $conn->real_escape_string($_POST['Efname']);
$Elname = $conn->real_escape_string($_POST['Elname']);
$Eemail = $conn->real_escape_string($_POST['Eemail']);
$Epassword = $conn->real_escape_string($_POST['Epassword']);

$sql_user_edit = "UPDATE `account` SET `firstname` = '$Efname',`lastname` = '$Elname',`email` = '$Eemail',`password` = '$Epassword' WHERE `username` = '".$_SESSION['username']."'";
$qr_user_edit = $conn->query($sql_user_edit);
if (!$qr_user_edit) {
	$_SESSION['status'] = 0;
	header('Location:'.$_SERVER['HTTP_REFERER']);
}else{
	$_SESSION['status'] = 1;
	header('Location:'.$_SERVER['HTTP_REFERER']);
}
$conn->close();
?>