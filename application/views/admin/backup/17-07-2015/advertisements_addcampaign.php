<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Add Campaign | BDA</title>
		<?php $this->load->view('admin/common/head'); ?> 
		
	</head>
<body>
<?php $this->load->view('admin/common/header'); ?>
<div class="container-fluid" >
<div class="panel panel-default">

	<div class="panel-heading">Add Campaign</div>

	<div class="panel-body" >
				<form method="POST" id="add-form-admin" enctype="multipart/form-data" data-toggle="validator">
					<div class="col-md-8 col-md-offset-2">
					<table class="table table-striped table-condensed table-bordered table-responsive">
						<tr>
							<td>Campaign Name</td>
							<td><input type="text" class="validate[required] form-control"  name="campaign_name" value="" required /></td>
						</tr>
						<tr>
							<td>Company Name</td>
							<td><input type="text" class="validate[required,custom[onlyLetterSp]] form-control" name="company_name" value="" required /></td>
						</tr>
						<tr>
							<td>Division</td>
							<td><input type="text" class="form-control" name="division" value="" required/></td>
						</tr>
						<tr>
							<td>Contact Name</td>
							<td><input type="text" class="validate[custom[onlyLetterSp]] form-control" name="contact_name" value="" required/></td>
						</tr>
						<tr>
							<td>Contact Number</td>
							<td><input type="text" class="validate[custom[integer],maxSize[15]] form-control" name="contact_number" value="" required /></td>
						</tr>
						<tr>
							<td>Contact Email</td>
							<td><input type="email" class="validate[custom[email]] form-control" name="contact_email" value="" /></td>
						</tr>
						<tr>
							<td>Start Date</td>
							<td><input type="text" class="validate[required] form-control" id="scheduled_date" readonly="readonly" name="start_date" value="" required /></td>
						</tr>
						<tr>
							<td>Number of Days</td>
							<td><input type="text" name="no_of_days" class="validate[required,custom[integer],maxSize[4]] form-control" value="" required/></td>
						</tr>
						<tr>
							<td>Status</td>
							<td>
								<select name="status" class="form-control" required>
									<option value="D">Draft</option>
									<option value="A">Active</option>
									<option value="S">Suspended</option>
									<option value="C">Completed</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Brand Name</td>
							<td><input type="text" name="brand_name" class="form-control" value="" required/></td>
						</tr>
						<tr>
							<td>Number of Doctors</td>
							<td><input type="text" class="validate[custom[integer],maxSize[4]] form-control" name="no_of_doctors" value="" required/></td>
						</tr>
						<tr>
							<td>Package</td>
							<td>
								<select name="package_id"  class="form-control" required>
									<?php foreach($packages as $row): ?>
										<option value="<?=$row->id; ?>"><?=$row->name; ?></option>
									<?php endforeach; ?>
								</select>
							</td>
						</tr>
						<tr>
							<td>Ad Image (low resolution)</td>
							<td><input type="file" name="ad_img_lres" class="form-control" value="" /></td>
						</tr>
						<tr>
							<td>Ad Image (medium resolution)</td>
							<td><input type="file" name="ad_img_mres" class="form-control" value="" /></td>
						</tr>
						<tr>
							<td>Ad Image (high resolution)</td>
							<td><input type="file" name="ad_img_hres" class="form-control" value="" /></td>
						</tr>
						<tr>
							<td>Ad Image (ultra high resolution)</td>
							<td><input type="file" name="ad_img_ures" class="form-control" value="" /></td>
						</tr>
						
						<tr>
							<td colspan="2" style="text-align: center;">
								<input type="submit" name="submit" class="btn btn-primary"  value="Add Campaign" />
							</td>
						</tr>
						
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
			$(document).ready(function()
				{
					$("#scheduled_date").datepicker(
					{
						dateFormat: "dd-mm-yy",
						changeMonth: true,
						changeYear: true,
						yearRange: "2015:2020"
					});
				});
		</script>
	</body>	
</html>
