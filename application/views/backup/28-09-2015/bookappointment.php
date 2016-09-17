<!doctype html>
<html>
<head>
	<?php $this->load->view('common/head'); ?>
  <link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>font-styles.css">
  <link href="<?php echo CSS_URL; ?>owl.carousel.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>lightbox.css">
  <link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>bda.css">
</head>
<body>
<div id="header">
	<?php $this->load->view('common/header'); ?>
</div>
<div id="content"><!--content Start-->
<div class="container cf" id="apt"><!--container cf Start-->
  <div class="appointment-doctor-pro-display-panel cf"><!--appointment-doctor-pro-display-panel Start-->
    <div class="two-third margin-bottom-0"><!--two-third Start-->
      <div class="appointment-profile-photo-panel"><!--appointment-profile-photo-panel Start-->
        <div class="appointment-profile-photo">
        <img src="<?=$apt['doctor']['doctor_image']?>" alt="Doctor Profile Photo">
        </div>
      </div><!--appointment-profile-photo-panel End-->
      <div class="appointment-profile-march-cont"><!--appointment-profile-march-cont Start-->
			<div class="appointment-profile-description-panel"><!--ppointment-profile-description-panel Start-->
        <h2><?=$apt['doctor']['name']?></h2>
        <p class="bold-text"><?=$apt['doctor']['qualificationStr']?></p>
        <p><?=$apt['doctor']['specialityStr']?></p>
      </div><!--ppointment-profile-description-panel End-->
      <div class="appointment-profile-description-panel2"><!--ppointment-profile-description-panel Start-->
        <ul>
          <li class="appo-time"><?=$apt['date']?></li>
          <li class="appo-time1 appo-time45"> <p><?=$apt['time']?></p></li>
        </ul>
      </div><!--ppointment-profile-description-panel End-->
      </div><!--appointment-profile-march-cont End-->
    </div><!--two-third End-->
    <div class="one-third last margin-bottom-0"><!--one-third last Start-->
      <ul class="appo-ti-doctor-pro-clinic-details cf">
      <li class="appo-ti-clinic-location">
      <span class="appo-ti-clinic-location-bold-text"><?=$apt['doctor']['clinic_name']?></span><br/>
      <?=$apt['doctor']['clinic_address']?>
      </li>
      <!--<li class="appo-ti-profile-clinic-fees">100 - 300</li>-->
      <?php if($apt['doctor']['latitude'] && $apt['doctor']['longitude'])
			{ ?> 
      <a class="appo-ti-clinic-location-map-bt" href="javascript:;" id="view-map">View Map</a>
      <?php }?>
      </ul>
    </div><!--one-third last End-->
  </div><!--appointment-doctor-pro-display-panel Start-->
  <div class="appointment-doctor-pro-display-panel1 cf" id="appointment_details_text"><!--appointment-doctor-pro-display-panel1 Start-->
  	<h1>Provide your Appointment details</h1>
  </div><!--appointment-doctor-pro-display-panel1 Start-->
  <div class="appointment-doctor-pro-display-panel2 cf" id="appointment_container"><!--appointment-doctor-pro-display-panel2 Start-->
    <div class="appointment-doctor-pro-display-panel3 cf"><!--appointment-doctor-pro-display-panel2 Start-->
    
    <div class="one-third margin-bottom-0" id="login_container"><!--one-half Start-->
      <div class="appointment-doctor-social-Box1"><!--appointment-doctor-social-Box1 Start-->
      <h2>Book Appointment via </h2>
      <span class="cf" id="facebook_login"><img src="<?php echo IMAGE_URL; ?>face_bt1.png" alt="Facebook" class="pointer"></span>
      <p>OR</p>
      <span class="cf"><a href="javascript:;" id="bda_login_btn"><img src="<?php echo IMAGE_URL; ?>login_bt.png" alt="Login"></a></span>
      </div><!--appointment-doctor-social-Box1 End-->
    </div><!--one-half End-->

    <div class="one-third margin-bottom-0 hide" id="bda_loigin_popup"><!--one-half Start-->
	    <div class="appointment-doctor-social-Box3"><!--appointment-doctor-social-Box3 Start-->
        <h2><a id="bda_back_btn" href="javascript:;">Back</a></h2>
        <div class="appointment-doctor-FormBox11"><!--appointment-doctor-FormBox11 Start-->
          <label>Email <span class="compulsary">*</span></label>
          <input type="text" name="email" id="email" />
        </div><!--appointment-doctor-FormBox11 End-->
        <div class="appointment-doctor-FormBox11"><!--appointment-doctor-FormBox11 Start-->
          <label>Password <span class="compulsary">*</span></label>
          <input type="password" name="password" id="password" />
        </div><!--appointment-doctor-FormBox11 End-->
        <div class="appointment-doctor-FormBox11"><!--appointment-doctor-FormBox11 Start-->
	        <a class="appointment-doctor-bt11" id="user_login_btn" href="javascript:;">SUBMIT</a>
        </div><!--appointment-doctor-FormBox1 End-->
        <div class="appointment-doctor-FormBox11" id="loginerror"><!--appointment-doctor-FormBox11 Start-->

        </div><!--appointment-doctor-FormBox1 End-->
      </div><!--appointment-doctor-social-Box3 End-->
    </div><!--one-half End-->
    
    <div class="two-third last margin-bottom-0"><!--one-half Start-->
    <div class="appointment-doctor-social-Box2"><!--appointment-doctor-social-Box2 Start-->
      <div class="appointment-orgd">OR</div>	
      <form id="form1" name="form1" method="post" action="">
        <!--appointment-doctor-FormBox1 Start-->
        <div class="appointment-doctor-FormBox1">
          <label>Patient Name  <span class="compulsary">*</span></label>
          <input type="text" name="patient_name" id="patient_name" value="<?=(isset($patient_name)?$patient_name:'')?>" />
        </div>
        <!--appointment-doctor-FormBox1 End-->
        <!--appointment-doctor-FormBox1 Start-->
        <div class="appointment-doctor-FormBox1">
        <label>Email  <span class="compulsary">*</span></label>
        <input type="text" name="email_id" id="email_id" value="<?=(isset($patient_name)?$email_id:'')?>" />
        </div>
        <!--appointment-doctor-FormBox1 End-->
        <!--appointment-doctor-FormBox1 Start-->
        <div class="appointment-doctor-FormBox1">
          <label>Reason For Visit </label>
          <input type="text" name="reason_for_visit" id="reason_for_visit" />
        </div>
        <!--appointment-doctor-FormBox1 End-->
        <!--appointment-doctor-FormBox4 Start-->
				<div class="appointment-doctor-FormBox4">
          <label>Gender<span class="compulsary">*</span></label>
          <p><input type="radio" name="gender" value="m" id="male" <?=(isset($gender) && $gender == "m" )?'checked="checked"':''?> />  Male</p>
          <p><input type="radio" name="gender" value="f" id="female" <?=(isset($gender) && $gender == "f" )?'checked="checked"':''?> />Female</p>
        </div>
        <!--appointment-doctor-FormBox4 End-->
        <!--appointment-doctor-FormBox1 Start-->
        <div class="appointment-doctor-FormBox1">
          <label>Mobile No. <span class="compulsary">*</span></label>
          <input type="text" name="mobile_number" id="mobile_number" value="<?=(isset($patient_name)?$mobile_number:'')?>" onKeyUp="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" maxlength="10" placeholder="8888888888 or 2249425883" />
        </div>
        <!--appointment-doctor-FormBox1 End-->
        <!--appointment-doctor-FormBox1 Start-->
        <div class="appointment-doctor-FormBox1">
          <input type="hidden" name="user_id" id="user_id" value="<?=$user_id?>" />
          <input type="hidden" name="city_id" id="city_id" value="<?=$apt['doctor']['clinic_city_id']?>" />
          <input type="hidden" name="user_type" id="user_type" value="<?=$user_type?>" />
          <input type="hidden" name="date" id="date" value="<?=$date?>" />
          <input type="hidden" name="time" id="time" value="<?=$time?>" />
          <input type="hidden" name="image" id="image" value="" />
          <input type="hidden" name="doctor_id" id="doctor_id" value="<?=$apt['doctor_id']?>" />
          <input type="hidden" name="clinic_contact_number" id="clinic_contact_number" value="<?=$apt['doctor']['clinic_contact_number']?>" />
          <input type="hidden" name="doctor_contact_number" id="doctor_contact_number" value="<?=$apt['doctor']['doctor_contact_number']?>" />
          
          <input type="hidden" name="clinic_id" id="clinic_id" value="<?=$apt['clinic_id']?>" />
          <input type="hidden" name="fb_id" id="fb_id" value="" />
          
          <input type="hidden" name="doctor_name" id="doctor_name" value="<?=$apt['doctor']['name']?>" />
          <input type="hidden" name="clinic_name" id="clinic_name" value="<?=$apt['doctor']['clinic_name']?>" />
          
          <a class="appointment-doctor-bt" id="appointment_done" href="javascript:;" onClick="return saveappointment();">Done</a>
        </div>
      </form>
    </div><!--appointment-doctor-FormBox1 End-->
    <div class="appointment-doctor-FormBox2 hide" id="miss_call_msg"><!--appointment-doctor-FormBox2 Start-->
      <div align="center" style="" class="appointment-doctor-FormBox2Inner"><!-- padding:2% 0%; appointment-doctor-FormBox2Inner Start-->
      <div class="Right45"><!--margin-left: 10%; margin-top: 9%;-->
        <span>Verify your Mobile Number</span>
        <img alt="Login" src="<?=IMAGE_URL?>appoint1.png">
        <p>Please give a missed call on Toll free Number </p>
        <a href="tel:02249425883"><span>022 49 425 883</span></a>
        <p> * This is important to keep you informed regarding your appointment status</p>
      </div>
       <!--<div style="" class="Right45">padding-left: 10%;-->

      </div>
      </div><!--appointment-doctor-FormBox2Inner End-->
    </div><!--appointment-doctor-FormBox2 End-->    
    </div><!--appointment-doctor-social-Box2 End-->
		
  </div><!--one-half End-->
  </div><!--appointment-doctor-pro-display-panel2 Start-->
