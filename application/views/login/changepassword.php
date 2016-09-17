<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php $this->load->view('login/common/head'); ?>
</head>

<body>
<?php $this->load->view('login/common/doctor_header'); ?>
<div class="container H550">
<div class="row">            
<div class="col-lg-6 col-md-6 col-sm-10 col-xs-10 col-lg-offset-3 col-md-offset-3 col-sm-offset-1 col-xs-offset-1">
<!---->
<div class="panel panel-default">
  <div class="panel-heading">Change Password</div>    
<div class="panel-body">
<form role="form" data-toggle="validator" method="post" class="form-horizontal">
  <div class="form-group">
  	<div class="col-sm-4">
    <label class="control-label">Current Password<?php echo form_error('oldpass', '<p class="error_text">', '</p>'); ?></label>
    </div>
    <div class="col-sm-8">
    <input name="oldpass" type="password" class="form-control" required="required"/>
    </div>
  </div>
  <div class="form-group">
	  <div class="col-sm-4">
    <label class="control-label">New Password<?php echo form_error('newpass', '<p class="error_text">', '</p>'); ?></label>
    </div>
    <div class="col-sm-8">
    <input name="newpass" type="password" class="form-control" required="required"/>
    </div>
    </div>
  <div class="form-group">
  	<div class="col-sm-4">
    <label class="control-label">Confirm Password<?php echo form_error('cnfmnewpass', '<p class="error_text">', '</p>'); ?></label>
    </div>
    <div class="col-sm-8">
    <input name="cnfmnewpass" type="password" class="form-control" required="required"/>
    </div>
  </div>
  <div class="form-group">
	  <div class="col-sm-offset-4 col-sm-8">
    <input type="submit" class="btn btn-success" name="submit" value="Change" />
    </div>
  </div>
  </form>
</div>
</div>
</div>
</div>
</div>    
<?php $this->load->view('login/common/footer'); ?>
<?php $this->load->view('login/common/bottom'); ?>
</body>
</html>
