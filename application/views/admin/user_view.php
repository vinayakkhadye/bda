<!DOCTYPE html>
<html lang="en">
<head>
  <title>User | BDA</title>
	<?php $this->load->view('admin/common/head'); ?>
</head>
<body>
<?php $this->load->view('admin/common/header'); ?>
<div class="container-fluid">
<div class="panel panel-default">
<div class="panel-heading">User<!--<a class="btn btn-primary FR" href="/bdabdabda/reviews/add_reviews">Add a Review</a><div class="CL"></div>--></div>
<div class="panel-body">
	 	<form class="form-inline" method="GET" action="">
				<div class="form-group">
				<label class="control-label">ID : </label>
				<input type="text" value="<?=@$id?>" placeholder=" ID" name="id" class="form-control">
				</div>
				<div class="form-group">
				<label class="control-label">Name : </label>
				<input type="text" value="<?=@$name?>" placeholder="Name" name="name" class="form-control">
				</div> 
				<div class="form-group">
				<label class="control-label">Contact No. : </label>
				<input type="text" value="<?=@$contact?>" placeholder="Contact No." name="contact" class="form-control">
				</div>
				<div class="form-group">
				<label class="control-label">User Email : </label>
				<input type="text" value="<?=@$user_email?>" placeholder="Users Email" name="user_email" class="form-control">
				</div>
				<div class="form-group">
				<label class="control-label">Gender : </label>
				<select  class="form-control" name="gender">
				<option value="">Select Gender</option>
				<option value="m" <?=(isset($gender) && $gender == 'm')?'selected="selected"':''?>>Male</option>
				<option value="f" <?=(isset($gender) && $gender == 'f')?'selected="selected"':''?>>Female</option> 
				</select>    
				</div>
				<div class="form-group">
				<label class="control-label">Is Verified : </label>
				<select  class="form-control" name="verified"> 
				<option value="1" <?=(isset($is_verified) && $is_verified == 1)?'selected="selected"':''?>>Yes</option>
				<option value="2" <?=(isset($is_verified) && $is_verified == 2)?'selected="selected"':''?>>No</option> 
				</select>    
				</div>
				<div class="form-group">
				<label class="control-label">Type : </label>
				<select  class="form-control" name="type">
				<option value="">Select Type</option>
				<option value="1" <?=(isset($type) && $type == 1)?'selected="selected"':''?>>Patient</option>
				<option value="2" <?=(isset($type) && $type == 2)?'selected="selectected"':''?>>Doctor</option> 
				</select>    
				</div>

				<div class="form-group">
				<input type="submit" value="Search" name="search" class="btn btn-primary">
				</div>
		</form>  
<hr /> 
<form name="edit_records" id="edit_records" method="post" class="" >
		<div class="form-group">
    <div class="table-responsive">
    <table border="0" align="center" cellpadding="0" cellspacing="0" class="table table-striped table-bordered table-hover">
							<tr>
								<th><input type="checkbox" id="chackAll"></th>
								<th>Id</th> 
								<th>Name</th>
								<th>Email ID</th>
								<th>Contact No.</th>
								<th>Gender</th>
								<th>DOB</th>
								<th>Is Verified</th>
								<th>Type</th>
							</tr>
							<?php
							if($user)
							{
								foreach($user as $row)
								{
									?>
									  <?php   //print_r($row); ?>
									<tr>
										<td>
											<input type="checkbox" class="rowcheck" name=" id[<?php echo $row->id; ?>]" id=" id_<?php echo $row->id; ?>" />
										</td>
										<td><?php echo ucfirst($row->id); ?></td> 
										<td><?php echo ucfirst($row->name); ?></td> 
										<td><?php echo ucfirst($row->email_id); ?></td>
										<td><?php echo ucfirst($row->contact_number); ?></td>
										<td><?php echo $row->gender; ?></td>
										<td><?php echo $row->dob; ?></td>
										<td><?php
											if($row->is_verified)
											{
												echo "Yes";
											}
											else
											{
												echo "No";
											}
											 ?></td>
										<td><?php 
											if($row->type == 1)
											{
												echo "Patient";
											}
											else if($row->type == 2)
											{
												echo "Doctor";
											}

										 ?></td>
										 
									</tr>
									<?php
								}
							}
							else
							{
								?>
								<tr>
									<td colspan="9" align="center">
										No Reviews Found
									</td>
								</tr>
								<?php
							} ?>
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
				$("#date").datepicker(
					{
						dateFormat: "dd-mm-yy",
						defaultDate: "-25y",
						changeMonth: true,
						changeYear: true,
						yearRange: "1900:2014"
					});
				$("#left_Panel").height($("#content_area").height());
			});
	</script>
<!--PAGE SPECIFIC SCRIPT-->
</body>
</html>
