<?php
require_once('../condb.php');
session_start();
if ($_POST['search']) {
	$subject_id = $_POST['search'];
	$level = $_SESSION['level'];
	$account_id = $_SESSION['account_id'];

	$searchsubj = "
	SELECT * FROM `subject`,`account`
    WHERE `account`.`account_id` = `subject`.`account_id`
	AND `subject`.`subject_id` LIKE  '$subject_id%'
	AND `subject`.`level` <= $level
	AND (`subject`.`mode` = 1 OR `subject`.`account_id` = $account_id)
	";

	$qrsearch = $conn->query($searchsubj);
	$res = "";
	$res .= "<table id='table-data' class='table table-striped table-bordered table-hover font-td'>
				<thead>
					<th class='text-center' >รหัสวิชา</th>
					<th class='text-center' >ชื่อวิชา</th>
					<th class='text-center' >สำหรับ</th>
					<th class='text-center' >section</th>
					<th class='text-center' >สร้างโดย</th>
					<th class='text-center' >รายละเอียด</th>
					<th class='text-center' >เพิ่ม</th>
				</thead>
				<tbody>";
	while ($row = $qrsearch->fetch_assoc()) {
		$res .= "<tr>";
		$res .= "<td class='text-center'>".$row['subject_id']."</td>";
		$res .= "<td>".$row['name_th']."</td>";
		if ($row['level'] == 4) {
			$res .= "<td class='text-center'>ชั้นปีที่ ".$row['level']."</td>";
		}else{
			$res .= "<td class='text-center'>ชั้นปีที่ ".$row['level']." ขึ้นไป</td>";
		}
		$res .= "<td class='text-center'>".$row['section']."</td>";
		$res .= "<td class='text-center'>".$row['firstname']."</td>";
		$res .= "<td class='text-center'>
					<button class='btn btn-defalt btn_detail' data-toggle='modal' data-target='#detail_subject' subject_id = ".$row['subject_id']." level = ".$row['level']." year = ".$row['year']." section = ".$row['section']." account_id = ".$row['account_id']." term = ".$row['term'].">รายละเอียด</button>
				</td>";

		$res .= "<td class='text-center'>
					<button class='btn btn-info btn_add' subject_id = ".$row['subject_id']." level = ".$row['level']." year = ".$row['year']." section = ".$row['section']." account_id = ".$row['account_id']." term = ".$row['term']." do='reg'>เพิ่ม</button>
				</td>";
		$res .= "</tr>";
	}
	$res .="</tbody>
			</table>";
	echo $res;
}
?>