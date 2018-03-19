<?php
require_once('../condb.php');
session_start();
if ($_POST['account_id']) {
	$subject_id = $conn->real_escape_string($_POST['subject_id']);
	$term = $conn->real_escape_string($_POST['term']);
	$year = $conn->real_escape_string($_POST['year']);
	$section = $conn->real_escape_string($_POST['section']);
	$level = $conn->real_escape_string($_POST['level']);
	$account_id = $conn->real_escape_string($_POST['account_id']);

	$detail_subj = "
	SELECT * FROM `subject`,`schedule`
    WHERE `subject`.`subject_id`=`schedule`.`subject_id`
    AND `subject`.`term` = `schedule`.`subject_term`
    AND `subject`.`year` = `schedule`.`subject_year`
    AND `subject`.`section` = `schedule`.`subject_section`
    AND `subject`.`level` = `schedule`.`subject_level`
    AND `subject`.`account_id` = `schedule`.`account_id`
	AND `subject`.`subject_id` = '$subject_id'
	AND `subject`.`level` = $level
	AND `subject`.`term` = $term
	AND `subject`.`section` = $section
	AND `subject`.`account_id` = $account_id
	AND `subject`.`year` = $year
	";
	
	$qr_detail_subj = $conn->query($detail_subj);
	$res_detail = "";
	$res_detail .= "<table id='table_data' class='table table-striped table-bordered table-hover font-td'>
				<thead>
					<th class='text-center' >วัน</th>
					<th class='text-center' >เวลา</th>
				</thead>
				<tbody>";
	while ($row_detail_subj = $qr_detail_subj->fetch_assoc()) {
		$res_detail .= "<tr>";
		if ($row_detail_subj['day']=='จ') {
			$row_detail_subj['day'] = "จันทร์";
		}elseif ($row_detail_subj['day'] == 'อ') {
			$row_detail_subj['day'] = "อังคาร";
		}elseif ($row_detail_subj['day'] == 'พ') {
			$row_detail_subj['day'] = "พุธ";
		}elseif ($row_detail_subj['day'] == 'พฤ') {
			$row_detail_subj['day'] = "พฤหัสบดี";
		}elseif ($row_detail_subj['day'] == 'ศ') {
			$row_detail_subj['day'] = "ศุกร์";
		}
		$res_detail .= "<td class='text-center'>".$row_detail_subj['day']."</td>";
		$res_detail .= "<td>".$row_detail_subj['time_start']." - ".$row_detail_subj['time_end']."</td>";
		$res_detail .= "</tr>";
	}
	$res_detail .="</tbody>
			</table>";
	echo $res_detail;
}
?>