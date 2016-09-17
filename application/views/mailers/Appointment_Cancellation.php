<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0"><!--640-->
<?php $this->load->view('mailers/common/header'); ?>    
<tr>
<td align="left" valign="top" style="padding:0 30px;"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td align="left" valign="top">&nbsp;</td>
</tr>
<tr>
<td align="left" valign="top" style="font-size:1.2em; color:#05325b;">Hi <?php echo (isset($name)?$name:"User"); ?>,</td>
</tr>
<tr>
<td align="left" valign="top">&nbsp;</td>
</tr>
<tr>
<td align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;">
Your appointment with Dr. <?=isset($dr_name)?$dr_name:''?> on <?=isset($appointment_time)?$appointment_time:'' ?> has been cancelled. </td>
</tr>
<tr>
<td align="left" valign="top">&nbsp;</td>
</tr>
<tr >
<td colspan="10" align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#05325b;">Details of Appointment:</td>
</tr>
<tr>
<td align="left" valign="top">&nbsp;</td>
</tr>
<tr>
<td align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;"><?=isset($dr_name)?$dr_name:'Doctor name'?></td>
</tr>
<tr>
<td align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;">
<?=isset($clinic_address)?$clinic_address:' clinic address' ?>
</td>
</tr>
<tr>
<td align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;">Contact: <?=isset($clinic_number)?$clinic_number:''?></td>
</tr>
<tr>
<td align="left" valign="top">&nbsp;</td>
</tr>
<tr>
<td colspan="10" align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#05325b;">Patient Details:</td>
</tr>
<tr>
<td align="left" valign="top">&nbsp;</td>
</tr>
<tr>
<td align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;">Name: <?=isset($name)?$name:''?></td>
</tr>
<tr>
<td align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;">Reason for Visit: <?=isset($reason_for_visit)?$reason_for_visit:''?></td>
</tr>
<?php $this->load->view('mailers/common/regards'); ?>            
</table></td>
</tr>
<?php $this->load->view('mailers/common/footer'); ?>    
</table>