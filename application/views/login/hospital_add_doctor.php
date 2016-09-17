<?php #print_r($_POST)?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php $this->load->view('login/common/head'); ?>
</head>
<body>
<?php $this->load->view('login/common/hospital_header'); ?>
<div class="container H550">
<div class="row">
<div class="col-lg-offset-1 col-md-offset-1 col-lg-10 col-md-10">      
<div class="panel panel-default">  
<div class="panel-heading">Add a Doctor</div>
<div class="panel-body">
<div class="row">
<div class="col-lg-12 col-md-12">
<form name="hospital_add_doctor" method="POST" enctype="multipart/form-data" data-toggle="validator">
	<div class="form-group">
  <label class="control-label">Doctor Profile Picture </label>
  <div id="profileimgbox"><img width="126" height="152" src="<?=IMAGE_URL.'photo_frame.jpg'?>"/></div>          
  </div>
  <div class="form-group">
  <button type="button" class="btn btn-info btn-md" id="myBtn"><span class="glyphicon glyphicon-upload"></span>&nbsp;Select a File</button>
  <input type="hidden" name="profile_pic_base64" id="profile_pic_base64" value="<?=@$_POST['profile_pic_base64']?>" />
  <input type="hidden" name="profile_pic_base64_name" id="profile_pic_base64_name" value="<?=@$_POST['profile_pic_base64_name']?>" />
  </div>
  <div class="form-group">
    <label for="doctor_name" class="control-label">Doctor Name</label>
    <input id="doctor_name" name="doctor_name" type="text" class="form-control" value="<?=@$_POST['doctor_name']?>"  required />
  </div>
  <div class="form-group">
    <label for="doctor_email_id" class="control-label">Doctor Email ID</label>
    <input id="doctor_email_id" name="doctor_email_id" type="text" class="form-control" value="<?=@$_POST['doctor_email_id']?>"  required />
  </div>
  <div class="form-group">
    <label for="doctor_password" class="control-label">Doctor Password</label>
    <input id="doctor_password" name="doctor_password" type="text" class="form-control" value="<?=@$_POST['doctor_password']?>"  required />
  </div>
  <div class="form-group">
    <label for="doctor_dob" class="control-label">Doctor Date Of Birth</label>
    <input id="doctor_dob" name="doctor_dob" type="text"  class="form-control" value="<?=@$_POST['doctor_dob']?>" required />
  </div>
  
  <div class="form-group form-inline">
  <label class="control-label">* Doctor Gender </label>
  <div class="radio"><label><input type="radio" name="doctor_gender" value="m" id="radio_male"		required/> Male</label></div>
  <div class="radio"><label><input type="radio" name="doctor_gender" value="f" id="radio_female"	required/> Female</label>
  </div>
  </div>
  <div class="form-group">
    <label for="doctor_summary" class="control-label">Doctor Summary
    </label>
    <textarea id="doctor_summary" name="doctor_summary" type="text" class="form-control" rows="3"  required ><?=@$_POST['doctor_summary']?></textarea>
  </div>
  <div class="form-group">
    <label for="doctor_reg_no" class="control-label">Doctor Registration Number</label>
    <input id="doctor_reg_no" name="doctor_reg_no" type="text" class="form-control" value="<?=@$_POST['doctor_reg_no']?>" required />
  </div>
  <div class="form-group">
  <label for="doctor_council" class="control-label">State Medical Council </label>
  <input type="text" class="autocomplete-registration-council form-control" value="<?=@$council[$_POST['doctor_council']]['name']?>"  />
  <input type="hidden" class="form-control" name="doctor_council" id="doctor_council" value="<?=@$_POST['doctor_council']?>" />
  </div>
  <div class="InputsWrapper" id="speciality_wrapper">
	<div class="form-group" style="margin-bottom:0px;">
  <label class="control-label" for="doctor_speciality">* Specialty</label>
  </div>  
  <div class="form-group">
  <div class="row">        
  <div class="col-sm-10">
  <input type="text" value="" id="doctor_speciality" class="form-control autocomplete-specializations" placeholder="Speciality" required/>
  </div>
  <div class="col-sm-2">
    <button class="btn btn-success glyphicon glyphicon-plus" onclick="return addelement(this);" id="speciality"></button>
  </div>
  </div>    
  </div>
  </div>
  <div class="InputsWrapper" id="degree">
  <div class="form-group" style="margin-bottom: 0px;">
  <label class="control-label" for="doctor_qualification">* Qualification</label>
  </div>
	<div class="form-group">
  <div class="row">            
  <div class="col-sm-10">
  <input type="text" class="form-control autocomplete-qualification" value="" placeholder="Degree" id="doctor_qualification" required/>
  </div>
  <div class="col-sm-2">
  <button class="btn btn-success glyphicon glyphicon-plus" onclick="return addelement(this);" id="degree"></button>
  </div>
  </div>    
  </div>  
  </div>
  <div class="form-group">
  <label for="doctor_yoe" class="control-label">Years of Experience </label>
  <input name="doctor_yoe" id="doctor_yoe" type="text" class="form-control" maxlength="2" value="<?php echo @$_POST['doctor_yoe']; ?>" required/>
  </div>
  
	<div class="form-group">
    <label class="control-label" for="doctor_contact_number">* Doctor Landline No</label>
    <input name="doctor_contact_number" id="doctor_contact_number" value="<?php echo @$_POST['doctor_contact_number']; ?>" type="text" placeholder="Number" class="form-control" maxlength="12" required />
  </div>
  <div class="form-group">
    <label class="control-label" for="clinic_contact_number">* Clinic Contact No : Use Comma (,) to separate numbers</label>
    <input name="clinic_contact_number" id="clinic_contact_number" value="<?php echo @$_POST['clinic_contact_number']; ?>" type="text" placeholder="Number" class="form-control" required />
  </div>	  
  <div class="form-group">
    <label class="control-label">Consultation Days &amp; Timings </label>
    <div class="row">
    <div class="col-sm-4">
    	<div class="panel panel-success">
      	<div class="panel-heading"><strong>Case (1)</strong></div>
        <div class="panel-body panel-consultation-note">
        Same on all Days :Click 'Copy to all Days' In case you dont Practice on Sunday , just deselect the Checkbox for Sunday.
        </div>
      </div>
    </div>
    <div class="col-sm-4">
    <div class="panel panel-success">
      	<div class="panel-heading"><strong>Case (2)</strong></div>
        <div class="panel-body panel-consultation-note">
        Different on Different Days Click 'Copy to all Days' and then deselect the checkbox for the day that you want to change the time & fill in  your Practice Time
        </div>
      </div>
    </div>
    <div class="col-sm-4">
    <div class="panel panel-success">
      	<div class="panel-heading"><strong>Case (3)</strong></div>
        <div class="panel-body panel-consultation-note">
        Different on all Days : Fill in the Time in each Tab individually
        </div>
      </div>
    </div>
    </div>
    <div class="table-responsive">
    <table class="table table-striped table-condensed table-bordered">
    <tr>
    <th class="text-center">Day</th>
    <th class="text-center" colspan="3">First Half</th>
    <th class="text-center" colspan="3">Second Half</th>
    <th class="text-center"><a href="javascript:void(0)" id="copy_to_all_days">Copy To All Days</a></th>
    </tr>
    <tr>
    <td width="80" align="center" class="from_fileld">
    Monday
    </td>
    <td width="82" align="center">
    <input name="mon_mor_open" type="text" class="day_time wk-dt-width" id="mon_mor_open" value="<?php echo isset($_POST['mon_mor_open']) ? $_POST['mon_mor_open'] : '10:00AM'; ?>" />
    </td>
    <td align="center" class="">
    To
    </td>
    <td width="82" align="center">
    <input name="mon_mor_close" type="text" class="day_time wk-dt-width" id="mon_mor_close" value="<?php echo isset($_POST['mon_mor_close']) ? $_POST['mon_mor_close'] : '01:00PM'; ?>" />
    </td>
    <td width="82" align="center">
    <input name="mon_eve_open" type="text" class="day_time wk-dt-width" id="mon_eve_open" value="<?php echo isset($_POST['mon_eve_open']) ? $_POST['mon_eve_open'] : '05:00PM'; ?>" />
    </td>
    <td align="center">
    To
    </td>
    <td width="82" align="center">
    <input name="mon_eve_close" type="text" class="day_time wk-dt-width" id="mon_eve_close" value="<?php echo isset($_POST['mon_eve_close']) ? $_POST['mon_eve_close'] : '08:00PM'; ?>" />
    </td>
    <td align="center">
    <input name="days[]" type="checkbox" class="checkbox_valid" id="mon" value="monday" checked="checked" />
    </td>
    </tr>
    <tr>
    <td align="center" class="from_fileld">
    Tuesday
    </td>
    <td align="center">
    <input name="tue_mor_open" type="text" class="day_time wk-dt-width" id="tue_mor_open" value="<?php echo isset($_POST['tue_mor_open']) ? $_POST['tue_mor_open'] : "10:00AM" ; ?>" />
    </td>
    <td align="center" >
    To
    </td>
    <td align="center">
    <input name="tue_mor_close" type="text" class="day_time wk-dt-width" id="tue_mor_close" value="<?php echo isset($_POST['tue_mor_close']) ? $_POST['tue_mor_close'] : "01:00PM" ; ?>"/>
    </td>
    <td align="center">
    <input name="tue_eve_open" type="text" class="day_time wk-dt-width" id="tue_eve_open" value="<?php echo isset($_POST['tue_eve_open']) ? $_POST['tue_eve_open'] : "05:00PM" ; ?>" />
    </td>
    <td align="center">
    To
    </td>
    <td align="center">
    <input name="tue_eve_close" type="text" class="day_time wk-dt-width" id="tue_eve_close" value="<?php echo isset($_POST['tue_eve_close']) ? $_POST['tue_eve_close'] : "08:00PM" ; ?>" />
    </td>
    <td align="center">
    <input name="days[]" type="checkbox" class="checkbox_valid" id="tue" value="tuesday" checked="checked" />
    </td>
    </tr>
    <tr>
    <td align="center" class="from_fileld">
    Wednesday
    </td>
    <td align="center">
    <input name="wed_mor_open" type="text" class="day_time wk-dt-width" id="wed_mor_open" value="<?php echo isset($_POST['wed_mor_open']) ? $_POST['wed_mor_open'] : "10:00AM" ; ?>" />
    </td>
    <td align="center">
    To
    </td>
    <td align="center">
    <input name="wed_mor_close" type="text" class="day_time wk-dt-width" id="wed_mor_close" value="<?php echo isset($_POST['wed_mor_close']) ? $_POST['wed_mor_close'] : "01:00PM" ; ?>" />
    </td>
    <td align="center">
    <input name="wed_eve_open" type="text" class="day_time wk-dt-width" id="wed_eve_open" value="<?php echo isset($_POST['wed_eve_open']) ? $_POST['wed_eve_open'] : "05:00PM" ; ?>" />
    </td>
    <td align="center">
    To
    </td>
    <td align="center">
    <input name="wed_eve_close" type="text" class="day_time wk-dt-width" id="wed_eve_close" value="<?php echo isset($_POST['wed_eve_close']) ? $_POST['wed_eve_close'] : "08:00PM" ; ?>" />
    </td>
    <td align="center">
    <input name="days[]" type="checkbox" class="checkbox_valid" id="wed" value="wednesday" checked="checked" />
    </td>
    </tr>
    <tr>
    <td align="center" class="from_fileld">
    Thursday
    </td>
    <td align="center">
    <input name="thu_mor_open" type="text" class="day_time wk-dt-width" id="thu_mor_open" value="<?php echo isset($_POST['thu_mor_open']) ? $_POST['thu_mor_open'] : "10:00AM" ; ?>" />
    </td>
    <td align="center">
    To
    </td>
    <td align="center">
    <input name="thu_mor_close" type="text" class="day_time wk-dt-width" id="thu_mor_close" value="<?php echo isset($_POST['thu_mor_close']) ? $_POST['thu_mor_close'] : "01:00PM" ; ?>" />
    </td>
    <td align="center">
    <input name="thu_eve_open" type="text" class="day_time wk-dt-width" id="thu_eve_open" value="<?php echo isset($_POST['thu_eve_open']) ? $_POST['thu_eve_open'] : "05:00PM" ; ?>" />
    </td>
    <td align="center">
    To
    </td>
    <td align="center">
    <input name="thu_eve_close" type="text" class="day_time wk-dt-width" id="thu_eve_close" value="<?php echo isset($_POST['thu_eve_close']) ? $_POST['thu_eve_close'] : "08:00PM" ; ?>" />
    </td>
    <td align="center">
    <input name="days[]" type="checkbox" class="checkbox_valid" id="thu" value="thursday" checked="checked" />
    </td>
    </tr>
    <tr>
    <td align="center" class="from_fileld">
    Friday
    </td>
    <td align="center">
    <input name="fri_mor_open" type="text" class="day_time wk-dt-width" id="fri_mor_open" value="<?php echo isset($_POST['fri_mor_open']) ? $_POST['fri_mor_open'] : "10:00AM" ; ?>" />
    </td>
    <td align="center">
    To
    </td>
    <td align="center">
    <input name="fri_mor_close" type="text" class="day_time wk-dt-width" id="fri_mor_close" value="<?php echo isset($_POST['fri_mor_close']) ? $_POST['fri_mor_close'] : "01:00PM" ; ?>" />
    </td>
    <td align="center">
    <input name="fri_eve_open" type="text" class="day_time wk-dt-width" id="fri_eve_open" value="<?php echo isset($_POST['fri_eve_open']) ? $_POST['fri_eve_open'] : "05:00PM" ; ?>" />
    </td>
    <td align="center">
    To
    </td>
    <td align="center">
    <input name="fri_eve_close" type="text" class="day_time wk-dt-width" id="fri_eve_close" value="<?php echo isset($_POST['fri_eve_close']) ? $_POST['fri_eve_close'] : "08:00PM" ; ?>" />
    </td>
    <td align="center">
    <input name="days[]" type="checkbox" class="checkbox_valid" id="fri" value="friday" checked="checked" />
    </td>
    </tr>
    <tr>
    <td align="center" class="from_fileld">
    Saturday
    </td>
    <td align="center">
    <input name="sat_mor_open" type="text" class="day_time wk-dt-width" id="sat_mor_open" value="<?php echo isset($_POST['sat_mor_open']) ? $_POST['sat_mor_open'] : "10:00AM" ; ?>" />
    </td>
    <td align="center">
    To
    </td>
    <td align="center">
    <input name="sat_mor_close" type="text" class="day_time wk-dt-width" id="sat_mor_close" value="<?php echo isset($_POST['sat_mor_close']) ? $_POST['sat_mor_close'] : "01:00PM" ; ?>" />
    </td>
    <td align="center">
    <input name="sat_eve_open" type="text" class="day_time wk-dt-width" id="sat_eve_open" value="<?php echo isset($_POST['sat_eve_open']) ? $_POST['sat_eve_open'] : "05:00PM" ; ?>" />
    </td>
    <td align="center">
    To
    </td>
    <td align="center">
    <input name="sat_eve_close" type="text" class="day_time wk-dt-width" id="sat_eve_close" value="<?php echo isset($_POST['sat_eve_close']) ? $_POST['sat_eve_close'] : "08:00PM" ; ?>" />
    </td>
    <td align="center">
    <input name="days[]" type="checkbox" class="checkbox_valid" id="sat" value="saturday" checked="checked" />
    </td>
    </tr>
    <tr>
    <td align="center" class="from_fileld">
    Sunday
    </td>
    <td align="center">
    <input name="sun_mor_open" type="text" class="day_time wk-dt-width" id="sun_mor_open" value="<?php echo isset($_POST['sun_mor_open']) ? $_POST['sun_mor_open'] : "10:00AM" ; ?>" />
    </td>
    <td align="center">
    To
    </td>
    <td align="center">
    <input name="sun_mor_close" type="text" class="day_time wk-dt-width" id="sun_mor_close" value="<?php echo isset($_POST['sun_mor_close']) ? $_POST['sun_mor_close'] : "01:00PM" ; ?>" />
    </td>
    <td align="center">
    <input name="sun_eve_open" type="text" class="day_time wk-dt-width" id="sun_eve_open" value="<?php echo isset($_POST['sun_eve_open']) ? $_POST['sun_eve_open'] : "05:00PM" ; ?>" />
    </td>
    <td align="center">
    To
    </td>
    <td align="center">
    <input name="sun_eve_close" type="text" class="day_time wk-dt-width" id="sun_eve_close" value="<?php echo isset($_POST['sun_eve_close']) ? $_POST['sun_eve_close'] : "08:00PM" ; ?>" />
    </td>
    <td align="center">
    <input name="days[]" type="checkbox" class="checkbox_valid" id="sun" value="sunday" checked="checked" />
    </td>
    </tr>
    </table>
    </div>
  </div>
  <div class="form-group  form-inline">
    <label class="control-label">First Consultation Fees</label>
    <div class="radio">
    <label class="label-control"><input type="radio" name="consult_fee" required value="1" <?php
    if(isset($_POST['consult_fee']) && $_POST['consult_fee'] == '1') echo ' checked="checked"'; ?> /> Rs. 100~300</label>
    
    <label class="label-control">
    <input type="radio" name="consult_fee" required value="2" <?php
    if(isset($_POST['consult_fee']) && $_POST['consult_fee'] == '2') echo ' checked="checked"'; ?> /> Rs. 301~500</label>
    <label class="label-control">
    <input type="radio" name="consult_fee" required value="3" <?php
    if(isset($_POST['consult_fee']) && $_POST['consult_fee'] == '3') echo ' checked="checked"'; ?> /> Rs. 501~750</label>
    <label class="label-control">
    <input type="radio" name="consult_fee" required value="4" <?php
    if(isset($_POST['consult_fee']) && $_POST['consult_fee'] == '4') echo ' checked="checked"'; ?> /> Rs. 751~1000</label>
    <label class="label-control">
    <input type="radio" name="consult_fee" required value="5" <?php
    if(isset($_POST['consult_fee']) && $_POST['consult_fee'] == '5') echo ' checked="checked"'; ?> /> more than Rs. 1000</label>
    </div>
    </div>
  <div class="form-group  form-inline">
    <label class="control-label">Average Duration of Appointment : </label>
    <input name="avg_patient_duration" id="avg_patient_duration " class="form-control autocomplete-duration" value="<?=@$_POST['avg_patient_duration'] ?>"  required /> <code>Minutes</code>
    </div>  
	<div class="form-group">
  	<div style="margin-bottom:20px;" class="row text-center">
            <h1>Add On Services <span class="label label-success">Coming Soon</span></h1>    
     	<!--<div class="col-sm-12">
    	<div class="panel">
      <div class="panel-heading ">
      <div class="text-center"><strong> Add On Services </strong></div>
      <div class="text-center">Would you like register to offer value added services to your patients?</div>
      </div>
      </div>
      </div> -->
    </div>
  	
    <div class="row">
      <div class="col-sm-4">
          <div class="panel panel-success panel-profile">
            <div class="panel-heading"></div>
            <div class="panel-body text-center panel-services">
              <img src="<?=IMAGE_URL?>teleconsulting_icon.png" class="panel-profile-img">
              <h5 class="panel-title services-panel" >Tele Consultation</h5>
              <p class="procedure-panel">We connect you to the Patients who take your Consultation Telephonically through an Appointment</p>
              <!--<p class="procedure-panel">Patient pays Tele Consultation fees as specified by you + BDA Service Charge of Rs. 100 through BDA Payment Gateway on BDA Website. Teleconsultation Appointment is confirmed only after confirmation of online payment by the patient. BDA pays you the Tele Consultation fees within 10 days from the Date of Tele Consultation in the Bank Account specified by you. Your Bank Details are taken after the 1st Tele consultation Service provided.</p>
              -->
            </div>
            <!--<div class="panel-footer">
            	<p class="text-center">
              <input type="text" placeholder="Rs." class="form-control" id="tele_fees" value="300" name="tele_fees" />
              </p>
            </div> -->
          </div>
        </div>
      <div class="col-sm-4">
        <div class="panel panel-warning panel-profile">
          <div class="panel-heading"></div>
          <div class="panel-body text-center panel-services">
            <img src="<?=IMAGE_URL?>online_consultation_icon.png" class="panel-profile-img">
            <h5 class="panel-title services-panel" >Online Consultation</h5>
            <p class="procedure-panel">We connect you to the Patients who take your Consultation Online through a Video Conferencing System with a prior Appointment</p>
            <!--<p class="procedure-panel">Patient pays Online Consultation fees as specified by you + BDA Service Charge. of Rs. 200 through BDA Payment Gateway on BDA Website. Online consultation Appointment is confirmed only after online payment by the patient. BDA pays you the Online Consultation fees within 10 days from the Date of Online Consultation in the Bank Account specified by you. Your Bank Details are taken after the 1st Online consultation Service provided. </p>
            -->
          </div>
         <!-- <div class="panel-footer">
            	<p class="text-center">
            <input type="text" placeholder="Rs." class="form-control" name="online_fees" value="500" id="online_fees">
            </p>
            </div> -->
        </div>
      </div>
      <div class="col-sm-4">
        <div class="panel panel-danger panel-profile ">
          <div class="panel-heading"></div>
          <div class="panel-body text-center panel-services">
            <img src="<?=IMAGE_URL?>express_appointment_icon.png" class="panel-profile-img">
            <h5 class="panel-title services-panel" >Express Appointment</h5>
            <p class="procedure-panel">For the Patients who do not want to wait for their turn and want your instant consultation</p>
            <!--<p class="procedure-panel">You may charge Premium Consultation fees for Express Appointment. Patient pays Premium Consultation fees as specified by you + BDA Service Charge of Rs. 100 through BDA Payment Gateway on BDA Website. Express Appointment is confirmed only after confirmation of online payment by the patient. BDA pays you the Premium Consultation fees within 10 days from the Date of Express Appointment in the Bank Account specified by you. Your Bank Details are taken after the 1st Express Appointment Service provided</p>
            -->
          </div>
          <!--<div class="panel-footer">
            	<p class="text-center">
            <input type="text" placeholder="Rs." class="form-control" name="express_fees" value="800" id="express_fees">
            </p>
            </div>-->
        </div>
      </div>
      
    </div>    
    </div>    
  <div class="form-group">
	    <div class="text-right">
        <input type="submit" name="add_hospital_doctor" class="btn btn-success" value="Save"/>
        <a href="javascript:;" onclick="history.back()" class="btn btn-danger">Cancel</a>
        </div>
    </div>
