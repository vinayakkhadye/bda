<!DOCTYPE html>
<html lang="en">
<head>
  <title>Edit Agent view| BDA</title>
	<?php $this->load->view('admin/common/head'); ?> 
</head>
<body>
<?php $this->load->view('admin/common/header'); ?>
<div class="container-fluid">
<div class="panel panel-default">
<div class="panel-heading">Edit Agent <a href="javascript:window.history.back();" class="btn btn-primary FR">Back</a><div class="CL"></div></div>
<div class="panel-body">
<form  method="POST" name="add_agent" data-toggle="validator" >
	<input type="hidden" value="<?=@$agent_detail->id?>" name="agent_id" />
	<div class="col-md-4 col-md-offset-4">
  <div class="form-group">
    <label class="control-label">Name :</label>
	  <input type="text" class="form-control" name="agent_name" placeholder="Agent Name" value="<?=@$agent_detail->name?>" required>
  </div>
  <div class="form-group">
    <label class="control-label">Number :</label>
	  <input type="text" class="form-control" name="agent_number" placeholder="+917718964453" value="<?=@$agent_detail->number?>" required>
  </div>
	
  <div class="form-group">
    <label class="control-label">Is Buzy :</label>
    <select name="agent_busy" class="form-control" required>
	    <option value="" >Select</option>
      <option value="1" <?php if(@$agent_detail->isbusy == 1) echo "selected='selected'"; ?> >Buzy</option>
      <option value="0" <?php if(@$agent_detail->isbusy == 0) echo "selected='selected'"; ?> >Free</option>
    </select> 
  </div>
  <div class="form-group">
    <label class="control-label">Status :</label>
    <select name="agent_status" class="form-control" required>
	    <option value="" >Select</option>
      <option value="1" <?php if(@$agent_detail->status== 1) echo "selected='selected'"; ?> >Enabled</option>
      <option value="0" <?php if(@$agent_detail->status== 0) echo "selected='selected'"; ?> >Disabled</option>
      <!--<option value="-1" <?php if(@$agent_detail->status== -1) echo "selected='selected'"; ?> >Deleted</option>-->
    </select> 
  </div>
  <div class="form-group">
  <input type="submit" name="submit" value="Save" class="btn btn-primary" />
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
