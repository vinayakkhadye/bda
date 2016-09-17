<!DOCTYPE html>
<html lang="en">
<head>
  <title>Add Agent view| BDA</title>
	<?php $this->load->view('admin/common/head'); ?> 
</head>
<body>
<?php $this->load->view('admin/common/header'); ?>
<div class="container-fluid">
<div class="panel panel-default">
<div class="panel-heading">Add Agent <a href="javascript:window.history.back();" class="btn btn-primary FR">Back</a><div class="CL"></div></div>
<div class="panel-body">
<form  method="POST" name="add_agent" data-toggle="validator" >
	<div class="col-md-4 col-md-offset-4">
  <div class="form-group">
    <label class="control-label">Name :</label>
	  <input type="text" class="form-control" name="agent_name" placeholder="Agent Name" required>
  </div>
  <div class="form-group">
    <label class="control-label">Number :</label>
	  <input type="text" class="form-control" name="agent_number" placeholder="+917718964453" required>
  </div>
  <div class="form-group">
  <input type="submit" name="submit" value="Add Agent" class="btn btn-primary" />
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
