function CheckLogin() {
	if($('#username').val().length<5){
		document.getElementById('alert-login').className = "alert alert-danger text-center";
		document.getElementById('alert-login').innerHTML = "<b>Username ต้องมี 5 ตัวอักษรชึ้นไป</b>";
		document.getElementById('username').focus();
		return false;
	}
	if($('#password').val().length<6){
		document.getElementById('alert-login').className = "alert alert-danger text-center";
		document.getElementById('alert-login').innerHTML = "<b>Password ต้องมี 6 ตัวอักษรขึ้นไป</b>";
		document.getElementById('password').focus();
		return false;
	}
}
function CheckSignup(){
	var alert_signup = document.getElementById('alert-signup');
	if($('#username').val().length<5){
		alert_signup.className = "alert alert-danger text-center";
		alert_signup.innerHTML = "<b>Username ต้องมี 5 ตัวอักษรชึ้นไป</b>"
		document.getElementById('username').focus();
		return false;
	}
	if ($('#password').val().length<6) {
		alert_signup.className = "alert alert-danger text-center";
		alert_signup.innerHTML = "<b>Password ต้องมี 6 ตัวอักษรชึ้นไป</b>"
		document.getElementById('password').focus();
		return false;
	}
	if ($('#std_id').val().length!=11) {
		alert_signup.className = "alert alert-danger text-center";
		alert_signup.innerHTML = "<b>รูปแบบรหัสนักศึกษา 123456789-0</b>"
		document.getElementById('std_id').focus();
		return false;
	}
	if ($('#fname').val().length==0) {
		alert_signup.className = "alert alert-danger text-center";
		alert_signup.innerHTML = "<b>กรุณากรอก ชื่อจริง</b>"
		document.getElementById('fname').focus();
		return false;
	}
	if ($('#lname').val().length==0) {
		alert_signup.className = "alert alert-danger text-center";
		alert_signup.innerHTML = "<b>กรุณากรอก นามสกุล</b>"
		document.getElementById('lname').focus();
		return false;
	}
}