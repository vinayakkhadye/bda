<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0"><!--640-->
<?php $this->load->view('mailers/common/header'); ?>    
<tr>
<td align="left" valign="top" style="padding:0 30px;">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td align="left" valign="top">&nbsp;</td>
</tr>
<tr>
<td align="left" valign="top" style="font-size:1.2em; color:#05325b;">Dear <?php echo (isset($name)?$name:"User"); ?>,</td>
</tr>
<tr>
<td align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;">
How was your Appointment with Dr. <?php echo (isset($doctor_name)?$doctor_name:"User"); ?>? Please click on the options below for your feedback:
</td>
</tr>
<tr>
<td align="left" valign="top">&nbsp;</td>
</tr>
<tr>
<td align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;">
<a href="<?=BASE_URL?>feedback/apponintment_update?d=<?=$doctor_id?>&n=<?=$name?>&e=<?=$email?>&r=1">Very Happy</a>
</td>
</tr>
<tr>
<td align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;">
<a href="<?=BASE_URL?>feedback/apponintment_update?d=<?=$doctor_id?>&n=<?=$name?>&e=<?=$email?>&r=2">Happy</a>
</td>
</tr>
<tr>
<td align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;">
<a href="<?=BASE_URL?>feedback/apponintment_update?d=<?=$doctor_id?>&n=<?=$name?>&e=<?=$email?>&r=3">Not Happy</a></td>
</tr>
<tr>
<td align="left" valign="top">&nbsp;</td>
</tr>
<tr>
<td align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;">Ignore if you already done</td>
</tr>
<?php $this->load->view('mailers/common/regards'); ?>            
</table>
</td>
</tr>
<?php $this->load->view('mailers/common/footer'); ?>    
</table>