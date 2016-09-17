<div class="appointment-doctor-pro-display-panel2 cf"><!--appointment-doctor-pro-display-panel2 Start-->
  <div class="appointment-doctor-pro-display-panel3 cf"><!--appointment-doctor-pro-display-panel2 Start-->
    <div class="one-third margin-bottom-0"><!--one-half Start-->
      <div class="appointment-doctor-cartoon"><!--appointment-doctor-cartoon Start-->
        <span class="cf"><img src="<?php echo IMAGE_URL; ?>appointment_cartoon.png" alt="Login"></span>
      </div><!--appointment-doctor-cartoon End-->
    </div><!--one-half End-->
    <div class="two-third last margin-bottom-0"><!--two-third Start-->
      <div class="appointment-doctor-request-Box1"><!--appointment-doctor-request-Box1 Start-->
        <div class="appointment-doctor-request-Box2"><!--appointment-doctor-request-Box2 Start-->
        <h1>Appointment Request<!--Confirmation--></h1>
        </div><!--appointment-doctor-request-Box2 End-->
        <div class="appointment-doctor-request-Box4"><!--appointment-doctor-request-Box3 Start-->
        <p>We are in process of confirming your appointment. You will hear from us soon regarding your confirmed appointment.</p>
        </div>         
         <div class="appointment-doctor-request-Box3"><!--appointment-doctor-request-Box3 Start-->
          <p>Patient/Visiter Name</p>
          <span><?=$aptData['patient_name'] ?></span>
         </div><!--appointment-doctor-request-Box3 End-->
         <div class="appointment-doctor-request-Box3"><!--appointment-doctor-request-Box3 Start-->
          <p>Appointment Reason</p>
          <span><?=$aptData['reason_for_visit'] ?></span>
         </div><!--appointment-doctor-request-Box3 End-->
         <div class="appointment-doctor-request-Box3"><!--appointment-doctor-request-Box3 Start-->
          <p>Appointment Request ID</p>
          <span class="Bred"><?=$aptData['appointment_id'] ?></span>
         </div><!--appointment-doctor-request-Box3 End-->
         <div class="appointment-doctor-request-Box3"><!--appointment-doctor-request-Box3 Start-->
          <p>Mobile</p>
          <span>+91 <?=$aptData['mobile_number'] ?></span>
         </div><!--appointment-doctor-request-Box3 End-->
         <div class="appointment-doctor-request-Box4"><!--appointment-doctor-request-Box4 Start-->
          <p>We have sent your Appointment details through Email and SMS .</p>
          <!--<p>If this time no longer works for you, please <a href="javascript:;">reschedule</a>, <a href="javascript:;">cancel</a> or <a href="javascript:;">Contact Us</a>.</p>-->         
          </div><!--appointment-doctor-request-Box4 End-->
      </div><!--appointment-doctor-request-Box1 End-->
    </div><!--two-third End-->
  </div><!--appointment-doctor-pro-display-panel2 Start-->
</div>