</form>
</div>
</div>
</div>
</div>
</div>    	
</div>    
</div>
<!-- Modal to upload the profile image-->    
<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog">
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title">Upload Image</h4>
</div>
<div class="modal-body">
<div class="imageBox">
<div class="thumbBox"></div>
<div class="spinner" style="display: none">Loading...</div>
</div>
<div class="PT5">
<span class="btn btn-primary btn-file">
Browse <input type="file" id="file">
</span>          
<button type="button" class="btn btn-primary" data-dismiss="modal" id="btnCrop">Crop</button>
<input type="button" id="btnZoomIn" value="Zoom in (+)" class="btn btn-primary">
<input type="button" id="btnZoomOut" value="Zoom out (-)" class="btn btn-primary">
</div>
<div class="cropped"></div>
</div>
</div>
</div>
</div>
</body>
<?php $this->load->view('login/common/footer'); ?>
<?php $this->load->view('login/common/bottom'); ?>
<!--PAGE SPECIFIC JS-->
<script src="<?php echo JS_URL; ?>admin/jquery.inputfile.js"></script>
<script src="<?php echo JS_URL; ?>admin/jquery-cropimg-plugin.js"></script>
<script src="<?php echo JS_URL; ?>login/jquery.plugin.js"></script>
<script src="<?php echo JS_URL; ?>login/jquery.timeentry.js"></script>
<script type="text/javascript">
$(window).load(function() {
	$("#myBtn").click(function(){
		$("#myModal").modal({backdrop: true});
		$('#file').click();
	});
	var options =
	{
	thumbBox: '.thumbBox',
	spinner: '.spinner',
	imgSrc: 'avatar.png'
	}
	var cropper;
	$('#file').on('change', function(){
	var reader = new FileReader();
	reader.onload = function(e) {
	options.imgSrc = e.target.result;
	cropper = $('.imageBox').cropbox(options);
	}
	reader.readAsDataURL(this.files[0]);
	this.files = [];
	})
	$('#btnCrop').on('click', function(){
	var img = cropper.getDataURL()
	$('#profileimgbox').html('<img src="'+img+'">');
	
	var imgtype= img.substr(0, img.indexOf(',')); 
	var base64imgvalue= img.substr(img.indexOf(',')+1, 999999999); 
	$('#profile_pic_base64').val(base64imgvalue);
	$('#profile_pic_base64_name').val($('#file').val());
	})
	$('#btnZoomIn').on('click', function(){
	cropper.zoomIn();
	})
	$('#btnZoomOut').on('click', function(){
	cropper.zoomOut();
	})
	//------------------------------------------------------------------
	$("#doctor_dob").datetimepicker({
		timepicker:false,
		format:'d-m-Y'
	});
	//------------------------------------------------------------------
	var speciality		=	 <?=$json_speciality;?>;
	var qualificaiton	=	 <?=$json_degree;?>;
	var council				=	 <?=$json_council;?>;
	$(".autocomplete-registration-council").autocomplete({
		source: council,
		minLength: 0,
		select: function( event, ui ) {
			$("#doctor_council").attr("value", ui.item.db_id)
		}
	}).focus(function() {$(this).autocomplete("search", $(this).val());});	
	$( ".autocomplete-specializations" ).autocomplete({
		source: speciality,
		select: function( event, ui ) {
			$(this).attr('value', ui.item.label);
			$(this).attr('attr-id', ui.item.db_id);
		},
		search: function( event, ui ) {
			$(this).attr('value', '');
			$(this).attr('attr-id', '');
		},
		minLength: 0
	}).focus(function() {$(this).autocomplete("search", $(this).val());});	
	$(".autocomplete-qualification").autocomplete({
		source: qualificaiton,
		minLength: 0,
		select: function( event, ui ) {
			$(this).attr('value', ui.item.label);
			$(this).attr('attr-id', ui.item.db_id);
		},
		search: function( event, ui ) {
			$(this).attr('value', '');
			$(this).attr('attr-id', '');
		}
	}).focus(function() {$(this).autocomplete("search", $(this).val());});	
	
	var duration	=	["5","10","15","20","25","30","35","40","45","50","55","60"];
	$(".autocomplete-duration").autocomplete({
		source: duration,
		minLength: 0
	}).focus(function() {$(this).autocomplete("search", $(this).val());});	
});
function addelement(obj)
{
	var element = $(obj).parent().prev().find('input');
	var db_value	=	element.val();
	var db_id	=	element.attr('attr-id');
	var ele_id	=	$(obj).attr('id');
	var input_name	=	 '';
	if(!db_value)return false;
	var html	=	'<div class="form-group">';
	html			+=	'<div class="row">';
	html			+=	'<div class="col-sm-10">';
	if(ele_id=='speciality')
	{
		if(db_id)
		{
			html	+=	'<input type="text"	class="form-control"	value="'+db_value+'"	readonly="readonly"/>';
	    html	+=	'<input type="hidden"	class="form-control"	value="'+db_id+'"	name="speciality[]" />';
		}
		else
		{
			html	+=	'<input name="speciality_other[]" type="text" class="form-control" value="'+db_value+'" readonly="readonly" />';
		}
	}
	else if(ele_id=='degree')
	{
		if(db_id)
		{
			html	+=	'<input type="text"	class="form-control"	value="'+db_value+'"	readonly="readonly"/>';
	    html	+=	'<input type="hidden"	class="form-control"	value="'+db_id+'"	name="degree[]" />';
		}
		else
		{
			html	+=	'<input name="degree_other[]" type="text" class="form-control" value="'+db_value+'" readonly="readonly" />';
		}
	}
	html	+=	'</div>';
	html	+=	'<div class="col-sm-2">';
	html	+=	'<button onclick="return removeelement(this)" class="btn btn-danger glyphicon glyphicon-minus"></button>';
	html	+=	'</div>';
	html	+=	'</div>';
	html	+=	'</div>';
	
	$(html).insertBefore(element.parent().parent());			
	element.val("");
	element.attr("value","");
	element.removeAttr("required");
	element.attr("attr-id","");
	return false;
}
function removeelement(obj)
{
  $(obj).parent().parent().remove();
	return false;
}
//----------------------------------------
$("#copy_to_all_days").click(function()
{
	var mon_mor_open = $("#mon_mor_open").val();
	var mon_mor_close = $("#mon_mor_close").val();
	var mon_eve_open = $("#mon_eve_open").val();
	var mon_eve_close = $("#mon_eve_close").val();

	$("#tue_mor_open").val(mon_mor_open);
	$("#wed_mor_open").val(mon_mor_open);
	$("#thu_mor_open").val(mon_mor_open);
	$("#fri_mor_open").val(mon_mor_open);
	$("#sat_mor_open").val(mon_mor_open);
	$("#sun_mor_open").val(mon_mor_open);

	$("#tue_eve_open").val(mon_eve_open);
	$("#wed_eve_open").val(mon_eve_open);
	$("#thu_eve_open").val(mon_eve_open);
	$("#fri_eve_open").val(mon_eve_open);
	$("#sat_eve_open").val(mon_eve_open);
	$("#sun_eve_open").val(mon_eve_open);

	$("#tue_mor_close").val(mon_mor_close);
	$("#wed_mor_close").val(mon_mor_close);
	$("#thu_mor_close").val(mon_mor_close);
	$("#fri_mor_close").val(mon_mor_close);
	$("#sat_mor_close").val(mon_mor_close);
	$("#sun_mor_close").val(mon_mor_close);

	$("#tue_eve_close").val(mon_eve_close);
	$("#wed_eve_close").val(mon_eve_close);
	$("#thu_eve_close").val(mon_eve_close);
	$("#fri_eve_close").val(mon_eve_close);
	$("#sat_eve_close").val(mon_eve_close);
	$("#sun_eve_close").val(mon_eve_close);

	if(mon_mor_open == '' && mon_mor_close == '' && mon_eve_open == '' && mon_eve_close == '')
	{
		$(".checkbox_valid").each(function()
			{
				this.checked = false;
			});
	}
	else
	{
		$(".checkbox_valid").each(function()
			{
				this.checked = true;
			});
	}

});

