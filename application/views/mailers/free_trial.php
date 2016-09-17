<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0"><!--640-->
<?php $this->load->view('mailers/common/header'); ?>    
<tr>
<td align="left" valign="top" style="padding:0 30px;"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td align="left" valign="top">&nbsp;</td>
</tr>
<tr>
<td align="left" valign="top" style="font-size:1.2em; color:#05325b;">Dear <?php echo (isset($to_name)?$to_name:"User"); ?>,</td>
</tr>

<tr>
<td align="left" valign="top">&nbsp;</td>
</tr>
<tr>
<td align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;">We are pleased to offer you 15 Days of Free Trial of BookDrAppointment which is live from now<?php echo (isset($end_date)?" and will be active till ". '<span style="color:#05325b;">'.$end_date.'</span>' :""); ?> .</td>
</tr>
<tr>
<td align="left" valign="top">&nbsp;</td>
</tr>
<tr >
<td colspan="10" align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;">You can just login to your account and get started.  During your Trial period, you can explore the following:</td>
</tr>
<tr>
<td align="left" valign="top">&nbsp;</td>
</tr>
<tr>
<td colspan="10" align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;"><strong>&middot;</strong> Impressive Professional Showcase</span></td>
</tr>
<tr>
<td colspan="10" align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;"><strong>&middot;</strong> Appointment Scheduler with Appointment slots Display </span></td>
</tr>
<tr>
<td colspan="10" align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;"><strong>&middot;</strong> Clinic Showcase with Impressive Clinic Photographs</span></td>
</tr>
<tr>
<td colspan="10" align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;"><strong>&middot;</strong> Patient Database Management</span></td>
</tr>
<tr>
<td colspan="10" align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;"><strong>&middot;</strong> Ease of access through Android Mobile App</span></td>
</tr>
<tr>
<td align="left" valign="top">&nbsp;</td>
</tr>
<tr>
<td colspan="10" align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;">We keep your data confidential & secure. You can get in touch with our well-trained support staff for any of your queries.</span></td>
</tr>        
<tr>
<td align="left" valign="top">&nbsp;</td>
</tr>
<tr>
<td colspan="10" align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;">We’re sure that BookDrAppointment will help manage your Practice in the smartest possible way!</span></td>
</tr>        
<?php $this->load->view('mailers/common/regards'); ?>
</table></td>
</tr>
<?php $this->load->view('mailers/common/footer'); ?>    
</table>