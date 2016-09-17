<!DOCTYPE html>
<html lang="en">
<head>
  <title>Send Custom SMS | BDA</title>
	<?php $this->load->view('admin/common/head'); ?> 
  <style type="text/css">
  .set_msg{cursor:pointer}
  </style>
</head>
<body>
<?php $this->load->view('admin/common/header'); ?>
<div class="container-fluid">
<div class="panel panel-default">
<div class="panel-heading">Send Custom SMS</div>
<div class="panel-body">
<div class="row">
<div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-12 col-xs-12">
<form  method="POST" name="send_sms" id="send_sms" data-toggle="validator" >
  <div class="form-group">
    <label class="control-label">Mobile Number :</label>
	  <input type="text" class="form-control" name="mobile_number" id="mobile_number" placeholder="7718964453" tabindex="1" required>
    </div>
  <div class="form-group">
    <label class="control-label">Message :</label>
    <textarea name="message" id="mymsg" class="form-control" placeholder="Type here .." rows="10" tabindex="2" required ></textarea>
  </div> 
  <div class="form-group">
  <input type="submit" name="submit"  value="Send SMS" class="btn btn-primary" tabindex="3" />
  <a href="javascript:;" class="btn btn-primary" onClick="clear_form();" tabindex="4">Clear</a>
  </div>
</form>
</div>
</div>
<div class="row">
<div class="col-lg-6  col-md-6 col-sm-12 col-xs-12">
<h4><code>To copy text in to message box click on it</code></h4>
</div>
</div> 
<div class="row">
  <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
  <p><mark>Case 1 : When Patient is not responding the call, when we need to nformed patient about the appointment status</mark></p>
  <p class="set_msg alert alert-success" tabindex="5" >Dear Mam/Sir, This is Preethika from bookdrappointment.com. We tried calling you, regards to your appointment with Dr... Please get back to us at your convenient time on 022 49 426426</p>
  </div>
  <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
  <p><mark>Case 2 : When any patient need to or we need to send contact details</mark></p>
  <p class="set_msg alert alert-success" tabindex="6" >Dear Mam, This is Preethika from Bookdrappointment.com. The Contact details of Dr Ritika Arora is 9871139151. Incase of any query you can call us back on 022 49 426426</p>
  </div>
  <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
  <p><mark>Case 3 : When Patient is not getting appointment on requested time. And patient is not responding the call</mark></p>
  <p class="set_msg alert alert-success" tabindex="7" >Sir/Mam, This is Preethika from Bookdrappointment.com. Your Appointment requested for Dr.. has not been confirmed as the available slot is for next appointment is 4pm on 9th oct. So Please call back us on 022 49 426426</p>
  </div>
  <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
  <p><mark>Case 4 : When in clinic they doesn't accept call from anyother party <code>OR</code> When there is no response from clinic, We provide contact details to patient and from both the end</mark></p>
  <p class="set_msg alert alert-success" tabindex="7" >Sir/Mam, This is Preethika from bookdrappointment.com.This Clinic  takes appointment from patients only, So please contact the clinic on the below details</p>
  </div>
</div>
<div class="row"><hr /></div>
<div class="row">
  <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
  <p><mark>Case 5 : In Case where patient requested appointment for any dr, but he doesn't get appointment for particular dr and we suggest any other dr that is not listed on our site</mark></p>
  <p class="set_msg alert alert-success" tabindex="8" >Sir/Mam, This is Preethika from Bookdrappointment.com. Your Appointment has been confirmed  with Dr. Tarun Grover on 23rd June, 2015 at 12:00 PM Clinic Name:- Medanta-The Medicity Address:- Rajeev Chowk, Gurgaon Sector-38. Landmark: Near Cafe Coffee Day, Gurgaon Contact No:- 91-9810577390, 9818737367</p>
  </div>
  <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
  <p><mark>Case 6 : In Clinic where there is Token system</mark></p>
  <p class="set_msg alert alert-success" tabindex="9">Sir/Mam, This is Preethika from Bookdrappointment.com. This clinic has token system for appointment, So Please contact the clinic on ...</p>
  </div>
  <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
  <p><mark>Case 7 : In Clinic where there is Walkin system system</mark></p>
  <p class="set_msg alert alert-success" tabindex="10" >Sir/Mam, This is Preethika from Bookdrappointment.com. Appointment requested for dr... is an walkin system between time 5-6, would request you to directly walking in clinic in above mentioned time</p>
  </div>
  <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
  <p><mark>Case 8 : Some where appointment need to be taken on prior like 1 month before</mark></p>
  <p class="set_msg alert alert-success" tabindex="11" >Sir/Mam, This is Preethika from Bookdrappointment.com. Your Appointment requested for Dr... has not been confirmed as the available slot is for next appointment is 4pm on 9th oct. So Please call back us on 022 49 426426</p>
  </div>
</div>   
<div class="row"><hr /></div>
<div class="row">
  <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
  <p><mark>Case 9 : In some cases where dr are on call, so receptionist take details of patients and they call patient directly</mark></p>
  <p class="set_msg alert alert-success" tabindex="12" >Sir/Mam, This is Preethika from Bookdrappointment.com. Your contact details have been provided to the clinic, they will get in touch with you directly. Incase of any query you can call us back on 022 49 426426</p>
  </div>
  <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
  <p><mark>Case 10 : When Patient request time for dr on particular time but he is not getting appointment for requested time, he is getting an hours difference, 2days, 3 days or next week appointment.</mark></p>
  <p class="set_msg alert alert-success" tabindex="13" >Sir/Mam, This is Preethika from Bookdrappointment.com. You are getting an appointment for -- time in place of ---time. we tried getting in touch with you regarding your confirmed appointment. Please call us back on 022 49 426426</p>
  </div>   
  <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
  <p><mark>Case 11 : Utsav SMS</mark></p>
  <p class="set_msg alert alert-success" tabindex="14" >Dear P D Deshpande, Thank you for participating in BookDrAppointment.com HEALTH UTSAV. Your appointment is confirmed with Dr. Sandip Jagtap at 11:30am on 18th Oct. Download our App https://play.google.com/store/apps/details?id=com.bda.patientapp or logon to www.bookdrappointment.com to book appointment with best of doctors.</p>
  </div>
</div>
<div class="row"><hr /></div>
</div>
<div class="panel-footer">
<?php $this->load->view('admin/common/footer'); ?>
</div>
</div>
</div>
</div>
<?php $this->load->view('admin/common/bottom'); ?>
<script type="text/javascript">
$(document).ready(function()
{
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
		$("#mymsg").val(data);
		$('html, body').animate({ scrollTop: 0 }, 'fast');
		$("#mymsg").focus();
	});
	$(".set_msg").keypress(function(e) {
			if(e.which == 13) {
				var data = $(this).html(); 
				$("#mymsg").val(data);
				$('html, body').animate({ scrollTop: 0 }, 'fast');
				$("#mymsg").focus();
			}
	});
	
});

function clear_form()
{
	$("#mobile_number").val('');
	$("#mymsg").val('');
}
</script>
 

<!--PAGE SPECIFIC SCRIPT-->
</body>
</html>
