
<div class="modal fade" id="insertSubjModal" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal"><span>&times;</span></button>
				<h3 class="modal-title text-center" >ค้นหา / เพิ่มรายวิชา</h3>
			</div>
			<div class="modal-body ">
				<div>
					<form class="text-center" autocomplete="off" id="form_search" method="post" action="subj/Cinsert.php">
						<input type="hidden" name="Do" id="Do" class="form-control" value="new">
						<input type="hidden" name="term" id="term" class="form-control" value="<?= $_SESSION['term']; ?>">
						<input type="hidden" name="level" id="level" class="form-control" value="<?= $_SESSION['level']; ?>">
						<div class="col-sm-2">
							<label><b>รหัสวิชา<i style="color:red;">*</i></b></label>
							<input type="text" name="subject_id" id="subject_id" class="form-control" autofocus="on" required>
						</div>
						<div class="col-sm-5">
							<label><b>ชื่อวิชาภาษาไทย<i style="color:red;">*</i></b></label>
							<input type="text" name="name_th" class="form-control" required>
						</div>
						<div class="col-sm-5">
							<label><b>ชื่อวิชาภาษาอังกฤษ<i style="color:red;">*</i></b></label>
							<input type="text" name="name_eng" class="form-control" required>
						</div>
						<div class="col-sm-4">
							<label><b>สำหรับปี<i style="color:red;">*</i></b></label>
							<input type="number" min="1" max="4" name="level" class="form-control" required>
						</div>
						<div class="col-sm-4">
							<label><b>Section<i style="color:red;">*</i></b></label>
							<input type="text" name="section" id="section" class="form-control" required>
						</div>
						<div class="col-sm-4">
							<label><b>ปีการศึกษา<i style="color:red;">*</i></b></label>
							<input type="text" name="year" id="year" class="form-control" required>
						</div>
						<div id="schedule">
							<div class="col-sm-3" id="defaul_day">
								<label><b>วัน<i style="color:red;">*</i></b></label>
								<select name="day[]" class="form-control" >
									<option value="จ">จันทร์</option>
									<option value="อ">อังคาร</option>
									<option value="พ">พุธ</option>
									<option value="พฤ">พฤหัสบดี</option>
									<option value="ศ">ศุกร์</option>
								</select>
							</div>
							<div class="col-sm-3" id="defaul_start">
								<label><b>เริ่มเรียนเวลา<i style="color:red;">*</i></b></label>
								<input type="text" name="time_start[]" class="form-control time_start" required>
							</div>
							<div class="col-sm-3" id="defaul_end">
								<label><b>เลิกเรียนเวลา<i style="color:red;">*</i></b></label>
								<input type="text" name="time_end[]" class="form-control time_end" required>
							</div>
							<div class="col-sm-3">
								<label>&nbsp;</label><br>
								<a href="#"><i class="fa fa-plus fa-2x" id="add_time"></i></a>
							</div>
						</div>
						
						<div class="col-sm-12">
							<label>&nbsp;</label>
							<input type="submit" class="btn btn-success form-control" value="เพิ่มข้อมูล">
						</div>
					</form>	
				</div>
				
				<div id="searchsubject" class="" style="font-size: 14px;">
					<table id="table-data" class="table table-striped table-bordered table-hover font-td">
						<thead>
							<tr>
								<th class='text-center' >รหัสวิชา</th>
								<th class='text-center' >ชื่อวิชา</th>
								<th class='text-center' >สำหรับ</th>
								<th class='text-center' >วัน</th>
								<th class='text-center' >section</th>
								<th class='text-center' >สร้างโดย</th>
								<th class='text-center' >รายละอียด</th>
								<th class='text-center' >เพิ่ม</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-defauls" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- detail subject -->
<div class="modal fade" id="detail_subject" role="dialog">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal"><span>&times;</span></button>
				<h3 class="modal-title text-center" >วัน / เวลาเรียน</h3>
			</div>
			<div class="modal-body ">
				<div id="show_detail_subject" class="" style="font-size: 14px;">
					
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-defauls" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<!--edit subject-->
<div class="modal fade" id="editSubjModal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal"><span>&times;</span></button>
				<h3 class="modal-title" id="myModalLabel">Subject</h3>
			</div>
			<div class="modal-body ">
				<div class="form-box">
					<form method="POST" id="subj_form">
				        <fieldset>
				            <legend style="text-align:center" id="Hfield">Edit Subject</legend>
				            <div class="form-group">
								<label>รหัสวิชา<span style="color: red;">*</span></label>
								<input type="text" name="subj_id" id="subj_id" class="form-control" placeholder="Enter subject ID" required>
							</div>
				            <div class="form-group">
								<label for="subj_name">ชื่อวิชา<span style="color: red;">*</span>
								</label><input type="text" id="subj_name" name="subj_name" class="form-control" placeholder="Enter subject name" required>
							</div>
				            <div class="form-group">
								<label>Section<span style="color: red;">*</span></label>
								<input type="number" min="1" id="subj_sec" name="subj_sec" class="form-control" placeholder="Enter section" required>
							</div>
				        </fieldset>
				    </form>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-warning" id="editsubj">Edit</button>
				<button class="btn btn-defauls" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>