<!doctype html>
<html>
<head>
	<?php $this->load->view('common/head'); ?>
  <link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>bda.css">
  <link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>validationEngine.jquery.css">
</head>

<body>
<div id="header">
	<h1 class="display-none">Book Doctor Appointment - Contact Us</h1>
	<?php $this->load->view('common/header');?>
</div>
<div id="content"><!--content Start-->
 	<div class="contactus-page-container"><!--contactus-page-container Start-->
    <div class="container cf"><!--container Start-->
      <div class="full-width last margin-bottom-0"><!--full-width Start-->
        <div class="contactus-page-contInner1"><!--contactus-page-contInner1 Start-->
        <h1>Contact Us</h1>
        </div><!--contactus-page-contInner1 End-->
        <div class="contactus-page-contInner2"><!--contactus-page-contInner2 Start-->
          <div class="one-half margin-bottom-0"><!--one-half margin-bottom-0 Start-->
            <div class="HeadOffice_Box cf"><!--HeadOffice_Box Start-->
              <div class="HeadOffice_Box_Top"><!--HeadOffice_Box_Top Start-->
                <h1>Head Office</h1>			
              </div><!--HeadOffice_Box_Top End-->
              <div class="HeadOffice_Box_Top2"><!--HeadOffice_Box_Top2 Start-->
                <div class="HeadOffice_Box_Top2_Left">
                  <img alt="contact" src="<?=IMAGE_URL?>icon23.png">
                </div>
                      <div class="HeadOffice_Box_Top2_Right">
                  <p>BookDrAppointment.com</p>
                  <p>Pharma and Medical Concepts Pvt. Ltd.</p>
                  <p>SB-48, 2nd Floor,</p>
                  <p>Highland Corporate Center,</p>
                  <p>Next to High Street Mall, Majiwada,</p>
                  <p>Thane (West) - 400607</p>
                </div>
              </div><!--HeadOffice_Box_Top2 End-->
              <div class="HeadOffice_Box_Top4"><!--HeadOffice_Box_Top4 Start-->
                <p><a href="javascript:;" id="contactus-view-map">View Map</a></p>
              </div><!--HeadOffice_Box_Top3 End-->
              <div class="HeadOffice_Box_Top3"><!--HeadOffice_Box_Top3 Start-->
                <div class="HeadOffice_Box_Top3_Left">
                  <img alt="contact" src="<?=IMAGE_URL?>icon24.png">
                </div>
                      <div class="HeadOffice_Box_Top3_Right">
                  <p><a href="mailto:support@bookdrappointment.com">support@bookdrappointment.com </a></p>
                </div>
              </div><!--HeadOffice_Box_Top3 End-->
              <div class="HeadOffice_Box_Top3"><!--HeadOffice_Box_Top3 Start-->
                <div class="HeadOffice_Box_Top3_Left">
                  <img alt="contact" src="<?=IMAGE_URL?>icon25.png">
                </div>
                      <div class="HeadOffice_Box_Top3_Right">
                  <p>+91 - 22 - 49 426 426</p>
                </div>
              </div><!--HeadOffice_Box_Top3 End-->
              <div class="HeadOffice_Box_Top5"><!--HeadOffice_Box_Top5 Start-->
                <div class="Patient_Faq1">
                  <a href="<?=BASE_URL?>patient-faq.html">Patient : FAQs</a>
                </div>
                      <div class="Patient_Faq1 Last45">
                  <a href="<?=BASE_URL?>doctor-faq.html">Doctor : FAQs</a>
                </div>
              </div><!--HeadOffice_Box_Top5 End-->
              <div class="HeadOffice_Box_Top6"><!--HeadOffice_Box_Top6 Start-->
                <div class="social_media_contact1">
                  Connect with us !
                </div>
                  <div class="social_media_contact1">
                    <p><a href="https://www.facebook.com/bookdrappointment" target="_blank"><img alt="contact" src="<?=IMAGE_URL?>sicon1.png"></a></p>
                    <p><a href="https://twitter.com/BookDrAppointm" target="_blank"><img alt="contact" src="<?=IMAGE_URL?>sicon2.png"></a></p>
                    <p><a href="https://www.linkedin.com/company/book-dr-appointment-com" target="_blank"><img alt="contact" src="<?=IMAGE_URL?>sicon3.png"></a></p>
                    <p class="Last65"><a href="https://plus.google.com/+BookdrappointmentOnline" target="_blank"><img alt="contact" src="<?=IMAGE_URL?>sicon4.png"></a></p>
	                </div>
              </div><!--HeadOffice_Box_Top5 End-->
            </div><!--HeadOffice_Box End-->
          </div><!--one-half margin-bottom-0 End-->
          <div class="one-half last margin-bottom-0"><!--one-half margin-bottom-0 Start-->
            <div class="Contactpage_form_Box"><!--Contactpage_form_Box Start-->
              <div class="Contact_Cartoon"></div>
              <div class="Contactpage_form_BoxInner1 cf"><!--Contactpage_form_BoxInner1 Start-->
              	<form id="contact_form">
                <input type="text" placeholder="Name" name="contact_name" id="contact_name" class="validate[required,custom[onlyLetterSp]] text-input" >
                <input type="text" placeholder="Email" name="email_id" id="email_id" class="validate[required,custom[email]] text-input">
                <input type="text" placeholder="Mobile Number " name="mobile_number" id="mobile_number" maxlength="10"  class="validate[required,custom[phone]] text-input">
                <input type="text" placeholder="Subject" name="subject" id="subject" class="validate[required] text-input">
                <textarea cols="45" rows="8" placeholder="Message" id="message"  name="message" class="validate[required] text-input"></textarea>
                <div class="Contactpage_form_Box4"><!--.Contactpage_form_Box4 Start-->
                  <p><a href="javascript:;" id="contact_form_reset" onClick="$('contact_form').reset();">Reset</a></p>
                  <p><a href="javascript:;" id="contact_form_submit">Submit</a></p>
                </div><!--Contactpage_form_Box4 End-->
                </form>
              </div><!--Contactpage_form_BoxInner1 End-->
            </div><!--Contactpage_form_Box End-->
          </div><!--one-half margin-bottom-0 End-->
        </div><!--contactus-page-contInner2 End-->
      </div><!--full-width End-->
    </div><!--container End-->
  </div><!--contactus-page-container End-->
