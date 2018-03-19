<?php
session_start();
if(isset($_SESSION["username"])){
	header("location:index.php");
	exit;
}

require 'condb.php';
if(!empty($_REQUEST)){
	$username = $conn->real_escape_string($_POST['username']);
	$password = $conn->real_escape_string($_POST['password']);
	$title = $conn->real_escape_string($_POST['title']);
	$std_id = $conn->real_escape_string($_POST['std_id']);
	$fname = $conn->real_escape_string($_POST['fname']);
	$lname = $conn->real_escape_string($_POST['lname']);
	$email = $conn->real_escape_string($_POST['email']);
	// $fact = $conn->real_escape_string($_POST['fact']);
	// $dept = $conn->real_escape_string($_POST['dept']);
	$program = $conn->real_escape_string($_POST['program']);
	$year = $conn->real_escape_string($_POST['year']);
	$reg_ip = $_SERVER["REMOTE_ADDR"];

	$conn->query('BEGIN');
	$sql_signup_acc = "INSERT INTO `account`(`username`, `password`, `title`, `firstname`, `lastname`, `email`, `register_date`, `register_ip`, `login_date`, `user_type`) 
	VALUES('$username','$password','$title','$fname','$lname','$email','$istoday','$reg_ip','$istoday',1)";
	$qr_signup_acc = $conn->query($sql_signup_acc);
	
	if ($qr_signup_acc) {
		$sql_signup_std = "SELECT `account_id` FROM `account` WHERE `username` ='$username'";
		$qr_signup_std = $conn -> query($sql_signup_std);
		$res_signup_std = $qr_signup_std->fetch_assoc();
		$sql_signup_std = "INSERT INTO `student` VALUES('$std_id',$program,".$res_signup_std['account_id'].",$year)";
		$qr_signup_std = $conn -> query($sql_signup_std);
		if ($qr_signup_std ) {
			$_SESSION["username"] = $username;
			$_SESSION["std_id"] = $std_id;
			$_SESSION["account_id"] = $res_signup_std["account_id"];
			$_SESSION["program_id"] = $program;
			$sql_select_subject = "SELECT * FROM `subject` WHERE `mode` = 1 ORDER BY `subject_id`";
			$qr_select_subject = $conn->query($sql_select_subject);
			while ($row_select = $qr_select_subject->fetch_assoc()) {
				$sql_register = "INSERT INTO `register`(`subject_id`, `subject_term`, `subject_year`, `subject_section`, `subject_level`, `account_id`, `std_id`, `reg_level`, `reg_term`, `register_time`)
				VALUES ('".$row_select['subject_id']."',".$row_select['term'].",".$row_select['year'].",".$row_select['section'].",".$row_select['level'].",".$row_select['account_id'].",'$std_id',".$row_select['level'].",".$row_select['term'].",'$istoday')";
				$qr_register = $conn->query($sql_register);
				if (!$qr_register) {
					echo $conn->error;
				}
			}

			$conn->query("COMMIT");
			header("location:index.php");
		}else{
			$_SESSION['status'] = "รหัสนักศึกษาถูกใช้ไปแล้ว";
			$conn->query("ROLLBACK");
		}
	}else{
			$_SESSION['status'] = "ชื่อผู้ใช้ถูกใช้ไปแล้ว";
	}
}
$conn->close();
?>
<html>
<head>
    <title>--- Sign Up ---</title>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css?family=Cabin" rel="stylesheet">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" type="text/css" href="assets/plugin/bootstrap/css/bootstrap.min.css" media="all">
    <link rel="stylesheet" type="text/css" href="assets/plugin/font-awesome/css/font-awesome.min.css">
  	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
  	<link href="assets/css/style.css" rel="stylesheet">
