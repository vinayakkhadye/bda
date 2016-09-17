<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
  	<title>Add Users  | BDA</title>
		<?php $this->load->view('admin/common/head'); ?>
	</head>
	<body>
		<?php $this->load->view('admin/common/header'); ?>
    <div class="container-fluid">
    <div class="panel panel-default">
    <div class="panel-heading">Add User Details </div>
    <div class="panel-body">
				<form method="POST" data-toggle="validator">
       		<div class="col-md-4 col-md-offset-4">
					<div class="form-group">
            <label class="control-label">Username :</label>
            <input type="text" name="username" value="" class="form-control" required>
          </div>
					<div class="form-group">
            <label class="control-label">Password :</label>
            <input type="text" name="password" value="" class="form-control" required>
          </div>
					<div class="form-group">
            <label class="control-label">Name :</label>
            <input type="text" name="name" value="" class="form-control" required/>
          </div>
					<div class="form-group">
            <label class="control-label">Email :</label>
            <input type="email" name="email" value="" class="form-control" required/>
          </div>
					<div class="form-group">
            <label class="control-label">Mobile :</label>
            <input type="text" name="mob" value="" maxlength="10" class="form-control" required/>
          </div>
					<div class="form-group">
            <label class="control-label">Status :</label>
						<select name="status" class="form-control" required>
							<option value="1">Enabled</option>
							<option value="0">Disabled</option>
						</select>
          </div>
					<div class="form-group">
						<input type="submit" name="submit" value="Add User" id="submit-btn" class="btn btn-primary" />
          </div>
          </div>
				</form>
		</div>
    <div class="panel-footer">
    <?php $this->load->view('admin/common/footer'); ?>
    </div>
    </div>
    </div>
		<?php $this->load->view('admin/common/bottom'); ?>
	</body>
</html>
