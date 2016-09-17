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
  <div class="panel-heading">Users - <?=urldecode($admin_user_name); ?> <a href="javascript:window.history.back();" class="btn btn-primary FR">Back</a>
  <div class="CL"></div>
  </div>
  <div class="panel-body">
    <form id="user_permission_form" onsubmit="return save_permission()">
		<div class="form-group">
    <table class="table table-striped table-condensed table-bordered table-responsive">
          <tr>
            <th>Function</th>
            <th>View</th>
            <th>Add</th> 
            <th>Edit</th> 
            <th>Delete</th> 
            <th>loginas</th> 
            <th>Search</th> 
          </tr>
          <?php if(sizeof($permissions) > 0){
            foreach($permissions as $row){?>
          <tr>
            <td><?php echo @$row->function_name; ?></td>
            <td>
	            <input type="checkbox" value="1" <?=(@$row->view)?'checked':''?> name="permission[<?=@$row->id?>][view]"  />
            </td>
            <td>
	            <input type="checkbox" value="1" <?=(@$row->add)?'checked':''?>  name="permission[<?=@$row->id?>][add]" />
            </td>
            <td>
            	<input type="checkbox" value="1" <?=(@$row->edit)?'checked':''?> name="permission[<?=@$row->id?>][edit]"  />
            </td>
            <td>
            	<input type="checkbox" value="1" <?=(@$row->delete)?'checked':''?> name="permission[<?=@$row->id?>][delete]"  />
            </td>
            <td>
	            <input type="checkbox" value="1" <?=(@$row->loginas)?'checked':''?> name="permission[<?=@$row->id?>][loginas]"  />
            </td>
            <td>
	            <input type="checkbox" value="1" <?=(@$row->search)?'checked':''?> name="permission[<?=@$row->id?>][search]"  />
              <input type="checkbox" value="1" checked hidden name="permission[<?=@$row->id?>][all]"  />
            </td>
          </tr>
          <?php } ?>
					<tr>
            <td colspan="6" style="text-align: center;">
            <input type="hidden" value="<?=$admin_user_id?>" name="admin_user_id"/>
            <input type="submit" value="Save Permissions" class="btn btn-primary" id="save_perm" />
            </td>
          </tr>          
          <?php }else{ ?>
          <tr>
            <td colspan="6" style="text-align: center;"> No Records found </td>
          </tr>
          <?php } ?>
        </table>
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
		function save_permission()
		{
			var loader	=	'Saving...';
			$("#save_perm").val(loader);
			var perm_data	=	$("#user_permission_form").serialize();		
			
			$.ajax(
			{
			url: '/bdabdabda/manage_adminusers/save_permissions',
			type: "POST",
			data:perm_data,
			success: function(resp)
			{
				$("#save_perm").val("Save Permissions");
				window.history.back();
			}
			}
			);
			return false;
		}

	</script>
	</body>	
</html>