if($("#mon_mor_open").val() == '' && $("#mon_mor_close").val() == '' && $("#mon_eve_open").val() == '' && $("#mon_eve_close").val() == '')
{
$("#mon").prop('checked', false);
}
if($("#tue_mor_open").val() == '' && $("#tue_mor_close").val() == '' && $("#tue_eve_open").val() == '' && $("#tue_eve_close").val() == '')
{
$("#tue").prop('checked', false);
}
if($("#wed_mor_open").val() == '' && $("#wed_mor_close").val() == '' && $("#wed_eve_open").val() == '' && $("#wed_eve_close").val() == '')
{
$("#wed").prop('checked', false);
}
if($("#thu_mor_open").val() == '' && $("#thu_mor_close").val() == '' && $("#thu_eve_open").val() == '' && $("#thu_eve_close").val() == '')
{
$("#thu").prop('checked', false);
}
if($("#fri_mor_open").val() == '' && $("#fri_mor_close").val() == '' && $("#fri_eve_open").val() == '' && $("#fri_eve_close").val() == '')
{
$("#fri").prop('checked', false);
}
if($("#sat_mor_open").val() == '' && $("#sat_mor_close").val() == '' && $("#sat_eve_open").val() == '' && $("#sat_eve_close").val() == '')
{
$("#sat").prop('checked', false);
}
if($("#sun_mor_open").val() == '' && $("#sun_mor_close").val() == '' && $("#sun_eve_open").val() == '' && $("#sun_eve_close").val() == '')
{
$("#sun").prop('checked', false);
}


$(".checkbox_valid").click(function()
{
//alert(5);
var id = $(this).attr('id');
var check_status = $(this).is(":checked");
if((check_status) == false)
{
	var day_mor_open = id+'_mor_open';
	var day_mor_close = id+'_mor_close';
	var day_eve_open = id+'_eve_open';
	var day_eve_close = id+'_eve_close';
	$("#"+day_mor_open).val('');
	$("#"+day_mor_close).val('');
	$("#"+day_eve_open).val('');
	$("#"+day_eve_close).val('');
}
else
{
	var day_mor_open = id+'_mor_open';
	var day_mor_close = id+'_mor_close';
	var day_eve_open = id+'_eve_open';
	var day_eve_close = id+'_eve_close';
	$("#"+day_mor_open).val('10:00AM');
	$("#"+day_mor_close).val('01:00PM');
	$("#"+day_eve_open).val('05:00PM');
	$("#"+day_eve_close).val('08:00PM');
}
});
$(".day_time").timeEntry(
{
	spinnerImage: '',
	timeSteps: [1, 5, 0],
	defaultTime: '09:00AM'
});
</script>
<!--PAGE SPECIFIC JS-->

</html>
