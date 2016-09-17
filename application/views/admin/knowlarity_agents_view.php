<!DOCTYPE html>
<html lang="en">
<head>
  <title>Knowlarit Agents view | BDA</title>
	<?php $this->load->view('admin/common/head'); ?>
</head>
<body>
<?php $this->load->view('admin/common/header'); ?>
<div class="container-fluid">
<div class="panel panel-default">
<div class="panel-heading">Knowlarit Agents <a href="/bdabdabda/knowlarity/agent_add" class="btn btn-primary FR">Add Agent</a><div class="CL"></div></div>

<div class="panel-body">
<form name="agent_records" method="post" >
		<div class="table-responsive">
    <table class="table table-striped table-condensed table-bordered" >
    <tr>
    <th>Name</th>
    <th>Number</th>
    <th>Is Busy</th>
    <th>Status</th>
    <th><span class="glyphicon glyphicon-edit"></span></th>
    </tr>
    
  <?php if ($flag) {
  foreach ($flag as $row) { ?>
    <tr>
    <td><?php echo ucfirst($row->name); ?></td>
    <td><?php echo $row->number; ?></td>
    <td>
			<?php if($row->isbusy==1){ echo "Busy";}else if($row->isbusy==0){ echo "Free";}?>
    </td>
		<td>
			<?php if($row->status==1){ echo "Enabled";}else if($row->status==0){ echo "Disabled";}else if($row->status==-1){ echo "Deleted";}?>
    </td>    
    <td><a href="/bdabdabda/knowlarity/agent_edit/<?=$row->id?>" title="edit agent"><span class="glyphicon glyphicon-edit"></span></a></td>
    </tr>
   <?php }}else{?>
    <tr>
    <td colspan="5" align="center">No Doctors Available </td>
    </tr>
    <?php } ?>
    </table>
    </div>
    <ul class="pagination"><?php echo $this->pagination->create_links(); ?></ul>
</form>
</div>


<div class="panel-footer">
<?php $this->load->view('admin/common/footer'); ?>
</div>
</div>
</div>
<?php $this->load->view('admin/common/bottom'); ?>


<script>
		$(document).ready(function()
			{
				$("#chackAll").change(function()
					{
						if(this.checked)
						{
							$('.rowcheck').prop('checked', true);
						}else
						{
							$('.rowcheck').prop('checked', false);
						}
					});
				// $("#date").datepicker(
				// 	{
				// 		dateFormat: "dd-mm-yy",
				// 		defaultDate: "-25y",
				// 		changeMonth: true,
				// 		changeYear: true,
				// 		yearRange: "1900:2014"
				// 	});
				// $("#left_Panel").height($("#content_area").height());
			 });

	</script>
<!--PAGE SPECIFIC SCRIPT-->
</body>
</html>
