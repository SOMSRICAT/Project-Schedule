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
	$sql_login = "
	SELECT * FROM `account`,`student` WHERE `account`.`account_id` = `student`.`account_id` AND `username` = '$username' AND `password` ='$password'"; 
	$qr_login = $conn->query($sql_login);
	if ($qr_login) {
		$res_login = $qr_login->fetch_assoc();
		$_SESSION["username"] = $res_login["username"];
		$_SESSION["std_id"] = $res_login["std_id"];
		$_SESSION["account_id"] = $res_login["account_id"];
		$_SESSION["program_id"] = $res_login["program_id"];
		$sql_update_login = "UPDATE `account` SET `login_date` = '$istoday' WHERE `username` = '$username'";
		$qr_update_login = $conn->query($sql_update_login);
		header("location:index.php");
	}else{
		echo'
		<script type="text/javascript">
			alert("Username or Password Incorrect...!");
		</script>';
	}
	
}
$conn->close();
?>
<html>
<head>
    <title>---Login---</title>
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
	              			<span>Login</span>
	              			<span class="icon is-small"><i class="fa fa-key"></i></span>
              			</a>
              		</li>
             	</ul>
    		</span>
          	<div class="collapse navbar-collapse" id="navcollapse">
	          	<ul class="nav navbar-nav navbar-right">
	          		<li class="active">
              			<a href="#">
	              			<span>Login</span>
	              			<span class="icon is-small"><i class="fa fa-key"></i></span>
              			</a>
              		</li>
	            	<li>
            			<a href="signup.php">
	            				<span>Sign Up</span>
	            				<span class="icon is-small"><i class="fa fa-user-plus"></i></span>
            			</a>
        			</li>
	          	</ul>
        	</div>
      </div>
    </nav>
 
    <div class="col-md-4 col-md-offset-4">
    	<div id="alert-login"></div>
    </div>
    
	<div class="col-md-2 col-md-offset-5">
		<div class="form-login text-center">
			<h3 class="page-header text-center">--- Login <span class="icon"><i class="fa fa-key"> ---</i></span></h3>
			<form method="post" action="login.php">
				<div class="form-group ">
					<input type="text" name="username" id="username" placeholder="ชื่อผู้ใช้"  pattern="[\w]{5,}"  class="form-control" autofocus>
				</div>
				<div class="form-group">
					<input type="password" name="password" id="password" placeholder="รหัสผู้ใช้" class="form-control">
				</div>
				<div  class="form-group">
					<button  class="btn btn-success" onclick="return CheckLogin();">ลงชื่อเข้าใช้ <span class="icon is-small"><i class="fa fa-key"></i></span></button>
					<a href="signup.php" ><span class="icon is-small btn btn-info">สมัครสมาชิก <i class="fa fa-user-plus"></i></span></a>
				</div>
				
			</form>
		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="assets/plugin/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/js/checkform.js"></script>
</body>
</html>