</div><!--appointment-doctor-pro-display-panel2 Start-->
</div><!--container cf End-->

<div id="footer">
	<?php $this->load->view('common/footer'); ?>
</div>
<div id="fb-root"></div>
<?php $this->load->view('common/bottom'); ?>
<script src="<?php echo JS_URL; ?>owl.carousel.js"></script>
<script src="<?php echo JS_URL; ?>lightbox.js"></script>
<script src="<?=JS_URL?>jquery.bpopup.min.js"></script>
<div class="modalbpopup2" style="display: none;">
<img src="<?=BASE_URL?>static/images/bdaloader.gif">
</div>
<?php if($apt['doctor']['latitude'] && $apt['doctor']['longitude']){ 
$lat_lng	=	$apt['doctor']['latitude'].",".$apt['doctor']['longitude'];
?> 
<div class="view-map-popup" style="display: none;">
<a href="https://www.google.com/maps/dir//<?=$lat_lng?>/" target="_blank">
<img src="//maps.googleapis.com/maps/api/staticmap?center=<?=$lat_lng?>&zoom=14&scale=false&size=600x300&maptype=roadmap&format=png&visual_refresh=true&markers=size:mid|color:red|label:1|<?=$lat_lng?>&markers=size:mid|color:red|label:1|<?=$lat_lng?>" alt="Google Map" style="width:100%;height:100%"></a>
</div>
<?php }?>
<script type="text/javascript">
var myInterval = "";
/*function send_for_verification(appointment_id)
{
	var mobile_number = $("#mobile_number").val();
	if(mobile_number){
	$.ajax({
		url : '<?=BASE_URL?>api/knowlarity/send_for_verification',
		type : 'POST',
		data : {
			"callernumber":mobile_number
		},
		success: function(response)
		{
			if(response.status==1){
				$("#appointment_container").html($("#miss_call_msg").html());
				myInterval = setInterval(function(){ verified_caller(appointment_id,mobile_number); }, 5000);
			}else{
				alert("please send again");
			}
		}
	});
	}
}*/
function send_for_verification(appointment_id)
{
	var mobile_number = $("#mobile_number").val();
	$("#appointment_container").html($("#miss_call_msg").html());
	myInterval = setInterval(function(){ verified_caller(appointment_id,mobile_number); }, 5000);
}

