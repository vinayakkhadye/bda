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
<td align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;">You had recently signed up for an account with BookDrAppointment. Unfortunately we were unable to validate your credentials & identify you as a Practitioner.</td>
</tr>
<tr>
<td align="left" valign="top">&nbsp;</td>
</tr>
<tr >
<td colspan="10" align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;">Kindly get in touch with us to help validate your credentials and activate your account.</td>
</tr>
<tr>
<td align="left" valign="top">&nbsp;</td>
</tr>
<tr>
<td colspan="10" align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;">We appreciate your interest in BDA and look forward to getting in touch with you soon.</span></td>
</tr>
<?php $this->load->view('mailers/common/regards'); ?>    
</table></td>
</tr>
<?php $this->load->view('mailers/common/footer'); ?>      
</table>