<?php
require_once('../condb.php');
session_start();
if ($_POST) {
	$Do = $conn->real_escape_string($_POST['Do']);
	$subject_id = $conn->real_escape_string($_POST['subject_id']);
	$name_th = $conn->real_escape_string($_POST['name_th']);
	$name_eng = $conn->real_escape_string($_POST['name_eng']);
	$term = $conn->real_escape_string($_POST['term']);
	$year = $conn->real_escape_string($_POST['year']);
	$section = $conn->real_escape_string($_POST['section']);
	$level = $conn->real_escape_string($_POST['level']);
	$day = $_POST['day'];
	$time_start = $_POST['time_start'];
	$time_end = $_POST['time_end'];
	$std_id = $conn->real_escape_string($_SESSION['std_id']);
	$reg_level = $conn->real_escape_string($_SESSION['level']);
	$reg_term = $conn->real_escape_string($_SESSION['term']);

	// $check = "SELECT * FROM `subject` WHERE subject_level=".$subject_level." AND username='".$_SESSION['username']."' AND subject_day='".$subject_day."'";
	// $Cqr = mysqli_query($conn,$check);
	// while ($row = mysqli_fetch_array($Cqr)) {
	// 	$timestdatDB = ($row['subject_timestart_hr']+$row['subject_timestart_min']);
	// 	$timeendDB = ($row['subject_timeend_hr']+$row['subject_timeend_min']);
	// 	$timestdatNew = ($subject_timestart_hr+$subject_timestart_min);
	// 	$timeendNew = ($subject_timeend_hr+$subject_timeend_min);
	// 	for ($i=$timestdatDB; $i < $timeendDB ; $i+=0.5) { 
	// 		for ($j=$timestdatNew; $j < $timeendNew; $j+=0.5) { 
	// 			if($j==$i){
	// 				echo "!ไม่สามารถลงเวลาซ้ำกันได้";
	// 				return;
	// 			}
	// 		}
	// 	}
	// }

	if ($Do == "new") {
		$account_id = $conn->real_escape_string($_SESSION['account_id']);
		if ($account_id==1 || $account_id==8) {
			$mode = 1;
		}else{
			$mode = 2;

		}
		$sql_subject = "INSERT INTO `subject`(`subject_id`, `term`, `year`, `section`, `level`, `account_id`, `name_th`, `name_eng`, `mode`)
		VALUES('$subject_id',$term,$year,$section,$level,$account_id,'$name_th','$name_eng',$mode)";
		
		$sql_program_has_subj = "INSERT INTO `program_has_subject`(`program_program_id`, `subject_subject_id`, `subject_term`, `subject_year`, `subject_section`, `subject_level`, `subject_account_id`) VALUES(".$_SESSION['program_id'].",'$subject_id',$term,$year,$section,$level,$account_id)";

		$qr_subject = $conn->query($sql_subject);

		$qr_program_has_subj = $conn->query($sql_program_has_subj);
		if ($qr_subject && qr_program_has_subj) {
			for($i=0;$i < count($day);$i++){
				$sql_schedule = "INSERT INTO `schedule`(`subject_id`, `subject_term`, `subject_year`, `subject_section`, `subject_level`, `account_id`, `time_start`, `time_end`, `day`) 
				VALUES ('$subject_id',$term,$year,$section,$level,$account_id,'".$time_start[$i]."','".$time_end[$i]."','".$day[$i]."')";
				$qr_schedule = $conn->query($sql_schedule);
			}
			
			if ($qr_schedule) {
				
				$sql_register = "INSERT INTO `register`(`subject_id`, `subject_term`, `subject_year`, `subject_section`, `subject_level`, `account_id`, `std_id`, `reg_level`, `reg_term`, `register_time`) 
					VALUES ('$subject_id',$term,$year,$section,$level,$account_id,'$std_id',$reg_level,$reg_term,'$istoday')";
				$qr_register = $conn->query($sql_register);
				if ($qr_register) {
					$_SESSION['status'] = 1;
					header('Location:'.$_SERVER['HTTP_REFERER']);
				}else{
					$_SESSION['status'] = 0;
					echo $conn->error;
					// header('Location:'.$_SERVER['HTTP_REFERER']);
				}
			}else{
				$_SESSION['status'] = 0;
				echo $conn->error;
				// header('Location:'.$_SERVER['HTTP_REFERER']);
			}
		}else{
			$_SESSION['status'] = 0;
			$_SESSION['message'] = "มีวิชานี้ในระบบแล้ว";
			// echo $conn->error;
			header('Location:'.$_SERVER['HTTP_REFERER']);
		}
	}elseif ($Do == "reg") {
		$account_id = $conn->real_escape_string($_POST['account_id']);
		$sql_register = "INSERT INTO `register`(`subject_id`, `subject_term`, `subject_year`, `subject_section`, `subject_level`, `account_id`, `std_id`, `reg_level`, `reg_term`, `register_time`) 
			VALUES ('$subject_id',$term,$year,$section,$level,$account_id,'$std_id',$reg_level,$reg_term,'$istoday')";
		$qr_register = $conn->query($sql_register);
		if ($qr_register) {
			$_SESSION['status'] = 1;
			header('Location:'.$_SERVER['HTTP_REFERER']);
		}else{
			$_SESSION['status'] = 0;
			echo $sql_register."<br>";
			echo $conn->error;
			// header('Location:'.$_SERVER['HTTP_REFERER']);
		}
	}
	$conn->close();
}else{
	echo "เข้ามาไม?";
}
?>