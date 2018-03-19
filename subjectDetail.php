<?php
require_once("condb.php");
if(!isset($_SESSION)) 
{ 
    session_start(); 
}
if(!isset($_SESSION['username'])){
	header('location:login.php');
	exit;
}

$subjsql = "
SELECT * FROM `register`,`subject`
WHERE `subject`.`subject_id`=`register`.`subject_id` 
AND `subject`.`term` = `register`.`subject_term`
AND `subject`.`year` = `register`.`subject_year`
AND `subject`.`section` = `register`.`subject_section`
AND `register`.`std_id` = '".$_SESSION["std_id"]."'
AND `register`.`reg_level` = '".$_SESSION["level"]."'
AND `register`.`reg_term` = '".$_SESSION["term"]."'
ORDER BY `register`.`register_time` ASC";

$subjqr = $conn->query($subjsql) ;
if(!$subjqr){
	echo $conn->error;
}

?>
<div class'table-responsive'>
	<h3 class='text-center'>Subject</h3>
	<div class='pull-right'>
		<button class='btn btn-info navbar-btn btn-lg' data-toggle='modal' data-target='#insertSubjModal' name="adds">Add Subject</button>
	</div>
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th width='10%' class="text-center">รหัสวิชา</th>
				<th width='60%' class="text-center">ชื่อวิชา</th>
				<th width='10%' class="text-center">Section</th>
				<!-- <th width='10%' class="text-center">แก้ไข</th> -->
				<th width='10%' class="text-center">ลบ</th>
			</tr>	
		</thead>
		<tbody>
		<?php 
		while ($subjresult = $subjqr->fetch_assoc()) {
			echo"
			<tr>
				<td class='text-center'>
					<a href='http://reg.kku.ac.th/registrar/class_info_1.asp?coursecode=".$subjresult['subject_id']."&Acadyear=".$subjresult['year']."&semester=".$subjresult['term']."' target='_bank'>".$subjresult['subject_id']."</a>
				</td>
				<td>".$subjresult['name_th']." || ".$subjresult['name_eng']."</td>
				<td class='text-center'>".$subjresult['section']."</td>";
			
			//echo"<td class='text-center' ><button class='btn btn-xs btn-warning data-edit' data-toggle='modal' data-target='#editSubjModal' id='".$subjresult['subject_id']."'>Edit</button></td>";
			echo"<td class='text-center' ><button class='btn btn-xs btn-danger data-delete' onclick = 'del(`".$subjresult['subject_id']."`,".$subjresult['term'].",".$subjresult['year'].",".$subjresult['section'].",".$subjresult['level'].",".$subjresult['account_id'].")'>Delete</button></td>
			</tr>";
		}
		?>
		</tbody>
	</table>
</div>