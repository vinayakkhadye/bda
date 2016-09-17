<!DOCTYPE html>
<html lang="en">
<head>
  <title>Package Master | BDA</title>
	<?php $this->load->view('admin/common/head'); ?>
</head>
<body>
<?php $this->load->view('admin/common/header'); ?>
<div class="container-fluid">
<div class="panel panel-default">
<div class="panel-heading">Package</div>
<div class="panel-body">
<form class="form-inline" method="POST" data-toggle="validator">
  <div class="form-group">
    <label class="control-label">Name : </label>
    <input name="new_record_name" id="new_record_name" type="text" class="form-control" placeholder="Name .. " required>
  </div>
  <div class="form-group">
    <label class="control-label">Status : </label>
    <select name="new_record_status" class="form-control" >
      <option value="1">Enabled</option>
      <option value="0">Disabled</option>
      <option value="-1">Deleted</option>
    </select>
  </div>
  <div class="form-group">
    <label class="control-label">User Type :</label>
    <select name="new_record_usertype" class="form-control" required>
      <option value="1">Patient</option>
      <option value="2">Doctor</option>
    </select>
  </div>
  <div class="form-group">
    <label class="control-label">Amount :</label>
    <input name="new_sort_amount" id="new_sort_amount" type="text" class="form-control" placeholder="Amount .. "/>
  </div>
  <div class="form-group">
   <input type="submit" name="submit" id="new_record_submit"  value="Add Entry" class="btn btn-primary" />
   </div>
</form>
<hr />
<form class="form-inline" method="GET" action="">
  <div class="form-group">
    <label class="control-label">Package Name : </label>
    <input name="record_name" type="text" value="<?=@$_GET['record_name']?>" class="form-control"/>
  </div>
  <div class="form-group">
    <label class="control-label">Status : </label>
    <select name="status" class="form-control" >
      <option value="1" <?=(isset($_GET['status']) && $_GET['status']==1)?'selected':''?> >Enabled</option>
      <option value="0" <?=(isset($_GET['status']) && $_GET['status']==0)?'selected':''?>>Disabled</option>
      <option value="-1" <?=(isset($_GET['status']) && $_GET['status']==-1)?'selected':''?>>Deleted</option>
    </select>
  </div>
  <div class="form-group">
  <input name="submit" type="submit" value="Search" class="btn btn-primary"/>
  </div>
</form>
<hr />
<form name="edit_records" id="edit_records" method="post" class="" >
		<div class="form-group">
    <div class="btn-group PB5">
      <button type="submit" name="submit" value="Enable" class="btn btn-primary">Enable</button>
      <button type="submit" name="submit" value="Disable"class="btn btn-primary">Disable</button>
      <button type="submit" name="submit" value="Delete"class="btn btn-primary">Delete</button>
      <label class="control-label"><code>Note: Double click on an entry to edit / update</code></label>
    </div>
    <table class="table table-striped table-condensed table-bordered table-responsive">
							<tr>
								<th><span class="glyphicon glyphicon-check" aria-hidden="true"></span></th>
								<th>ID</th>
								<th>Name</th>
								<th>Amount</th>
								<th>Status</th>
								<th>Package for</th>
							</tr>
							<?php
								if(sizeof($allrecords) > 0):
								foreach($allrecords as $row): 
							?>
							<tr>
								<td class="check">
									<input type="checkbox" name="record_id[<?php echo $row->id; ?>]" class="rowcheck">
								</td>
								<td><?php echo $row->id; ?></td>
								<td><input type="text" class="name-field form-control" id="<?php echo $row->id; ?>" readonly value="<?php echo ucfirst(@$row->name); ?>" /></td>
								<td><input type="text" class="amount-field form-control" id="<?php echo $row->id; ?>" style="width:70px;" readonly value="<?php echo @$row->price; ?>" /></td>
								<td>
									<?php if($row->status == '1'): ?>Enabled<?php elseif($row->status == '0'): ?>Disabled<?php else: ?>Deleted<?php endif; ?>
								</td>
								<td>
									<select class="package-field form-control" id="<?php echo $row->id; ?>" >
										<option value="1" <?php if(@$row->user_type == '1') echo "selected='selected'"; ?>>Patient</option>
										<option value="2" <?php if(@$row->user_type == '2') echo "selected='selected'"; ?>>Doctor</option>
									</select>
								</td>
							</tr>
							<?php endforeach; ?>
							<?php else: ?>
							<tr>
								<td colspan="6" style="text-align: center;"> No Records found </td>
							</tr>
							<?php endif; ?>
						</table>
    <ul class="pagination"><?php echo $this->pagination->create_links(); ?></ul>
    </div>
</form>
</div>
<div class="panel-footer">
<?php $this->load->view('admin/common/footer'); ?>
</div>
</div>
</div>
<?php $this->load->view('admin/common/bottom'); ?>
<!--PAGE SPECIFIC SCRIPT-->
<script type="text/javascript">
		$(document).ready(function()
			{
				$(".package-field").add(".name-field").add(".amount-field").on('dblclick', function()
					{
						$(this).attr('readonly', false);
					});
				$(".package-field").add(".name-field").add(".amount-field").on('blur', function()
					{
						$(this).attr('readonly', true);
					});
				$(".package-field").add(".name-field").add(".amount-field").keypress(function(e)
					{
						if(e.which == 13) 
					    {
					    	$(this).trigger('blur');
					    	return false;
					    }
					});
				$(".amount-field").on('change', function()
					{
						var value = $(this).val();
						var recordid = this.id;
						$.ajax(
						{
							url:'/bdabdabda/masters/update_package_amount',
							type:"POST",
							data:{
								'recordid':recordid,
								'value':value
							},
							success: function(resp)
							{
								//console.log(resp);
								alert('Update Successful');
							}
						});
					});
				$(".package-field").on('change', function()
					{
						var value = $(this).val();
						var recordid = this.id;
						$.ajax(
						{
							url:'/bdabdabda/masters/update_package_usertype',
							type:"POST",
							data:{
								'recordid':recordid,
								'value':value
							},
							success: function(resp)
							{
								//console.log(resp);
								alert('Update Successful');
							}
						});
					});
				$(".name-field").on('change', function()
					{
						var recordvalue = $(this).val();
						var recordid = this.id;
						$.ajax(
						{
							url:'/bdabdabda/masters/update_name/packages',
							type:"POST",
							data:{
								'recordid':recordid,
								'recordvalue':recordvalue
							},
							success: function(resp)
							{
								//console.log(resp);
								alert('Update Successful');
							}
						});
					});
			});
	</script>
<!--PAGE SPECIFIC SCRIPT-->
</body>
</html>
