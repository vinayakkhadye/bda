<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('mail_model');
	}

	function index()
	{
		$subject = 'Test sub';
//		$to_email = 'naved.developer@outlook.com';
//		$to_email = 'vinayak@bookdrappointment.com';
//		$to_email = 'sachin@bookdrappointment.com';
		$to_email = 'mktg@bookdrappointment.com';
		$to_name = 'Naved';
		$message = '<html>
<head>
<title>Welcome</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
#Table_01 tr td {
	font-family: Calibri;
	color: #FFFFFF;
	font-size: 24px;
}
.doctor_name {
	font-family: Calibri;
	font-size: 17px;
	font-weight: bolder;
	color: #FFF;
	text-decoration: none;
}
.doctor_name2 {
	font-family: Calibri;
	font-size: 24px;
	font-weight: bolder;
	color: #FFF;
	text-decoration: none;
}
.text_1 {
	font-family: Calibri;
	font-size: 14px;
	font-weight: normal;
	color: #FFF;
	text-decoration: none;
	line-height: 17px;
}
.text_2 {
	font-family: Calibri;
	font-size: 14px;
	color: #E84C3D;
	text-decoration: underline;
}
.text_3 {
	font-family: Calibri;
	font-size: 14px;
	color: #2D3E50;
	text-decoration: none;
	line-height: 21px;
	font-weight: normal;
}
.text_4 {
	font-family: Calibri;
	font-size: 15px;
	color: #E84C3D;
	text-decoration: none;
	line-height: 21px;
	font-weight: normal;
}
.text_55 {
	font-family: Calibri;
	font-size: 16px;
	color: #E84C3D;
	text-decoration: none;
	line-height: 21px;
	font-weight: bold;
}
.text_5 {
	font-family: Calibri;
	font-size: 15px;
	color: #2D3E50;
	text-decoration: none;
	line-height: 21px;
	font-weight: normal;
}
</style>
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<!-- Save for Web Slices (Welcome.psd) -->
<table width="690" height="891" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="23">
			<img src="'.EMAIL_IMAGE_URL.'Welcome_01.png" width="689" height="133" alt=""  style="display:block"></td>
		<td>
			<img src="'.EMAIL_IMAGE_URL.'spacer.gif" width="1" height="133" alt=""  style="display:block"></td>
	</tr>
	<tr>
		<td colspan="5" rowspan="2">
			<img src="'.EMAIL_IMAGE_URL.'Welcome_02.png" width="171" height="49" alt="" style="display:block"></td>
		<td colspan="5" align="center" bgcolor="#2D3E50" class="doctor_name2">Welcome </td>
		<td colspan="13" rowspan="2">
			<img src="'.EMAIL_IMAGE_URL.'Welcome_04.png" width="225" height="49" alt=""  style="display:block"></td>
		<td>
			<img src="'.EMAIL_IMAGE_URL.'spacer.gif" width="1" height="48" alt=""  style="display:block"></td>
	</tr>
	<tr>
		<td colspan="5">
			<img src="'.EMAIL_IMAGE_URL.'Welcome_05.png" width="293" height="1" alt=""  style="display:block"></td>
		<td>
			<img src="'.EMAIL_IMAGE_URL.'spacer.gif" width="1" height="1" alt=""  style="display:block"></td>
	</tr> 
	<tr>
		<td colspan="2" rowspan="5">
			<img src="'.EMAIL_IMAGE_URL.'Welcome_06.png" width="31" height="256" alt=""  style="display:block"></td>
		<td colspan="9" valign="top" bgcolor="#2D3E50"><h3 class="doctor_name">Hi Sachin,<br>
	      <span class="text_55">Hello and Welcome to BookDrAppointment.com!</span><br>
	      <span class="text_1">Your account has been created using username &ndash; </span><span class="text_2">sachindrl@gmail.com</span></h3>
<p class="text_1">Now, it will be easier than ever to find Doctors and book appointments instantly. You can also manage all your Personal Health Records online and access from anywhere.<br>
  <br>
  You can also reschedule or cancel appointments you&rsquo;ve already booked.
