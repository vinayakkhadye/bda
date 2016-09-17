<!DOCTYPE html>
<html lang="en">
<head>
  <title>Advertisements | BDA</title>
	<?php $this->load->view('admin/common/head'); ?>
	<!-- <link type="text/css" rel="stylesheet" href="<?php echo CSS_URL; ?>admin/doctor.css"/>
		<link type="text/css" rel="stylesheet" href="<?php echo CSS_URL; ?>admin/masters.css"/>
		<link type="text/css" rel="stylesheet" href="<?php echo CSS_URL; ?>admin/validationEngine.jquery.css"/> 
		<link id="bs-css" href="<?php echo CSS_URL; ?>admin/jquery-ui-new.css" rel="stylesheet"> -->
</head>
<body>
<?php $this->load->view('admin/common/header'); ?>
<div class="container-fluid">
<div class="panel panel-default">
<div class="panel-heading">Advertisements 
	<a href="/bdabdabda/advertisements/add_campaign"  style="float: right; margin-top: -7px"><input type="button" value="Add a campaign" class="add-btn btn btn-primary" /></a></div>
<div class="panel-body">

<form action="" method="GET"  class="form-inline">
<div   id="container">
	<div class="form-group">
	<label class="control-label">Company Name :</label>
	<input name="company_name" type="text" class="form-control earch-field" value="<?=@$_GET['company_name']?>"/>
	</div>
	<div class="form-group">
	<label class="control-label">Status :</label>
	<select class="search-field form-control" name="status">
	<option value="">
	Select Status
	</option>
	<option value="A" <?php if(isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] == 'A') echo 'selected="selected"'; ?>>
	Active
	</option>
	<option value="S" <?php if(isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] == 'S') echo 'selected="selected"'; ?>>
	Suspended
	</option>
	<option value="D" <?php if(isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] == 'D') echo 'selected="selected"'; ?>>
	Draft
	</option>
	<option value="C" <?php if(isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] == 'C') echo 'selected="selected"'; ?>>
	Completed
	</option>
	</select>
	</div> 
	<div class="form-group">
	<label class="control-label">Date Range :</label>
	<!-- <input id="date_from" type="text" name="date_from" class="scheduled_date form-control" value=" "   />  -->
	<input name="start_date_from"   type="text" class="scheduled_date form-control   " value=" "/>&nbsp; to &nbsp;&nbsp;
	<input name="start_date_to" type="text" class="scheduled_date form-control    " value=" "/>
	</div>
	<div class="form-group">
	<input name="submit" type="submit" class="PA3 btn btn-default" value="Search"/>
	</div>
 
</div>
			</form>
			<hr>
			 
				<form name="edit_records" id="edit_records" action="" method="post" >
					<div class="display-table">			 
							
								 
					<div class="btn-group PB5">
						<input name="submit" type="submit" class="PA3 btn btn-primary" value="Active" />
						 
						<input name="submit" type="submit" class="PA3 btn btn-primary" value="Draft" />
						 
						<input name="submit" type="submit" class="PA3 btn btn-primary" value="Suspended" />
						 
						<input name="submit" type="submit" class="PA3 btn btn-primary" value="Completed" />
					</div>

						<table border="1" cellpadding="0" cellspacing="0" class="basic-profile-details-table table table-striped table-bordered table-hover">
							<tr>
								<th></th>
								<th>ID</th>
								<th>Campaign Name</th>
								<th>Company Name</th>
								<th>Division</th>
								<th>Status</th>
								<th>Start Date</th>
								<th>Brand Name</th>
								<th>Action</th>
							</tr>
							<?php
								if(is_array($allrecords) && sizeof($allrecords) > 0):
								foreach($allrecords as $row): 
							?>
							<tr>
								<td class="check">
									<input type="checkbox" name="record_id[<?php echo @$row->id; ?>]" class="rowcheck">
								</td>
								<td><?php echo @$row->id; ?></td>
								<td><a href="/bdabdabda/advertisements/view_campaign/<?php echo @$row->id; ?>"><?php echo ucfirst(@$row->campaign_name); ?></a></td>
								<td><?php echo ucfirst(@$row->company_name); ?></td>
								<td><?php echo ucfirst(@$row->division); ?></td>
								<td>
									<?php 
										if(@$row->status == 'A')
										echo 'Active';
										elseif(@$row->status == 'S')
										echo 'Suspended';
										elseif(@$row->status == 'D')
										echo 'Draft';
										elseif(@$row->status == 'C')
										echo 'Completed';
									?>
								</td>
								<td><?php echo ucfirst(@$row->start_date); ?></td>
								<td><?php echo ucfirst(@$row->brand_name); ?></td>
								<td>
									<a href="/bdabdabda/advertisements/editcampaign/<?php echo @$row->id; ?>"><input type="button" value="Edit" class="btn btn-default" /></a>
									<a href="/bdabdabda/advertisements/add_doctor_campaign/<?php echo @$row->id; ?>"><input type="button" value="Add Doctor" class="btn btn-default"/></a>
								</td>
							</tr>
							<?php endforeach; ?>
							<?php else: ?>
							<tr>
								<td colspan="6" style="text-align: center;"> No Records found </td>
							</tr>
							<?php endif; ?>
						</table>

					</div>
					<div class="pagination"><?php echo $this->pagination->create_links(); ?></div>
				 
				</form>
 </div>

	<div class="panel-footer">
	<?php $this->load->view('admin/common/footer'); ?>
	</div>

		</div>
		</div>
	</body>
	<?php $this->load->view('admin/common/bottom'); ?>

<!--PAGE SPECIFIC SCRIPT-->
	<!--<script src="<?php echo JS_URL; ?>admin/jquery-ui-new.js"></script>
	<script src="<?php echo JS_URL; ?>admin/jquery.validationEngine-en.js"></script>
	<script src="<?php echo JS_URL; ?>admin/jquery.validationEngine.js"></script> -->s
	
	


    <script type="text/javascript">
	$(document).ready(function() { 
	$('.scheduled_date').datepicker({
			format: "yyyy-mm-dd",
			autoclose: true,
			todayHighlight: true,
			orientation: "top left"
	});
	});
	</script>

	<script type="text/javascript">
 

		$(document).ready(function()
			{
				$("#left_Panel").height($("#content_area").height());

				// $( "#start_date_from" ).datepicker(
				// 	{
				// 		changeMonth: true,
				// 		changeYear: true,
				// 		onClose: function( selectedDate )
				// 		{
				// 			$( "#start_date_to" ).datepicker( "option", "minDate", selectedDate );
				// 		}
				// 	});
				// $( "#start_date_to" ).datepicker(
				// 	{
				// 		changeYear: true,
				// 		onClose: function( selectedDate )
				// 		{
				// 			$( "#start_date_from" ).datepicker( "option", "maxDate", selectedDate );
				// 		}
				// 	});
				
				$(".name-field").on('change', function()
					{
						var recordvalue = $(this).val();
						var recordid = this.id;
						$.ajax(
						{
							url:'/bdabdabda/masters/update_name/qualification',
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

			});
	</script>
		
<!--PAGE SPECIFIC SCRIPT-->

</html>
