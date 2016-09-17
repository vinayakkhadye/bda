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
<td align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;">We are glad to inform you that your BDA account has been verified and your Profile enjoys a smart & complimentary listing on our Domain which comprises of leading Doctors of the Country. We would surely like you to stand out from the pool of Doctors, hence we suggest that you Update your Profile and make your listing more informative & noticeable!</td>
</tr>
<tr>
<td align="left" valign="top">&nbsp;</td>
</tr>
<tr >
<td colspan="10" align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;">Patients can now select you based on your complete impressive profile with Verified & Happy Patient Reviews. We highly recommend that you update your Profile to maximize your visibility and credibility with the patients. </td>
</tr>
<tr>
<td align="left" valign="top">&nbsp;</td>
</tr>
<tr>
<td colspan="10" align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;">You can now make the most of it with the following:</span></td>
</tr>
<tr>
<td align="left" valign="top">&nbsp;</td>
</tr>
<tr>
<td align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;">
<strong>&middot;</strong> Impressive Profile Photograph
</td>
</tr>
<tr>
<td align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;"><strong>&middot;</strong> Professional Showcase (Services, Specialization, Education, Experience, Awards & Recognitions, Memberships, Registrations & Papers Published)</td>
</tr>
<tr>
<td align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;"><strong>&middot;</strong> Display of your Appointment Slots</td>
</tr>
<tr>
<td align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;"><strong>&middot;</strong> Clinic Showcase with impressive Clinic Photographs</td>
</tr>
<tr>
<td align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;"><strong>&middot;</strong> Verified & Happy Patient Reviews</td>
</tr>
<tr>
<td align="left" valign="top">&nbsp;</td>
</tr>
<tr>
<td colspan="10" align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;">
To get started, login with your username: <span style="font-size:1.2em; color:#05325b;"><?php echo (isset($to_email)?$to_email:"user@gmail.com"); ?></span></td>
</tr>
<?php $this->load->view('mailers/common/regards'); ?>    
</table></td>
</tr>
<?php $this->load->view('mailers/common/footer'); ?>      
</table>
