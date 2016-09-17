<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
  	<title>Edit User | BDA</title>
		<?php $this->load->view('admin/common/head'); ?>
	</head>
	<body>
		<?php $this->load->view('admin/common/header'); ?>
    <div class="container-fluid">
    <div class="panel panel-default">
    <div class="panel-heading">Edit User</div>
    <div class="panel-body">
    <form method="POST" action="" >
      <div class="col-md-4 col-md-offset-4">
      <div class="form-group">
      <label class="control-label">Username :</label>
      <input type="text" name="username" value="<?php echo $userdetails->username; ?>" class="form-control" required>
      </div>
      <div class="form-group">
      <label class="control-label"><code>Note: Change Password (Double click to edit)</code></label>
      <input type="text" name="password" value="" class="form-control" id="change-pass-fld" readonly="readonly" >
      </div>

      <div class="form-group">
      <label class="control-label">Name :</label>
      <input type="text" name="name" value="<?php echo $userdetails->name; ?>" class="form-control"/>
			</div>      
      
      <div class="form-group">
      <label class="control-label">Email :</label>
      <input type="email" name="email" value="<?php echo $userdetails->email; ?>" class="form-control"/>
      </div>
      
      <div class="form-group">
      <label class="control-label">Mobile :</label>
      <input type="text" name="mob" value="<?php echo $userdetails->mob; ?>" maxlength="10" class="form-control"/>
      </div>
      
      <div class="form-group">
      <label class="control-label">Status :</label>
      <select name="status" class="form-control">
      <option value="1" <?php if($userdetails->status == '1') echo 'selected="selected"'; ?>>Enabled</option>
      <option value="0" <?php if($userdetails->status == '0') echo 'selected="selected"'; ?>>Disabled</option>
      </select>
      </div>
      <div class="form-group">
      <input type="submit" name="submit" value="Save Changes" id="submit-btn" class="btn btn-primary" />
      </div>
      </div>
    </form>
    </div>
    <div class="panel-footer">
		<?php $this->load->view('admin/common/footer'); ?>
    </div>
		</div>
    </div>
		
	</body>
	<?php $this->load->view('admin/common/bottom'); ?>
	<!-- PAGE SPECIFIC JS-->
	<script>
		$(document).ready(function()
			{
				$("#change-pass-fld").dblclick(function()
				{
					$(this).attr('readonly', false);
				});
			});
	</script>
	<!-- PAGE SPECIFIC JS-->
</html>