It&rsquo;s definitely so Simple! </p></td>
		<td colspan="12" rowspan="2">
			<img src="'.EMAIL_IMAGE_URL.'Welcome_08.png" alt="" width="221" height="214" border="0"  style="display:block"></td>
		<td>
			<img src="'.EMAIL_IMAGE_URL.'spacer.gif" width="1" height="204" alt=""  style="display:block"></td>
	</tr>
	<tr>
		<td colspan="9">
			<img src="'.EMAIL_IMAGE_URL.'Welcome_09.png" width="437" height="10" alt=""  style="display:block"></td>
		<td>
			<img src="'.EMAIL_IMAGE_URL.'spacer.gif" width="1" height="10" alt=""  style="display:block"></td>
	</tr>
	<tr>
		<td rowspan="3">
			<img src="'.EMAIL_IMAGE_URL.'Welcome_10.png" width="57" height="42" alt=""  style="display:block"></td>
		<td colspan="16" bgcolor="#E84C3D">&nbsp;</td>
		<td colspan="4" rowspan="3">
			<img src="'.EMAIL_IMAGE_URL.'Welcome_12.png" width="107" height="42" alt=""  style="display:block"></td>
		<td>
			<img src="'.EMAIL_IMAGE_URL.'spacer.gif" width="1" height="30" alt=""  style="display:block"></td>
	</tr>
	<tr>
		<td colspan="16">
			<img src="'.EMAIL_IMAGE_URL.'Welcome_13.png" width="494" height="11" alt=""  style="display:block"></td>
		<td>
			<img src="'.EMAIL_IMAGE_URL.'spacer.gif" width="1" height="11" alt=""  style="display:block"></td>
	</tr>
	<tr>
		<td colspan="2">
			<img src="'.EMAIL_IMAGE_URL.'Welcome_14.png" width="83" height="1" alt=""  style="display:block"></td>
		<td colspan="2" rowspan="2">
			<img src="'.EMAIL_IMAGE_URL.'Welcome_15.png" width="175" height="306" alt="" style="display:block"></td>
		<td colspan="7">
			<img src="'.EMAIL_IMAGE_URL.'Welcome_16.png" width="166" height="1" alt=""  style="display:block"></td>
		<td colspan="5">
			<img src="'.EMAIL_IMAGE_URL.'Welcome_17.png" width="70" height="1" alt=""  style="display:block"></td>
		<td>
			<img src="'.EMAIL_IMAGE_URL.'spacer.gif" width="1" height="1" alt=""  style="display:block"></td>
	</tr>
	<tr>
		<td rowspan="8">
			<img src="'.EMAIL_IMAGE_URL.'Welcome_18.png" width="9" height="452" alt=""  style="display:block"></td>
		<td colspan="4">
			<img src="'.EMAIL_IMAGE_URL.'Welcome_19.png" width="162" height="305" alt=""  style="display:block"></td>
		<td colspan="6">
			<img src="'.EMAIL_IMAGE_URL.'Welcome_20.png" width="165" height="305" alt="" style="display:block"></td>
		<td colspan="9">
			<img src="'.EMAIL_IMAGE_URL.'Welcome_21.png" width="169" height="305" alt=""  style="display:block"></td>
		<td rowspan="8">
			<img src="'.EMAIL_IMAGE_URL.'Welcome_22.png" width="9" height="452" alt=""  style="display:block"></td>
		<td>
			<img src="'.EMAIL_IMAGE_URL.'spacer.gif" width="1" height="305" alt=""  style="display:block"></td>
	</tr>
	<tr>
		<td colspan="21">
			<img src="'.EMAIL_IMAGE_URL.'Welcome_23.png" width="671" height="12" alt=""  style="display:block"></td>
		<td>
			<img src="'.EMAIL_IMAGE_URL.'spacer.gif" width="1" height="12" alt=""  style="display:block"></td>
	</tr>
	<tr>
		<td colspan="8" rowspan="2">
			<img src="'.EMAIL_IMAGE_URL.'Welcome_24.png" width="419" height="84" alt=""  style="display:block"></td>
		<td colspan="2">
			<img src="'.EMAIL_IMAGE_URL.'Welcome_25.png" alt="" width="40" height="24" border="0"  style="display:block"></td>
		<td rowspan="3">
			<img src="'.EMAIL_IMAGE_URL.'Welcome_26.png" width="21" height="85" alt=""  style="display:block"></td>
		<td colspan="3">
			<img src="'.EMAIL_IMAGE_URL.'Welcome_27.png" alt="" width="33" height="24" border="0"  style="display:block"></td>
		<td rowspan="3">
			<img src="'.EMAIL_IMAGE_URL.'Welcome_28.png" width="30" height="85" alt=""  style="display:block"></td>
		<td colspan="2">
			<img src="'.EMAIL_IMAGE_URL.'Welcome_29.png" alt="" width="28" height="24" border="0"  style="display:block"></td>
		<td colspan="2" rowspan="6">
			<img src="'.EMAIL_IMAGE_URL.'Welcome_30.png" width="28" height="135" alt=""  style="display:block"></td>
		<td>
			<img src="'.EMAIL_IMAGE_URL.'Welcome_31.png" alt="" width="43" height="24" border="0"  style="display:block"></td>
		<td rowspan="6">
			<img src="'.EMAIL_IMAGE_URL.'Welcome_32.png" width="29" height="135" alt=""  style="display:block"></td>
		<td>
			<img src="'.EMAIL_IMAGE_URL.'spacer.gif" width="1" height="24" alt=""  style="display:block"></td>
	</tr>
	<tr>
		<td colspan="2" rowspan="2">
			<img src="'.EMAIL_IMAGE_URL.'Welcome_33.png" width="40" height="61" alt=""  style="display:block"></td>
		<td colspan="3" rowspan="2">
			<img src="'.EMAIL_IMAGE_URL.'Welcome_34.png" width="33" height="61" alt=""  style="display:block"></td>
		<td colspan="2" rowspan="2">
			<img src="'.EMAIL_IMAGE_URL.'Welcome_35.png" width="28" height="61" alt=""  style="display:block"></td>
		<td rowspan="5">
			<img src="'.EMAIL_IMAGE_URL.'Welcome_36.png" width="43" height="111" alt=""  style="display:block"></td>
		<td>
			<img src="'.EMAIL_IMAGE_URL.'spacer.gif" width="1" height="60" alt=""  style="display:block"></td>
	</tr>
	<tr>
		<td colspan="3" rowspan="4">
			<img src="'.EMAIL_IMAGE_URL.'Welcome_37.png" width="127" height="51" alt=""  style="display:block"></td>
		<td colspan="2" rowspan="3">
			<img src="'.EMAIL_IMAGE_URL.'Welcome_38.png" alt="" width="183" height="22" border="0"  style="display:block"></td>
		<td colspan="3">
			<img src="'.EMAIL_IMAGE_URL.'Welcome_39.png" width="109" height="1" alt=""  style="display:block"></td>
		<td>
			<img src="'.EMAIL_IMAGE_URL.'spacer.gif" width="1" height="1" alt=""  style="display:block"></td>
	</tr>
	<tr>
		<td colspan="2" rowspan="3">
			<img src="'.EMAIL_IMAGE_URL.'Welcome_40.png" width="43" height="50" alt=""  style="display:block"></td>
		<td colspan="9">
			<img src="'.EMAIL_IMAGE_URL.'Welcome_41.png" alt="" width="209" height="17" border="0"  style="display:block"></td>
		<td rowspan="3">
			<img src="'.EMAIL_IMAGE_URL.'Welcome_42.png" width="9" height="50" alt=""  style="display:block"></td>
		<td>
			<img src="'.EMAIL_IMAGE_URL.'spacer.gif" width="1" height="17" alt=""  style="display:block"></td>
	</tr>
	<tr>
		<td colspan="9" rowspan="2">
			<img src="'.EMAIL_IMAGE_URL.'Welcome_43.png" width="209" height="33" alt=""  style="display:block"></td>
		<td>
			<img src="'.EMAIL_IMAGE_URL.'spacer.gif" width="1" height="4" alt=""  style="display:block"></td>
	</tr>
	<tr>
		<td colspan="2">
			<img src="'.EMAIL_IMAGE_URL.'Welcome_44.png" width="183" height="29" alt=""  style="display:block"></td>
		<td>
			<img src="'.EMAIL_IMAGE_URL.'spacer.gif" width="1" height="29" alt=""  style="display:block"></td>
	</tr>
	<tr>
		<td>
			<img src="'.EMAIL_IMAGE_URL.'spacer.gif" width="9" height="1" alt=""  style="display:block"></td>
		<td>
			<img src="'.EMAIL_IMAGE_URL.'spacer.gif" width="22" height="1" alt=""  style="display:block"></td>
		<td>
			<img src="'.EMAIL_IMAGE_URL.'spacer.gif" width="57" height="1" alt=""  style="display:block"></td>
		<td> 
			<img src="'.EMAIL_IMAGE_URL.'spacer.gif" width="48" height="1" alt=""  style="display:block"></td>
		<td>
			<img src="'.EMAIL_IMAGE_URL.'spacer.gif" width="35" height="1" alt=""  style="display:block"></td>
		<td>
			<img src="'.EMAIL_IMAGE_URL.'spacer.gif" width="148" height="1" alt=""  style="display:block"></td>
		<td>
			<img src="'.EMAIL_IMAGE_URL.'spacer.gif" width="27" height="1" alt=""  style="display:block"></td>
		<td>
			<img src="'.EMAIL_IMAGE_URL.'spacer.gif" width="16" height="1" alt=""  style="display:block"></td>
		<td>
			<img src="'.EMAIL_IMAGE_URL.'spacer.gif" width="66" height="1" alt="" style="display:block" ></td>
		<td>
			<img src="'.EMAIL_IMAGE_URL.'spacer.gif" width="36" height="1" alt="" style="display:block"></td>
		<td>
			<img src="'.EMAIL_IMAGE_URL.'spacer.gif" width="4" height="1" alt="" style="display:block"></td>
		<td>
			<img src="'.EMAIL_IMAGE_URL.'spacer.gif" width="21" height="1" alt="" style="display:block"></td>
		<td>
			<img src="'.EMAIL_IMAGE_URL.'spacer.gif" width="22" height="1" alt="" style="display:block"></td>
		<td>
			<img src="'.EMAIL_IMAGE_URL.'spacer.gif" width="1" height="1" alt="" style="display:block"></td>
		<td>
			<img src="'.EMAIL_IMAGE_URL.'spacer.gif" width="10" height="1" alt="" style="display:block"></td>
		<td>
			<img src="'.EMAIL_IMAGE_URL.'spacer.gif" width="30" height="1" alt="" style="display:block"></td>
		<td>
			<img src="'.EMAIL_IMAGE_URL.'spacer.gif" width="19" height="1" alt="" style="display:block"></td>
		<td>
			<img src="'.EMAIL_IMAGE_URL.'spacer.gif" width="9" height="1" alt="" style="display:block"></td>
		<td>
			<img src="'.EMAIL_IMAGE_URL.'spacer.gif" width="2" height="1" alt="" style="display:block"></td>
		<td>
			<img src="'.EMAIL_IMAGE_URL.'spacer.gif" width="26" height="1" alt="" style="display:block"></td>
		<td>
			<img src="'.EMAIL_IMAGE_URL.'spacer.gif" width="43" height="1" alt="" style="display:block"></td>
		<td>
			<img src="'.EMAIL_IMAGE_URL.'spacer.gif" width="29" height="1" alt="" style="display:block"></td>
		<td>
			<img src="'.EMAIL_IMAGE_URL.'spacer.gif" width="9" height="1" alt="" style="display:block"></td>
		<td></td>
	</tr>