</div>
<div id="footer">
	<?php $this->load->view('common/footer'); ?>
</div>  
<?php $this->load->view('common/bottom'); ?>
<div class="view-map-popup" style="display: none;">
	<a target="_blank" id="view-map-popup-link" >
  <img id="view-map-popup-img" src="" alt="Google Map" style="width:100%;height:100%">
  </a>
</div>
<!--PAGE SPECIFIC JS-->
<script type="text/javascript" src="<?=JS_URL?>jquery.validationEngine.js"></script> 
<script type="text/javascript" src="<?=JS_URL?>jquery.validationEngine-en.js"></script> 
<script src="<?php echo JS_URL; ?>jquery.bpopup.min.js"></script>
<script type="application/javascript">
$(function()
{

	$("#contactus-view-map").click(function(){
		var latitude	=	'19.217284';
		var longitude	=	'72.980844';
		var dir_address	='Highland+Corporate+Centre/@19.217284,72.980844,17z/data=!3m1!4b1!4m2!3m1!1s0x3be7b94592f279e1:0xf15154598cf886d2';
		var address	='Highland+Corporate+Centre/@19.217284,72.980844';
		
		$("#view-map-popup-link").attr("href",'https://www.google.com/maps/dir//'+dir_address);
		$("#view-map-popup-img").attr("src",'http://maps.googleapis.com/maps/api/staticmap?center='+latitude+','+longitude+'&zoom=14&scale=false&size=600x300&maptype=roadmap&format=png&visual_refresh=true&markers=size:mid|color:red|label:1|'+latitude+','+longitude+'&markers=size:mid|color:red|label:1|'+latitude+','+longitude)

		$(".view-map-popup").bPopup();
	});
	
	$("#contact_form_reset").click(function()
	{
		document.getElementById("contact_form").reset();
	});
	$("#contact_form").validationEngine('attach', {promptPosition : "bottomRight", scroll: false});
	$("#contact_form_submit").click(function()
	{
		if($("#contact_form").validationEngine('validate'))
		{
			var contact_name = $("#contact_name").val()
			var email_id = $("#email_id").val()
			var mobile_number = $("#mobile_number").val()
			var subject = $("#subject").val()
			var message = $("#message").val()
			$("#contactSubmit").attr("onclick","");
			 $.post("<?=BASE_URL?>utility/sendmail1","contact_name="+contact_name+"&email_id="+email_id+"&mobile_number="+mobile_number+"&subject="+
			 subject+"&message="+message,function(resp){
				 alert("We will contact you shortly");
				 document.getElementById("contact_form").reset();
			})	
		}
	});
});
</script>
<!--PAGE SPECIFIC JS-->
</body>
</html>