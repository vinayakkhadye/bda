<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
    <title>Manage Users | BDA</title>
		<?php $this->load->view('admin/common/head'); ?>
	</head>
	<body>
  <?php $this->load->view('admin/common/header'); ?>
  <div class="container-fluid">
  <div class="panel panel-default">
  <div class="panel-heading">Users <a href="/bdabdabda/manage_adminusers/new_user" class="btn btn-primary FR" title="Add new admin user">Add User</a>
  <div class="CL"></div>
  </div>
  <div class="panel-body">
    <form class="form-inline">
      <div class="form-group">
      <label class="control-label">Username : </label>
      <input name="record_username" type="text" class="form-control" value="<?=@$_GET['record_username']?>"/>
      </div>
      <div class="form-group">
      <label class="control-label">Status : </label>
      <select class="form-control" name="status">
        <option value="">Select Status</option>
        <option value="1" <?=(@$_GET['status']==1)?'selected':''?> >Enabled</option>
        <option value="0" <?=(@$_GET['status']==0)?'selected':''?>>Disabled</option>
        <option value="-1" <?=(@$_GET['status']==-1)?'selected':''?>>Deleted</option>
      </select>
      </div>
      <div class="form-group">
        <input name="submit" type="submit" class="btn btn-primary" value="Search"/>
      </div>
    </form>
    <hr />
    <form name="edit_records" id="edit_records" action="" method="post" >
		<div class="form-group">
    <div class="btn-group PB5">
      <button type="submit" name="submit" value="Enable" class="btn btn-primary">Enable</button>
      <button type="submit" name="submit" value="Disable"class="btn btn-primary">Disable</button>
      <button type="submit" name="submit" value="Delete"class="btn btn-primary">Delete</button>
    </div>
    <table class="table table-striped table-condensed table-bordered table-responsive">
          <tr>
            <th><span class="glyphicon glyphicon-check" aria-hidden="true"></span></th>
            <th>Name</th>
            <th>Username</th>
            <th>Status</th>
            <th>Permissions</th> 
            <th>Created On</th> 
          </tr>
          <?php
            if(sizeof($allrecords) > 0):
            foreach($allrecords as $row): 
          ?>
          <tr>
            <td>
              <input type="checkbox" name="record_id[<?php echo $row->id; ?>]" class="rowcheck">
            </td>
            <td>
              <?php echo @$row->name; ?>
            </td>
            <td>
              <a href="/bdabdabda/manage_adminusers/edit_user/<?php echo @$row->id; ?>"><?php echo @$row->username; ?></a>
            </td>
            <td>
              <?php if($row->status == '1'): ?>Enabled<?php elseif($row->status == '0'): ?>Disabled<?php else: ?>Deleted<?php endif; ?>
            </td>
            <td>
            <a href="/bdabdabda/manage_adminusers/user_permissions/<?php echo @$row->name; ?>/<?php echo @$row->id; ?>">
            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
            </td>
            <td>
              <?php echo date('dS M Y h:i a', strtotime(@$row->created_on)); ?>
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
	<script type="text/javascript">
		$(document).ready(function()
			{

				$(".permission-field").on('click', function()
					{
						var permissiontype = $(this).attr('name');
						var userid = this.id;
						if($(this).is(':checked'))
						{
							var status = '1';
						}
						else
						{
							var status = '0';
						}
						console.log(permissiontype);
						console.log(userid);
						console.log(status);
						$.ajax(
						{
							url:'/bdabdabda/manage_adminusers/update_permission',
							type:"POST",
							data:{
								'userid':userid,
								'permissiontype':permissiontype,
								'status':status
							},
							success: function(resp)
							{
								//console.log(resp);
								alert('Permission Updated');
							}
						});
					});

			});
	</script>
	</body>	
</html>
