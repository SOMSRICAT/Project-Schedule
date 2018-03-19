<?php
require_once("condb.php");
session_start();
if(!isset($_SESSION['username'])){
   header('location:login.php');
   exit;
}
$sql_user_select = "
SELECT * FROM `account` ,`student`,`program`,`fact`,`university`,`dept`
WHERE `account`.`account_id` = `student`.`account_id` 
AND `student`.`program_id` = `program`.`program_id`
AND `program`.`dept_id` = `dept`.`dept_id` 
AND `dept`.`fact_id` = `fact`.`fact_id` 
AND `fact`.`uid` = `university`.`uid`
AND `username` = '".$_SESSION['username']."'";
$qr_user_select = $conn -> query($sql_user_select);
$res_user_select = $qr_user_select -> fetch_assoc();

if (!isset($_GET['term'])) {
	$_SESSION['term'] = 1;
}else{
	$_SESSION['term'] = $_GET['term'];
}
$_SESSION['level'] = 3;
?>
<html>
<head>
    <title>--- Schedule ---</title>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css?family=Cabin" rel="stylesheet">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" type="text/css" href="assets/plugin/bootstrap/css/bootstrap.min.css" media="all">
    <link rel="stylesheet" type="text/css" href="assets/plugin/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/dataTables.bootstrap.min.css">
  	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap-datetimepicker.min.css"/>
   	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
	<!--Menu+Banner-->
	<div id="navv">
		<?php include 'navbar.php'; ?>
	</div>
	<!--Alert-->
	<?php
	if(isset($_SESSION['status'])){
		if ($_SESSION['status']==1) {
			echo '<div class="alert alert-success"><b>Well done!</b> บันทึกข้อมูลสำเร็จ</div>';
		}else{
			if (empty($_SESSION['message'])) {
				$_SESSION['message'] = '';
			}
			echo '<div class="alert alert-danger"><b>Fail!</b> บันทึกข้อมูลผิดพลาด '.$_SESSION['message'].'</div>';
		}
		unset($_SESSION['status']);
		unset($_SESSION['message']);
	}
	?>

	<h2 class="page-header text-center">ชั้นปีที่ 3</h2>
	<ul class="nav nav-tabs nav-justified">
		<?php if($_SESSION['term']==1){ ?>
			<li role="presentation" class="active"><a href="?term=1">เทอมที่ 1</a></li>
			<li role="presentation"><a href="?term=2">เทอมที่ 2</a></li>
		<?php }else{ ?>
			<li role="presentation"><a href="?term=1">เทอมที่ 1</a></li>
			<li role="presentation" class="active"><a href="?term=2">เทอมที่ 2</a></li>
		<?php } ?>
		
		
	</ul>
	<!--content-->
	<?php 
	if ($_SESSION['account_id']!=8) {
	?>
	<div class="col-md-12 align-items-center" style="margin-top: 10px;">
		<div class="table-responsive" id="showtable" style="margin-top: 5px">
			<?php include 'showtable.php'; ?> 
	    </div>
	</div>
	<?php
	}
	?>
	<!--insert subject-->
	<?php include 'subj/insertSubjModal.php'; ?>
	<div class="col-md-6 col-md-offset-3">
		<!--show subject detail-->
		<?php include 'subjectDetail.php'; ?>
	</div>

	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/schedule.js"></script>
	<script src="assets/plugin/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/js/jquery.dataTables.min.js"></script>
	<script src="assets/js/dataTables.bootstrap.min.js"></script>
	<script src="assets/js/moment.min.js"></script>      
	<script src="assets/js/date.js"></script>             
	<script src="assets/js/bootstrap-datetimepicker.min.js"></script>
	<script type="text/javascript">
		$(function() {
			$('#editProfile').click(function(){
				$('#Eusername').val(<?php echo "'".$_SESSION['username']."'"; ?>);
				$('#Etitle').val(<?php echo "'".$res_user_select['title']."'"; ?>);
				$('#Estd_id').val(<?php echo "'".$res_user_select['std_id']."'"; ?>);
				$('#Efname').val(<?php echo "'".$res_user_select['firstname']."'"; ?>);
				$('#Elname').val(<?php echo "'".$res_user_select['lastname']."'"; ?>);
				$('#Eemail').val(<?php echo "'".$res_user_select['email']."'"; ?>);
				$('#Efact').val(<?php echo "'".$res_user_select['fact_name_th']."'"; ?>);
				$('#Edept').val(<?php echo "'".$res_user_select['dept_name_th']."'"; ?>);
				$('#Eprogram').val(<?php echo "'".$res_user_select['p_name_th']."'"; ?>);
			});
		});
	</script>
</body>
</html>