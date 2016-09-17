<!doctype html>
<html>
<head>
	<?php $this->load->view('common/head'); ?>
  <link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>bda.css">
  <style type="text/css">
  .loginBox{margin-left:35%;padding-top:30px;}
  </style>
</head>

<body>
<div id="header">
	<?php $this->load->view('common/header');?>
</div>

<div id="content"><!--content Start-->
<div class="loginBox">
  <div class="loginBoxTitle">
    <h2>Welcome!</h2>
    <p>Enter your details</p>
    <p><?php echo validation_errors('<p style="color:red;">','</p>'); ?></p>
  </div>
  <div class="loginForm" >
    <form method="post">
      <input type="password" placeholder="New Password" name="pass" id="pass" class="loginFinput">
      <input type="password" placeholder="Confirm New Password" name="cnfmpass" id="cnfmpass" class="loginFinput">
      <input type="submit" id="submit" name="submit" value="Set Password" class="loginFsubmit">
    </form>
  </div>
</div>
</div><!--content End-->
<div id="footer">
	<?php $this->load->view('common/footer'); ?>
</div>  <?php $this->load->view('common/bottom'); ?>
</body>
</html>
