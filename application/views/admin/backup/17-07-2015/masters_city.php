<!DOCTYPE html>
<html lang="en">
<head>
  <title>City Master | BDA</title>
	<?php $this->load->view('admin/common/head'); ?>
</head>
<body>
<?php $this->load->view('admin/common/header'); ?>
<div class="container-fluid">
<div class="panel panel-default">
<div class="panel-heading">City</div>
<div class="panel-body">
<form class="form-inline" method="POST" data-toggle="validator">
  <div class="form-group">
    <label class="control-label">Name : </label>
    <input name="new_record_name" id="new_record_name" type="text" class="form-control" placeholder="Name .. " required>
  </div>
  <div class="form-group">
    <label class="control-label">State ID : </label>
    <select name="new_record_stateid" class="form-control" required >
		<?php if(isset($state_list) && is_array($state_list) && sizeof($state_list)){ ?>	
    				<option value="">Select State</option>
    	<?php foreach($state_list as $s_key=>$s_val){?>
      		<option value="<?=$s_val->id?>"><?=$s_val->name?></option>
    <?php }}?>
    </select>
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
    <label class="control-label">Sort Order : </label>
    <input name="new_sort_order" id="new_sort_order" type="text" class="form-control" value=""/>
  </div>
  <div class="form-group">
   <input type="submit" name="submit" id="new_record_submit"  value="Add Entry" class="btn btn-primary" />
   </div>
</form>
<hr />
<form class="form-inline" method="GET" action="">
  <div class="form-group">
    <label class="control-label">Name : </label>
    <input name="record_name" type="text" value="<?=@$_GET['record_name']?>" class="form-control" placeholder="Name .."/>
  </div>
  <div class="form-group">
    <label class="control-label">State ID : </label>
    <select name="stateid" class="form-control" >
		<?php if(isset($state_list) && is_array($state_list) && sizeof($state_list)){ ?>	
    				<option value="">Select State</option>
    	<?php foreach($state_list as $s_key=>$s_val){?>
      		<option value="<?=$s_val->id?>" <?=(isset($_GET['stateid']) && $_GET['stateid']==$s_val->id)?'selected':''?> ><?=$s_val->name?></option>
    <?php }}?>
    </select>
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
    <label class="control-label">Sort Order : </label>
    <input name="new_sort_order" id="new_sort_order" type="text" class="form-control" value=""/>
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
								<th>State ID</th>
								<th>Status</th>
								<th>Sort Order</th>
							</tr>
							<?php
								if(is_array($allrecords) && sizeof($allrecords) > 0):
								foreach($allrecords as $row): 
							?>
							<tr>
								<td class="check">
									<input type="checkbox" name="record_id[<?php echo $row->id; ?>]" class="rowcheck form-control">
								</td>
								<td><?php echo $row->id; ?></td>
								<td><input type="text" class="name-field form-control" id="<?php echo $row->id; ?>" readonly value="<?php echo ucfirst(@$row->name); ?>" /></td>
								<td>
									<!--<input type="text" class="city-field form-control" id="<?php echo $row->id; ?>" readonly value="<?php echo @$row->state_id; ?>" />-->
									<select class="city-field form-control" id="<?php echo $row->id; ?>">
									<?php if(isset($state_list) && is_array($state_list) && sizeof($state_list)){ ?>	
                  <option value="">Select State</option>
                  <?php foreach($state_list as $s_key=>$s_val){?>
                  <option value="<?=$s_val->id?>" <?=(@$row->state_id==$s_val->id)?'selected':''?> ><?=$s_val->name?></option>
                  <?php }}?>
                  </select>

								</td>
								<td>
									<?php if($row->status == '1'): ?>Enabled<?php elseif($row->status == '0'): ?>Disabled<?php else: ?>Deleted<?php endif; ?>
                </td>
								<td>
									<input type="text" class="sort-field form-control" id="<?php echo $row->id; ?>" readonly value="<?php echo @$row->sort; ?>" />
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
				$(".sort-field").add(".name-field").on('dblclick', function(){
						$(this).attr('readonly', false);
					});
				$(".sort-field").add(".name-field").on('blur', function(){
						$(this).attr('readonly', true);
					});
				$(".sort-field").add(".name-field").keypress(function(e){
						if(e.which == 13) 
					    {
					    	$(this).trigger('blur');
					    	return false;
					    }
					});

				$(".sort-field").on('change', function(){
						var sortvalue = $(this).val();
						var recordid = this.id;
						$.ajax(
						{
							url:'/bdabdabda/masters/update_sort/city',
							type:"POST",
							data:{
								'recordid':recordid,
								'sortvalue':sortvalue
							},
							success: function(resp)
							{
								//console.log(resp);
								alert('Sort Order Updated Successfully');
							}
						});
					});
				$(".name-field").on('change', function()
					{
						var recordvalue = $(this).val();
						var recordid = this.id;
						$.ajax(
						{
							url:'/bdabdabda/masters/update_name/city',
							type:"POST",
							data:{
								'recordid':recordid,
								'recordvalue':recordvalue
							},
							success: function(resp)
							{
								//console.log(resp);
								alert('Record Updated Successfully');
							}
						});
					});
				$(".city-field").on('change', function()
					{
						var stateid = $(this).val();
						var recordid = this.id;
						$.ajax(
						{
							url:'/bdabdabda/masters/update_stateid',
							type:"POST",
							data:{
								'recordid':recordid,
								'stateid':stateid
							},
							success: function(resp)
							{
								//console.log(resp);
								alert('Record Updated Successfully');
							}
						});
					});
			});
	</script>
<!--PAGE SPECIFIC SCRIPT-->
</body>
</html>
