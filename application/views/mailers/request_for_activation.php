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
		<td align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;">Thank you for Signing up with BookDrAppointment.com! </td>
	</tr>
	<tr>
		<td align="left" valign="top">&nbsp;</td>
	</tr>
	<tr >
		<td colspan="10" align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;">Your BDA Account will be activated once our team verifies you as a Practitioner.</td>
	</tr>
	<tr>
		<td align="left" valign="top">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="10" align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;">On verification of your account, your Impressive Profile Photograph, Professional Showcase and Appointment Schedule will be displayed for Patients to view and book your appointment online.</span></td>
	</tr>
	<tr>
		<td align="left" valign="top">&nbsp;</td>
	</tr>
	<tr>
		<td align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;">You will hear from us soon regarding your account activation. </td>
	</tr>
	<?php $this->load->view('mailers/common/regards'); ?>    
</table></td>
</tr>
<?php $this->load->view('mailers/common/footer'); ?>    
</table>