function verified_caller(appointment_id,mobile_number)
{
	//var mobile_number = $("#mobile_number").val();
	if(mobile_number)
	{
		$.ajax(
		{
		url : '<?=BASE_URL?>api/knowlarity/verified_caller',
		type : 'POST',
		data :
		{
		"callernumber":mobile_number,
		"appointment_id":appointment_id,
		},
		success: function(response)
		{
		if(response.status==1)
		{
			clearInterval(myInterval);
			$.ajax(
				{
					url : '/bookappointment/appointment_success',
					type : 'POST',
					data :{'appointment_id':appointment_id},
					success: function(response)
					{
						$("#appointment_container").html(response);
						$("#appointment_details_text").hide();
					}
			});
		}
		
		}
		});
	}

}

function saveappointment()
{
var obj ={};
obj['patient_name'] = $('#patient_name').val();
obj['email_id'] = $('#email_id').val();
obj['code'] = $('#code').val();
obj['mobile_number'] = $('#mobile_number').val();
obj['doctor_contact_number'] = $('#doctor_contact_number').val();
obj['clinic_contact_number'] = $('#clinic_contact_number').val();
obj['clinic_name'] = $('#clinic_name').val();
obj['reason_for_visit'] = $('#reason_for_visit').val();
obj['gender'] = $('input:radio[name=gender]:checked').val();
obj['user_id'] = $('#user_id').val();
obj['user_type'] = $('#user_type').val();
obj['date'] = $('#date').val();
obj['time'] = $('#time').val();
obj['doctor_id'] = $('#doctor_id').val();
obj['doctor_name'] = $('#doctor_name').val();
obj['clinic_id'] = $('#clinic_id').val();
obj['fb_id'] = $('#fb_id').val();
obj['city_id'] = $('#city_id').val();

if(obj['patient_name']=="")
{
alert("please provide Patient Name");
return false;
}
if(obj['email_id']=="")
{
alert("please provide Email Id");
return false;
}
if(obj['gender']===undefined)
{
alert("please provide gender");
return false;
}
if(obj['mobile_number']=="")
{
alert("please provide Mobile Number");
return false;
}

var arr = obj['mobile_number'].match(/^\d{10}$/);

if(arr===null)
{
alert("Please Provide 10 digit Number");
return false;
}

var bPopup2 = $(".modalbpopup2").bPopup(
{
positionStyle: 'fixed',
closeClass: 'modalclose'
});

$.ajax(
{
url: '/bookappointment/saveappointment',
type: "POST",
data:obj,
success : function(resp)
{
$(".modalbpopup2").bPopup().close();
if(resp=="-1")
{
alert("please verify your mobile number.");
}else if(resp=="0")
{
alert("Appoitment is already booked with this time slot please choose another time slot...");
}else if(resp)
{
//$("#miss_call_msg").show();
//$("#bookdrappointment").hide();
send_for_verification(resp)
//window.location.href = "<?=BASE_URL?>bookappointment/appointment_success/"+resp;

}
},
error : function(resp)
{
$(".modalbpopup2").bPopup().close();
}

});
return false;
}

window.fbAsyncInit = function()
{
FB.init(
{
appId      : '<?=$this->config->item('appId') ?>',//'525225767614514'
xfbml      : true,
version    : 'v2.1'
});
};

(function(d, s, id)
{
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id))
{
return;
}
js = d.createElement(s); js.id = id;
js.src = "//connect.facebook.net/en_US/sdk.js";
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
<script type="text/javascript">
$(document).ready(function(){
	/*$( "#tabs" ).tabs();*/
});
</script>
</body>
</html>
