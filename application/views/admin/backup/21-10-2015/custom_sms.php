<!DOCTYPE html>
<html lang="en">
<head>
  <title>Send Custom SMS | BDA</title>
	<?php $this->load->view('admin/common/head'); ?> 
</head>
<body>
<?php $this->load->view('admin/common/header'); ?>
<div class="container-fluid">
<div class="panel panel-default">
<div class="panel-heading">Send Custom SMS</div>
<div class="panel-body">
<form  method="POST" name="send_sms" data-toggle="validator" >
	<div class="col-md-4 col-md-offset-4">
  <div class="form-group">
    <label class="control-label">Mobile Number :</label>
	  <input type="text" class="form-control" name="mobile_number" placeholder="7718964453" required>
    </div>
  <div class="form-group">
    <label class="control-label">Message :</label>
    <textarea name="message" id="mymsg" class="form-control" placeholder="Type here .." required ></textarea>
  </div> 
  <div class="form-group">
  <input type="submit" name="submit"  value="Send SMS" class="btn btn-primary" />
  </div>
  </div>
</form>
</div><h4>To copy text in to message box click on it </h4> 
<div class="row grid_bg">
  <div class="col-md-12 sms_template" >
   <div class="col-lg-3 set_msg" style="cursor: pointer;">1. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting."> 1. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting
   </div>
   <div class="col-lg-3 set_msg" style="cursor: pointer;">2. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting."> 1. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting
   </div><div class="col-lg-3 set_msg" style="cursor: pointer;">3. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting."> 1. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting
   </div><div class="col-lg-3 set_msg" style="cursor: pointer;">4. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting."> 1. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting
   </div>
	</div>
</div>
</div>
<div class="panel-footer">
<?php $this->load->view('admin/common/footer'); ?>
</div>
</div>
</div>
<?php $this->load->view('admin/common/bottom'); ?>
<script type="text/javascript">
$(document).ready(function() {
	$('#start_date').datepicker({
			format: "yyyy-mm-dd",
			autoclose: true,
			todayHighlight: true,
			orientation: "top left"
	});
	$('#end_date').datepicker({
			format: "yyyy-mm-dd",
			autoclose: true,
			todayHighlight: true,
		  orientation: "top left"
	});
	$(".set_msg").click(function(){ 
		 var data = $(this).html(); 
		$("#mymsg").html(data);

	});
});
</script>
 

<!--PAGE SPECIFIC SCRIPT-->
</body>
</html>
