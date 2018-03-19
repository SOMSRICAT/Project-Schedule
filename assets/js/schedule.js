$(document).ready(function(){
	var count=0;
	$('#update').click(function(){
		var alert_signup = document.getElementById('alert-update_fail-top');
		if ($('#Efname').val().length==0) {
			alert_signup.className = "alert alert-danger text-center";
			alert_signup.innerHTML = "<b>กรุณากรอก ชื่อจริง</b>"
			document.getElementById('Efname').focus();
			return false;
		}else
		if ($('#Elname').val().length==0) {
			alert_signup.className = "alert alert-danger text-center";
			alert_signup.innerHTML = "<b>กรุณากรอก นามสกุล</b>"
			document.getElementById('Elname').focus();
			return false;
		}else 
		if ($('#Epassword').val().length<6) {
			alert_signup.className = "alert alert-danger text-center";
			alert_signup.innerHTML = "<b>Password ต้องมี 6 ตัวอักษรชึ้นไป</b>"
			document.getElementById('Epassword').focus();
			return false;
		}else{
			$('#editProfile').submit();
		}
	});
	 var table = $('#table-data').DataTable(
		{
	    	AutoWidth: false ,"lengthMenu": [[-1], ["All"]]
	    }
    );
	$('#searchsubject').data('old-state', $('#searchsubject').html());
	$('#insertSubjModal').on('hidden.bs.modal', function () {
		for (var i = 1; i <= count ; i++) {
	    	$("#emp"+i).remove();
		    $("#day"+i).remove();
		    $("#start"+i).remove();
		    $("#end"+i).remove();
		    $("#delete"+i).remove();
	    }
	    $("#form_search")[0].reset();
	    $('#searchsubject').html($('#searchsubject').data('old-state'));
	    count=0;
	});	
	var time_start = $('.time_start');
	var time_end = $('.time_end');

	time_start.datetimepicker({
	  format: 'HH:mm',
	  enabledHours: [8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20],
	  stepping: 30,
	  minDate: moment().startOf('day'),
	  maxDate: moment().endOf('day')
	});
	time_end.datetimepicker({
	  format: 'HH:mm',
	  enabledHours: [8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21],
	  useCurrent: false,
	  stepping: 30,
	  minDate: moment().startOf('day'),
	  maxDate: moment().endOf('day')
	});

	time_start.on("dp.change", function(e) {
	  time_end.data("DateTimePicker").minDate(e.date);
	});

	time_end.on("dp.change", function(e) {
	  time_start.data("DateTimePicker").maxDate(e.date);
	});

	time_end.on("dp.show", function(e) {
	  if (!time_end.data("DateTimePicker").date()) {
	    var defaultDate = time_start.data("DateTimePicker").date().add(30, 'minute');
	    time_end.data("DateTimePicker").defaultDate(defaultDate);
	  }
	});
	$('#subject_id').bind('change keydown keyup',function(){
		var subject_id = $('#subject_id').val();
		// console.log(subject_id);
		var http = new XMLHttpRequest();
		var url = 'subj/searchsubject.php';
		var pmeters = "search=" + subject_id;
		http.open('POST',url,true);
		http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		http.send(pmeters);
		http.onreadystatechange = function(){
			if(http.readyState == 4){
				document.getElementById("searchsubject").innerHTML = http.responseText;
				var table = $('#table-data').DataTable(
					{
				    	AutoWidth: false ,"lengthMenu": [[-1], ["All"]]
				    }
			    );
			    $(".btn_detail").click(function(){
					var subject_id = $(this).attr('subject_id');
					var level = $(this).attr('level');
					var year = $(this).attr('year');
					var section = $(this).attr('section');
					var account_id = $(this).attr('account_id');
					var term = $(this).attr('term');
					var xml = new XMLHttpRequest();
					var url = 'subj/detailsubject.php';
					var pmeters = 
					"subject_id="+subject_id+
					"&level="+level+
					"&year="+year+
					"&section="+section+
					"&account_id="+account_id+
					"&term="+term;
					xml.open('POST',url,true);
					xml.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xml.send(pmeters);
					xml.onreadystatechange = function(){
						if(xml.readyState == 4){
							document.getElementById("show_detail_subject").innerHTML = xml.responseText;
							
						}
					}
				});
				$(".btn_add").click(function(){
					var subject_id = $(this).attr('subject_id');
					var level = $(this).attr('level');
					var year = $(this).attr('year');
					var section = $(this).attr('section');
					var account_id = $(this).attr('account_id');
					var term = $(this).attr('term');
					var Do = "reg";
					$.ajax({
						url:"subj/Cinsert.php",
						method:"POST",
						data:{
							subject_id:subject_id,
							term:term,
							year:year,
							section:section,
							level:level,
							account_id:account_id,
							Do:Do
						},
						success:function(){
							location.reload();
						}
					})
				});
			}
		}
	});
    $("#add_time").click(function(){
    	count++;
    	var inner = "<label>&nbsp;</label><br><a href='#'><i class='fa fa-minus fa-1x' count = "+count+" onclick='delete_datetime(this)'></i></a>";
    	$("#schedule").append("<div class='col-sm-12' id='emp"+count+ "'></div>");
        $("#defaul_day").clone().attr("id","day"+count).appendTo("#schedule");
        $("#defaul_start").clone().attr("id","start"+count).appendTo("#schedule");
        $("#defaul_end").clone().attr("id","end"+count).appendTo("#schedule");
        $("#schedule").append("<div class='col-sm-3' id='delete"+count+"'>"+inner+"</div>");
        
        var time_start_n = $("#start"+count).find('input.time_start');
		var time_end_n = $("#end"+count).find('input.time_end');
        time_start_n.datetimepicker({
		  format: 'HH:mm',
		  enabledHours: [8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20],
		  stepping: 30,
		  minDate: moment().startOf('day'),
		  maxDate: moment().endOf('day')
		});
		time_end_n.datetimepicker({
		  format: 'HH:mm',
		  enabledHours: [8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21],
		  useCurrent: false,
		  stepping: 30,
		  minDate: moment().startOf('day'),
		  maxDate: moment().endOf('day')
		});

		time_start_n.on("dp.change", function(e) {
		  time_end_n.data("DateTimePicker").minDate(e.date);
		});

		time_end_n.on("dp.change", function(e) {
		  time_start_n.data("DateTimePicker").maxDate(e.date);
		});

		time_end_n.on("dp.show", function(e) {
		  if (!time_end_n.data("DateTimePicker").date()) {
		    var defaultDate_n = time_start_n.data("DateTimePicker").date().add(30, 'minute');
		    time_end_n.data("DateTimePicker").defaultDate(defaultDate_n);
		  }
		});
    });

});
function del(subject_id,term,year,section,level,account_id,std_id,reg_level,reg_term){
	$.ajax({
		url:"subj/Cdelete.php",
		method:"POST",
		data:{
			subject_id:subject_id,
			term:term,
			year:year,
			section:section,
			level:level,
			account_id:account_id,
			std_id:std_id
		},
		success:function(){
			location.reload();
		}
	})
}
function delete_datetime(t) {
   	var number = t.getAttribute('count');
   	$("#emp"+number).remove();
    $("#day"+number).remove();
    $("#start"+number).remove();
    $("#end"+number).remove();
    $("#delete"+number).remove();
}