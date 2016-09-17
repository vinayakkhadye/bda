<?php $this->load->view('mailers/common/practo_header.php'); ?>    
  <div style="padding:5px;font-size:11pt;font-weight:bold">Hi <?php echo (isset($name)?$name:"User"); ?>,</div>
  <div style="padding:5px">
  Delayed appointments on <?=date('dS M Y \a\t h:i a')?>.
  </div>
  <div style="padding:5px">
  <table cellspacing="0" cellpadding="3" style="margin-top:5px;margin-bottom:5px;border:none;width:540px;color:#333;font-size:10pt;line-height:1.5">
      <tbody>
          <tr>
              <td style="width:350px;font-weight:bold;border-top:1px solid #ebebeb;border-bottom:1px solid #ebebeb">Patient Name</td>
              <td style="width:350px;font-weight:bold;border-top:1px solid #ebebeb;border-bottom:1px solid #ebebeb">Doctor Name</td>
              <td style="width:170px;font-weight:bold;border-top:1px solid #ebebeb;border-bottom:1px solid #ebebeb">Status</td>
              <td style="width:170px;font-weight:bold;border-top:1px solid #ebebeb;border-bottom:1px solid #ebebeb">Notes</td>
              <td style="width:170px;font-weight:bold;border-top:1px solid #ebebeb;border-bottom:1px solid #ebebeb">Delay (mins.)</td>
          </tr>
      		<?php foreach($patient_name as $key=>$val){ ?>
          <tr>
              <td style="width:350px;font-weight:bold;border-top:1px solid #ebebeb;border-bottom:1px solid #ebebeb"><?=$val?></td>
              <td style="width:350px;font-weight:bold;border-top:1px solid #ebebeb;border-bottom:1px solid #ebebeb">Dr. <?=$doctor[$key]?></td>
              <td style="width:350px;font-weight:bold;border-top:1px solid #ebebeb;border-bottom:1px solid #ebebeb"><?=$status[$key]?></td>
              <td style="width:350px;font-weight:bold;border-top:1px solid #ebebeb;border-bottom:1px solid #ebebeb"><?=$notes[$key]?></td>
              <td style="width:170px;font-weight:bold;border-top:1px solid #ebebeb;border-bottom:1px solid #ebebeb"><?=$time_minutes[$key]?></td>
          </tr>
          <?php }?>
      </tbody>
  </table>
  </div>
<?php $this->load->view('mailers/common/practo_footer.php'); ?>