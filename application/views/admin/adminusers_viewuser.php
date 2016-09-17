<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
  	<title>View Users  | BDA</title>
		<?php $this->load->view('admin/common/head'); ?>
	</head>
	<body>
		<?php $this->load->view('admin/common/header'); ?>
  <div class="container-fluid">
  <div class="panel panel-default">
  <div class="panel-heading">View Details 
  <a href="/bdabdabda/manage_adminusers/edit_user/<?php echo $userdetails->id; ?>" class="FR btn btn-primary">Edit User Details</a>
  <div class="CL"></div>
  </div>
  <div class="panel-body">
		<form>
    <div class="form-group">
	    <label class="control-label">Username : <?php echo $userdetails->username; ?></label>
    </div>
    <div class="form-group">
	    <label class="control-label">Name : <?php echo $userdetails->name; ?></label>
    </div>
    <div class="form-group">
	    <label class="control-label">Mobile Number : <?php echo $userdetails->mob; ?></label>
    </div>
    <div class="form-group">
	    <label class="control-label">Email Id : <?php echo $userdetails->email; ?></label>
    </div>

    <div class="form-group">
	    <label class="control-label">Status : <?php echo $userdetails->status; ?></label>
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
</html>
