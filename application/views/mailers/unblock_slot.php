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
<td align="left" valign="top" style="font-family: Arial, Helvetica, sans-serif;font-size: 1.2em;color:#83878a;">You have unblocked your Appointments  
<?=(isset($from_date) && isset($to_date))? "from {$from_date} to {$to_date}":""?></td>
</tr>
<?php $this->load->view('mailers/common/regards'); ?>    
</table></td>
</tr>
<?php $this->load->view('mailers/common/footer'); ?>    
</table>