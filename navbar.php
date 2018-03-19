<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container-fluid">
		<div class="navbar-header">
         <a class="navbar-brand" href="index.php">Home</a>
 			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu">
 				<span class="icon-bar"></span>
 				<span class="icon-bar"></span>
 				<span class="icon-bar"></span>
 			</button>
      </div>
		<div class="collapse navbar-collapse navbar-right" id="menu">
		   <ul class="nav navbar-nav" >
				<li class="navbar-text">
               <span class="icon is-small">
                  <?php 
                  if ($res_user_select['title']=='นาย') {
                    echo "<i class='fa fa-male'></i>";
                  }else{
                     echo "<i class='fa fa-female'></i>";
                  }
                  ?>
                  Username : 
               </span>
               <span>
   						<a href="#" class="text-uppercase" data-toggle="modal" data-target="#profileModal">
   							<?php
                     echo "[".$res_user_select['firstname']." ".$res_user_select['lastname']."]";
   							?>
   						</a>
					</span>
               <span><a href="#" data-toggle="modal" data-target="#editProfileModal" id="editProfile">[แก้ไขโปรไฟล์]</a></span>
                <span>
                  <a href='logout.php'>
                     <span>[Logout</span>
                     <span class="icon is-small"><i class="fa fa-sign-in"></i>]</span>
                  </a>
               </span>
            </li>
            <li class="dropdown">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" style="font-size: 25px;">ชั้นปี <span class="caret"></span></a>
               <ul class="dropdown-menu">
                  <li><a href="index.php">ชั้นปีที่ 1</a></li>
                  <li><a href="sophomore.php">ชั้นที่ปี 2</a></li>
                  <li><a href="junior.php">ชั้นที่ปี 3</a></li>
                  <li><a href="senior.php">ชั้นที่ปี 4</a></li>
               </ul>
            </li>
            
			</ul>
 	   </div>
   </div>
</nav>
<!-- Profile -->
<div class="modal fade" role="dialog" id="profileModal">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            <h3 class="modal-title" id="myModalLabel">Profile</h4>
         </div>
         <div class="modal-body">
            <div class="table-responsive">
            <fieldset>
                <legend style="text-align:center; color: tomato;">Profile</legend>
                  <table class='table table-hover table-striped text-left'>
                     <tr>
                        <td width="30%"><lable>Username</lable></td>
                        <td width="70%"><label><?php echo $res_user_select['username']; ?></label></td>
                     </tr>
                     <tr>
                        <td width="30%"><lable>รหัสนักศึกษา</lable></td>
                        <td width="70%"><label><?php echo $res_user_select['std_id']; ?></label></td>
                     </tr>
                     <tr>
                        <td width="30%"><lable>ชื่อจริง</lable></td>
                        <td width="70%"><label><?php echo $res_user_select['firstname']; ?></label></td>
                     </tr>
                     <tr>
                        <td width="30%"><lable>นามสกุล</lable></td>
                        <td width="70%"><label><?php echo $res_user_select['lastname']; ?></label></td>
                     </tr>
                     <tr>
                        <td width="30%"><lable>อีเมล</lable></td>
                        <td width="70%"><label><?php if(!isset($res_user_select['email']))echo '-'; else echo $res_user_select['email']; ?> </label></td>
                     </tr>
                     <tr>
                        <td width="30%"><lable>มหาวิทยาลัย</lable></td>
                        <td width="70%"><label><?php echo $res_user_select['uni_name_th']; ?></label></td>
                     </tr>
                     <tr>
                        <td width="30%"><lable>คณะ</lable></td>
                        <td width="70%"><label><?php echo $res_user_select['fact_name_th']; ?></label></td>
                     </tr>
                     <tr>
                        <td width="30%"><lable>ภาควิชา</lable></td>
                        <td width="70%"><label><?php echo $res_user_select['dept_name_th']; ?></label></td>
                     </tr>
                     <tr>
                        <td width="30%"><lable>สาขา</lable></td>
                        <td width="70%"><label><?php echo $res_user_select['p_name_th']; ?></label></td>
                     </tr>
                     <tr>
                        <td width="30%"><lable>ชั้นปี</lable></td>
                        <td width="70%"><label><?php echo $res_user_select['year']; ?></label></td>
                     </tr>
                  </table>
               </fieldset>
            </div>
         </div>
         <div class="modal-footer" >
            <button class="btn btn-defauls" data-dismiss="modal">Close</button>
         </div>
      </div>
   </div>
</div>
<!-- editProfile -->

<div class="modal fade" id="editProfileModal" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button class="close" data-dismiss="modal"><span>&times;</span></button>
            <h3 class="modal-title" id="myModalLabel">Edit Profile</h3>
         </div>
         <div class="modal-body">
            <!--Alert-->
            <div id="alert-update_fail-top"></div>
            <div class="form-box">
               <fieldset>
                  <legend style="text-align:center; color: tomato;">Edit Profile</legend>
                  <form method='post' action="user_edit.php" id="editProfile" autocomplete="off">
                     <div class="form-group">
                        <label><b>Username<i style="color:red;">*</i></b></label>
                        <input type="text" name="Eusername" id="Eusername" class="form-control" disabled>
                     </div>
                     <div class="form-group">
                        <label><b>รหัสนักศึกษา<i style="color:red;">*</i></b></label>
                        <input type="text" id="Estd_id" class="form-control" disabled>
                     </div>
                     <div class="form-group">
                        <label><b>คำนำหน้าชื่อ<i style="color:red;">*</i></b></label>
                        <input type="text" id="Etitle" class="form-control" disabled>
                     </div>
                     <div class="form-group">
                        <label><b>ชื่อจริง<i style="color:red;">*</i></b></label>
                        <input type="text" name="Efname" id="Efname" class="form-control" required>
                     </div>
                     <div class="form-group">
                        <label><b>นามสกุล<i style="color:red;">*</i></b></label>
                        <input type="text" name="Elname" id="Elname" class="form-control" required>
                     </div>
                     <div class="form-group">
                        <label><b>อีเมล</b></label>
                        <input type="email" name="Eemail" id="Eemail" class="form-control" >
                     </div>
                     <div class="form-group">
                     <label><b>Password<i style="color:red;">*</i></b></label>
                        <input type="password" name="Epassword" id="Epassword" class="form-control" pattern="[\w]{6,}" title="Password ต้องมี 6 ตัวอักษรขึ้นไป" required>
                     </div>
                     <div class="text-right">
                        <button  class="btn btn-warning" id="update" ">Edit <span class="icon is-small"><i class="fa fa-user-plus"></i></span></button>
                        <button class="btn btn-defauls" data-dismiss="modal">Close</button>
                     </div>
                  </form>
               </fieldset>
            </div>
         </div>
      </div>
   </div>
</div>