</head>
<body>       
 	<nav class="navbar navbar-inverse navbar-fixed-top">
  		<div class="container-fluid">
     		<a class="navbar-brand" href="index.php">Home</a>
    		<span class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcollapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
         		<ul class="nav navbar-nav collapse navbar-collapse">
              		<li>
              			<a href="#">
	              			<span>Sign Up</span>
            				<span class="icon is-small"><i class="fa fa-user-plus"></i></span>
              			</a>
              		</li>
             	</ul>
    		</span>
          	<div class="collapse navbar-collapse" id="navcollapse">
	          	<ul class="nav navbar-nav navbar-right">
	          		<li>
              			<a href="login.php">
	              			<span>Login</span>
	              			<span class="icon is-small"><i class="fa fa-key"></i></span>
              			</a>
              		</li>
	            	<li class="active">
            			<a href="#">
	            				<span>Sign Up</span>
	            				<span class="icon is-small"><i class="fa fa-user-plus"></i></span>
            			</a>
        			</li>
	          	</ul>
        	</div>
      </div>
    </nav>
    <div class="col-md-6 col-md-offset-3">
    	<div id="alert-signup"></div>
    	<?php
		if(isset($_SESSION['status'])){
			echo "<div class='alert alert-danger'><b>Fail! </b>".$_SESSION['status']."</div>";
			unset($_SESSION['status']);
		}
		?>
    </div>
		<div class="col-md-4 col-md-offset-4">
			<div class="form-signup">
				<h3 class="page-header text-center">--- Sign Up <span class="icon"><i class="fa fa-user-plus"> ---</i></span></h3>
				<form method='post' action='signup.php'>
					<div class="form-group">
						<label><b>ชื่อผู้ใช้<i style="color:red;">*</i></b></label>
						<input type="text" name="username" id="username" class="form-control" pattern="[\w]{5,}" title="Username ต้องมี 5 ตัวอักษรขึ้นไป" required autofocus>
					</div>
					<div class="form-group">
					<label><b>รหัสผู้ใช้<i style="color:red;">*</i></b></label>
						<input type="password" name="password" id="password" class="form-control" pattern="[\w]{6,}" title="Password ต้องมี 6 ตัวอักษรขึ้นไป" required>
					</div>
					<div class="form-group">
						<label><b>คำนำหน้าชื่อ<i style="color:red;">*</i></b></label>
						<select name="title" class="form-control" id="title">
							<option value="นาย">นาย</option>
							<option value="นางสาว">นางสาว</option>
						</select> 
					</div>
					<div class="form-group">
						<label><b>รหัสนักศึกษา<i style="color:red;">*</i></b></label>
						<input type="text" name="std_id" id="std_id" class="form-control" pattern="\d{9}-\d{1}" title="xxxxxxxxx-x" required>
					</div>
					<div class="form-group">
						<label><b>ชื่อจริง<i style="color:red;">*</i></b></label>
						<input type="text" name="fname" id="fname" class="form-control" required>
					</div>
					<div class="form-group">
						<label><b>นามสกุล<i style="color:red;">*</i></b></label>
						<input type="text" name="lname" id="lname" class="form-control" required>
					</div>
					<div class="form-group">
						<label><b>อีเมล</b></label>
						<input type="email" name="email" id="email" class="form-control" >
					</div>
					<div class="form-group">
						<label><b>คณะ<i style="color:red;">*</i></b></label>
						<select class="form-control" name="fact" id="fact">
							<option value="1">SCIENCE</option>
						</select>
					</div>
					<div class="form-group">
						<label><b>ภาควิชา<i style="color:red;">*</i></b></label>
						<select class="form-control" name="dept" id="dept">
							<option value="1">Computer Science</option>
						</select>
					</div>
					<div class="form-group">
						<label><b>สาขา<i style="color:red;">*</i></b></label>
						<select class="form-control" name="program" id="program">
							<option value="1">CS</option>
						</select>
					</div>
					<div class="form-group">
						<label><b>ชั้นปี<i style="color:red;">*</i></b></label>
						<select class="form-control" name="year" id="year">
							<option value="1">ชั้นที่ปี 1</option>
							<option value="2">ชั้นที่ปี 2</option>
							<option value="3">ชั้นที่ปี 3</option>
							<option value="4">ชั้นที่ปี 4</option>
						</select>
					</div>
					<div class="form-group text-center">
						<button  class="btn btn-success" onclick="return CheckSignup();">Signup <span class="icon is-small"><i class="fa fa-user-plus"></i></span></button>
					</div>
				</form>
			</div>
		</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="assets/plugin/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/js/checkform.js"></script>	
</body>
</html>