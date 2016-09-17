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
  <td align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;">Hello and Welcome to BookDrAppointment.com!</td>
</tr>
<tr>
  <td align="left" valign="top">&nbsp;</td>
</tr>
<tr >
  <td colspan="10" align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;">Your account has been created using username:<span style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#05325b;"><?php echo (isset($to_email)?$to_email:"user@user.com"); ?></span></td>
</tr>
<tr>
  <td align="left" valign="top">&nbsp;</td>
</tr>
<tr>
  <td align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;">Now, it will be easier than ever to find Doctors and book Appointments instantly. You can also reschedule or Cancel Appointments you've already booked. </td>
</tr>
<tr>
  <td align="left" valign="top">&nbsp;</td>
</tr>
<tr>
  <td align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;">Here are 4 ways for you to get the most of it!</td>
</tr>
<tr>
  <td align="left" valign="top">&nbsp;</td>
</tr>
<tr><td style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;">1.	Find a Trusted Doctor nearby</td></tr>
<tr><td style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;">2.	Select Doctor based on Happy Patient Reviews</td></tr>
<tr><td style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;">3.	Book Doctor Appointment instantly, online</td></tr>
<tr>
  <td align="left" valign="top">&nbsp;</td>
</tr>
<tr>
  <td align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;">It's definitely so simple!</td>
</tr>
<?php $this->load->view('mailers/common/regards'); ?>    
</table></td>
</tr>
<?php $this->load->view('mailers/common/footer'); ?>    
</table>