<?php $this->load->view('mailers/common/practo_header.php'); ?>    
  <div style="padding:5px;font-size:11pt;font-weight:bold">Hi <?php echo (isset($name)?$name:"User"); ?>,</div>
  <div style="padding:5px">
  We are in process of scheduling your requested appointment with Dr. <?=isset($dr_name)?$dr_name:''?>. You will receive a confirmation shortly.
  </div>
  <div style="padding:5px">
  <table cellspacing="0" cellpadding="3" style="margin-top:5px;margin-bottom:5px;border:none;width:540px;color:#333;font-size:10pt;line-height:1.5">
      <tbody>
          <tr>
              <td style="width:170px;font-weight:bold;border-top:1px solid #ebebeb;border-bottom:1px solid #ebebeb">Doctor's Name</td>
              <td style="width:350px;font-weight:bold;border-top:1px solid #ebebeb;border-bottom:1px solid #ebebeb">Dr. <?=isset($dr_name)?$dr_name:'Doctor name'?>
              </td>
          </tr>
          <tr>
              <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Clinic Address</td>
              <td style="width:350px;border-bottom:1px solid #ebebeb"><?=isset($clinic_address)?$clinic_address:' clinic address' ?></td>
          </tr>
          <tr>
              <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Clinic Contact Number</td>
              <td style="width:350px;border-bottom:1px solid #ebebeb"><?=isset($clinic_number)?$clinic_number:''?></td>
          </tr>
          <tr>
              <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Patient's Name</td>
              <td style="width:350px;border-bottom:1px solid #ebebeb"><?=isset($name)?$name:''?></td>
          </tr>
          <tr>
              <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Appointment Time</td>
              <td style="width:350px;border-bottom:1px solid #ebebeb">
                  <span>
                      <span><?=isset($appointment_time)?$appointment_time:'' ?></span>
                  </span>
              </td>
          </tr>
          <tr>
              <td style="width:170px;font-weight:bold;border-bottom:1px solid #ebebeb">Appointment Reason</td>
              <td style="width:350px;border-bottom:1px solid #ebebeb"><?=isset($reason_for_visit)?$reason_for_visit:''?></td>
          </tr>
      </tbody>
  </table>
  </div>
<?php $this->load->view('mailers/common/practo_footer.php'); ?>    
