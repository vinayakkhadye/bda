<!DOCTYPE html>
<html lang="en">
<head>
  <title>Sms Logs Master | BDA</title>
	<?php $this->load->view('admin/common/head'); ?>
</head>
<body>
<?php $this->load->view('admin/common/header'); ?>
<div class="container-fluid">
<div class="panel panel-default">
<div class="panel-heading">Sms Logs</div>
<div class="panel-body">
<form class="form-inline" method="GET" action="">
  <div class="form-group">
    <label class="control-label">Message : </label>
    <input name="message" type="text" value="<?=@$_GET['message']?>" class="form-control" placeholder="Message .."/>
  </div>

  <div class="form-group">
    <label class="control-label">Mobile Number : </label>
    <input name="mobile_number" type="text" value="<?=@$_GET['mobile_number']?>" class="form-control" placeholder="7718964453"/>
  </div>
  
  <div class="form-group">
    <label class="control-label">Response : </label>
    <input name="response" type="text" value="<?=@$_GET['response']?>" class="form-control" placeholder="Response .."/>
  </div>
  
  <div class="form-group">
    <label class="control-label">Status : </label>
    <select name="status" class="form-control" >
	  <option value="" >Select Status</option>
      <option value="1" <?=(isset($_GET['status']) && $_GET['status']=='1')?'selected':''?> >Sent</option>
      <option value="0" <?=(isset($_GET['status']) && $_GET['status']=='0')?'selected':''?>>Not Sent</option>
    </select>
  </div>
  
  <div class="form-group">
  	<label class="control-label">Added On  : </label>
  	<input class="created_on_start form-control" type="text" name="created_on_start" value="<?=(isset($_GET['created_on_start']) && !empty($_GET['created_on_start']))?@date('m/d/Y', strtotime($_GET['created_on_start'])):''?>" placeholder="Start Date .." />
  	<input class="created_on_end form-control" type="text" name="created_on_end" value="<?=(isset($_GET['created_on_end']) && !empty($_GET['created_on_end']))?@date('m/d/Y', strtotime($_GET['created_on_end'])):''?>" placeholder="End Date .." />
  </div>
  
  
  <div class="form-group">
  <input name="submit" type="submit" value="Search" class="btn btn-primary"/>
  </div>
</form>
<hr />
<form name="edit_records" id="edit_records" method="post" class="" >
	<div class="form-group">
    
    <div class="table-responsive">
    <table class="table table-striped table-condensed table-bordered">
							<tr>
								<th>ID</th>
								<th>Mob. Number</th>
								<th>Response</th>
								<th>Status</th>
								<th>Created On</th>
                <th>Processed On</th>
                <th>Processed In</th>
								<th>Message</th>
							</tr>
							<?php
								if(is_array($allrecords) && sizeof($allrecords) > 0):
								foreach($allrecords as $row): 
								$time	=	'-';
								if($row->processed_on)
								{
									$now = new DateTime($row->processed_on);
									$then = new DateTime($row->created_on);
									$diff = $now->diff($then);
									$time	=	$diff->format('%i minutes %s seconds');									
									#$time	=	strtotime($row->processed_on)-strtotime($row->created_on);
								}
							?>
							<tr>
								<td><?php echo $row->id; ?></td>
								<td><?php echo $row->mobile_number; ?></td>
								<td>
                <?php 
								$object	= json_decode($row->response,true);
								if(isset($object['error']['error-description']))
								{
									echo $object['error']['error-description'];
								}
								else if(isset($object['sms']['messageid']))
								{
									echo $object['sms']['messageid'];
								}
								else
								{
									echo $row->response;
								}
								?>
                </td>
								<td><?php if($row->status == '1'): ?><span class="label label-success">Sent</span><?php elseif($row->status == '0'): ?><span class="label label-danger">Not Sent</span><?php endif; ?></td>
								<td><?php echo date("Y-m-d h:i a",strtotime($row->created_on)); ?></td>
                <td><?php echo ($row->processed_on)?date("Y-m-d h:i a",strtotime($row->processed_on)):''; ?></td>
                <td><?php echo $time;?></td>
                <td><?php echo urldecode($row->message); ?></td>
							</tr>
							<?php endforeach; ?>
							<?php else: ?>
							<tr>
								<td colspan="6" style="text-align: center;"> No Records found </td>
							</tr>
							<?php endif; ?>
						</table>
    </div>        
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
		
					$(".created_on_start").datepicker(
			        {
			            dateFormat: "mm/dd/yyyy",
									autoclose:true,
									todayHighlight: true,
									orientation: "top left"
			        });
			        $(".created_on_end").datepicker(
			        {
			            dateFormat: "mm/dd/yyyy",
									autoclose:true,
									todayHighlight: true,
									orientation: "top left"
			        });
        			
			});
		
   
	</script>
<!--PAGE SPECIFIC SCRIPT-->
</body>
</html>
