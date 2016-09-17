<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0"><!--640-->
<?php $this->load->view('mailers/common/header'); ?>    
<tr>
<td align="left" valign="top" style="padding:0 30px;"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td align="left" valign="top">&nbsp;</td>
</tr>
<tr>
<td align="left" valign="top" style="font-size:1.2em; color:#05325b;">Hi <?php echo (isset($to_name)?$to_name:"User"); ?>,</td>
</tr>

<tr>
<td align="left" valign="top">&nbsp;</td>
</tr>
<tr>
<td align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;">Somebody recently asked to reset your BDA account password.</td>
</tr>
<tr>
<td align="left" valign="top">&nbsp;</td>
</tr>
<tr >
<td colspan="10" align="left" valign="top" ><a style=" font-size:1.2em;font-family: Arial, Helvetica, sans-serif;color:#05325b; text-decoration:none;" href="<?php echo (isset($resetcode)?$resetcode:"#"); ?>">Click here to reset your password</a></td>
</tr>
<tr>
<td align="left" valign="top">&nbsp;</td>
</tr>
<tr>
<td align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;">If you did not request a new password, please let us know immediately  @ <a style="color:#05325b; text-decoration:none;;font-size:1em;" href="mailto:support@bookdrappointment.com">support@bookdrappointment.com</a></td>
</tr>
<tr>
<td align="left" valign="top">&nbsp;</td>
</tr>
<tr>
<td align="left" valign="top">&nbsp;</td>
</tr>
<tr>
<td align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;">See you soon on BookDrAppointment!</td>
</tr>
<?php $this->load->view('mailers/common/regards'); ?>            
</table></td>
</tr>
<?php $this->load->view('mailers/common/footer'); ?>    
</table>