</table>
<!-- End Save for Web Slices -->
</body>
</html>';
		$this->mail_model->sendmail($to_email, $to_name, $subject, $message);
	}

	function mailtest()
	{
		$subject = 'Test sub';
		$to_email = 'naved.developer@outlook.com';
		$to_name = 'Naved';
		$this->mail_model->mailtest($subject, $to_email, $to_name);
	}
	
	function getenv()
	{
		/*Array
		(
			[HOSTNAME] => BDA
			[SHELL] => /bin/bash
			[TERM] => xterm
			[HISTSIZE] => 1000
			[SSH_CLIENT] => 120.61.115.160 16975 22
			[SSH_TTY] => /dev/pts/0
			[USER] => U09haMfGa
			[LS_COLORS] => no=00:fi=00:di=00;34:ln=00;36:pi=40;33:so=00;35:bd=40;33;01:cd=40;33;01:or=01;05;37;41:mi=01;05;37;41:ex=00;32:*.cmd=00;32:*.exe=00;32:*.com=00;32:*.btm=00;32:*.bat=00;32:*.sh=00;32:*.csh=00;32:*.tar=00;31:*.tgz=00;31:*.arj=00;31:*.taz=00;31:*.lzh=00;31:*.zip=00;31:*.z=00;31:*.Z=00;31:*.gz=00;31:*.bz2=00;31:*.bz=00;31:*.tz=00;31:*.rpm=00;31:*.cpio=00;31:*.jpg=00;35:*.gif=00;35:*.bmp=00;35:*.xbm=00;35:*.xpm=00;35:*.png=00;35:*.tif=00;35:
			[PATH] => /sbin:/usr/sbin:/bin:/usr/bin
			[MAIL] => /var/spool/mail/U09haMfGa
			[PWD] => /etc
			[INPUTRC] => /etc/inputrc
			[LANG] => C
			[HOME] => /root
			[SHLVL] => 4
			[LOGNAME] => U09haMfGa
			[CVS_RSH] => ssh
			[SSH_CONNECTION] => 120.61.115.160 16975 10.10.16.66 22
			[LESSOPEN] => |/usr/bin/lesspipe.sh %s
			[G_BROKEN_FILENAMES] => 1
			[_] => /usr/sbin/httpd
		)*/
		$_ENV['HOSTNAME'] = 'BDA';
		$_ENV['SHELL'] = '/bin/bash';
		$_ENV['TERM'] = 'xterm';
		$_ENV['HISTSIZE'] = '1000';
		$_ENV['SSH_CLIENT'] = '120.61.115.160 16975 22';
		$_ENV['SSH_TTY'] = '/dev/pts/0';
		$_ENV['USER'] = 'U09haMfGa';
		$_ENV['LS_COLORS'] = 'no=00:fi=00:di=00;34:ln=00;36:pi=40;33:so=00;35:bd=40;33;01:cd=40;33;01:or=01;05;37;41:mi=01;05;37;41:ex=00;32:*.cmd=00;32:*.exe=00;32:*.com=00;32:*.btm=00;32:*.bat=00;32:*.sh=00;32:*.csh=00;32:*.tar=00;31:*.tgz=00;31:*.arj=00;31:*.taz=00;31:*.lzh=00;31:*.zip=00;31:*.z=00;31:*.Z=00;31:*.gz=00;31:*.bz2=00;31:*.bz=00;31:*.tz=00;31:*.rpm=00;31:*.cpio=00;31:*.jpg=00;35:*.gif=00;35:*.bmp=00;35:*.xbm=00;35:*.xpm=00;35:*.png=00;35:*.tif=00;35:';
		$_ENV['PATH'] = '/sbin:/usr/sbin:/bin:/usr/bin';
		$_ENV['MAIL'] = '/var/spool/mail/U09haMfGa';
		$_ENV['PWD'] = '/etc';
		$_ENV['INPUTRC'] = '/etc/inputrc';
		$_ENV['LANG'] = 'C';
		$_ENV['HOME'] = '/root';
		$_ENV['SHLVL'] = '4';
		$_ENV['LOGNAME'] = 'U09haMfGa';
		$_ENV['CVS_RSH'] = 'ssh';
		$_ENV['SSH_CONNECTION'] = '120.61.115.160 16975 10.10.16.66 22';
		$_ENV['LESSOPEN'] = '|/usr/bin/lesspipe.sh %s';
		$_ENV['G_BROKEN_FILENAMES'] = '1';
		$_ENV['_'] = '/usr/sbin/httpd';
		print_r($_ENV);
	}

}