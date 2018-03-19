<?php
require_once('../condb.php');
session_start();
$subject_id = $conn->real_escape_string($_POST['subject_id']);
$term = $conn->real_escape_string($_POST['term']);
$year = $conn->real_escape_string($_POST['year']);
$section = $conn->real_escape_string($_POST['section']);
$level = $conn->real_escape_string($_POST['level']);
$account_id = $conn->real_escape_string($_POST['account_id']);
$std_id = $conn->real_escape_string($_SESSION['std_id']);
$reg_level = $conn->real_escape_string($_SESSION['level']);
$reg_term = $conn->real_escape_string($_SESSION['term']);
$account_id2 = $conn->real_escape_string($_SESSION['account_id']);

$conn->query('BEGIN');
$sql_del_reg = "DELETE FROM `register` 
WHERE `subject_id` = '$subject_id' 
AND `subject_term` = $term 
AND `subject_year` = $year 
AND `subject_section` = $section
AND `subject_level` = $level
AND `account_id` = $account_id
AND `std_id` = '$std_id'
AND `reg_level` = $reg_level
AND `reg_term` = $reg_term
";


if ($account_id!=1 || $account_id!=8 ) {
	$sql_del_schedule = "DELETE FROM `schedule` 
	WHERE `subject_id` = '$subject_id' 
	AND `subject_term` = $term 
	AND `subject_year` = $year 
	AND `subject_section` = $section
	AND `subject_level` = $level
	AND `account_id` = $account_id2";

	$sql_subj_pro = "DELETE FROM `program_has_subject` 
	WHERE `subject_subject_id` = '$subject_id' 
	AND `subject_term` = $term 
	AND `subject_year` = $year 
	AND `subject_section` = $section
	AND `subject_level` = $level
	AND `subject_account_id` = $account_id2";

	$sql_del_subj ="DELETE FROM `subject`
	WHERE `subject_id` = '$subject_id' 
	AND `term` = $term 
	AND `year` = $year 
	AND `section` = $section
	AND `level` = $level
	AND `account_id` = $account_id2";
	$qr_del_reg = $conn->query($sql_del_reg);
	$qr_del_schedule = $conn->query($sql_del_schedule);
	$qr_del_subj_pro = $conn->query($sql_subj_pro);
	$qr_del_subj = $conn->query($sql_del_subj);

	if ($qr_del_schedule && $qr_del_subj && $qr_del_subj_pro && $qr_del_reg) {
		$schedule_subj = 1;
	}else{
		echo $conn->error;
		$schedule_subj = 0;
	}
}else{
	$qr_del_reg = $conn->query($sql_del_reg);
	$schedule_subj = 1;
}

// echo $sql_del_schedule."<br><br>";
// echo $sql_subj_pro."<br><br>";

// echo $sql_del_subj."<br><br>";
// echo $sql_del_reg."<br><br>";

if ($qr_del_reg && $schedule_subj) {
	$_SESSION['status'] = 1;
	$conn->query('COMMIT');
}else{
	$_SESSION['status'] = 0;
	echo $conn->error;
	$conn->query('ROLLBACK');
}
echo $_SESSION['status'];
?>