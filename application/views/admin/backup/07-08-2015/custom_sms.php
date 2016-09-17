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
    <textarea name="message" class="form-control" placeholder="Type here .." required ></textarea>
  </div> 
  <div class="form-group">
  <input type="submit" name="submit"  value="Send SMS" class="btn btn-primary" />
  </div>
  </div>
</form>
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
});
</script>
 

<!--PAGE SPECIFIC SCRIPT-->
</body>
</html>
