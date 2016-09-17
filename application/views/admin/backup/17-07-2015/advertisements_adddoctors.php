<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php $this->load->view('admin/common/head'); ?>
<!-- 		<link type="text/css" rel="stylesheet" href="<?php echo CSS_URL; ?>admin/doctor.css"/>
		<link type="text/css" rel="stylesheet" href="<?php echo CSS_URL; ?>admin/masters.css"/>
		<link type="text/css" rel="stylesheet" href="<?php echo CSS_URL; ?>admin/validationEngine.jquery.css"/> 
		<link id="bs-css" href="<?php echo CSS_URL; ?>admin/jquery-ui-new.css" rel="stylesheet"> -->
	</head>
	<body>
		<?php $this->load->view('admin/common/header'); ?>
		<div class="container-fluid" >
<div class="panel panel-default">
<div class="panel-heading">Add A Doctor</div>
<div class="panel-body" >
			<div class="row" style="margin-bottom: 10px ">
			 <form action="" method="GET"> 
				<div id="search-div">
					<div class="col-md-2">					 
				   <input name="doctor_name" type="text" placeholder="Doctor Name"  class="search-field form-control" value="<?php echo @$_GET['doctor_name']; ?>"/>
					 </div>
					<div class="col-md-2">
				  <select class="search-field form-control" name="speciality_id">
							<option value="">
								Select Speciality
							</option>
							<?php foreach($speciality_master as $row): ?>
							<option value="<?php echo $row->id; ?>" <?php if(isset($_GET['speciality_id']) && !empty($_GET['speciality_id']) && $_GET['speciality_id'] == $row->id) echo "selected" ?>>
								<?php echo ucfirst($row->name); ?>
							</option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="col-md-2"> 
					 <select class="search-field form-control" name="city_id">
							<option value="">
								Select City
							</option>
							<?php foreach($city_master as $row): ?>
							<option value="<?php echo $row->id; ?>"  <?php if(isset($_GET['city_id']) && !empty($_GET['city_id']) && $_GET['city_id'] == $row->id) echo "selected" ?>>
								<?php echo ucfirst($row->name); ?>
							</option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="col-md-1">
						<input name="submit" type="submit" class="PA3 btn btn-default" value="Search"/>
					</div>
				</div>
			 </form>
     		</div>
			<div class="row">
					<div class="col-md-6">

						<div class="add-doc-main-container">
						<div class="add-doc-left-container">
								<?php if(isset($searchrecords['docdata']) && sizeof($searchrecords['docdata'])>0): ?>
							<table class="table table-striped table-condensed table-bordered table-responsive">
								<tr>	
									<th>Doctor Name</th>
									<th>City</th>
									<th>Speciality</th>
									<th>Package</th>
									<th>Action</th>
								</tr>
								<?php foreach($searchrecords['docdata'] as $value): ?>
								<tr id="s<?php echo $value['doctor_id']; ?>">
									<td id="doc_name_<?php echo $value['doctor_id']; ?>"><?php echo $value['doctor_name']; ?></td>
									<td id="city_name_<?php echo $value['doctor_id']; ?>"><?php echo $value['city_name']; ?></td>
									<td id="spec_name_<?php echo $value['doctor_id']; ?>"><?php echo $value['speciality_name']; ?></td>
									<td><?php echo $value['packages_name']; ?></td>
									<td><a href="#s<?php echo $value['doctor_id']; ?>" class="add-doc-btn" id="<?php echo $value['doctor_id']; ?>" >
										<img src="<?php echo IMAGE_URL; ?>admin/add-user.png" alt="Add Doctor" title="Add Doctor" />
									</a></td>
								</tr>
								<?php endforeach; ?>
							</table>
								<?php endif; ?>
						</div>
						</div>

					</div>
					<div class="col-md-6">

						<div class="add-doc-right-container">
						<p>&nbsp;&nbsp;&nbsp;
							No of doctors alloted : <input type="text" disabled style="width: 50px;" value="<?php echo $no_of_doctors['no_of_doctors']; ?>" disabled />&nbsp;&nbsp;&nbsp;
							No of doctors added : <input type="text" style="width: 50px;" value="<?php echo sizeof($campaign_doctors); ?>" disabled />
						</p>
							<?php if(sizeof($campaign_doctors)>0): ?>
						<table class="table table-striped table-condensed table-bordered table-responsive">
							<tr>
								<th>Doctor Name</th>
								<th>City</th>
								<th>Speciality</th>
								<th>Action</th>
							</tr>
							<?php foreach($campaign_doctors as $value): ?>
							<tr>
								<td><?php echo $value['doctor_name']; ?></td>
								<td><?php echo $value['city_name']; ?></td>
								<td><?php echo $value['speciality_name']; ?></td>
								<?php if($value['activated'] == 0): ?>
									<td style="width: 131px;"><a href="javascript:void(0);" class="activate-btn btn btn-default" id="<?php echo $value['doctor_id']; ?>" >
										<span class="glyphicon glyphicon-play">Activate Now<span>
									</a>
									<a href="javascript:void(0);" class="delete-doc-btn btn btn-default" id="<?php echo $value['doctor_id']; ?>">	
										<span class="glyphicon glyphicon-remove">Delete<span>
									</a>
									</td>
								<?php else: ?>
									<td style="width: 131px;">
										Activated
									</td>
								<?php endif; ?>
							</tr>
							<?php endforeach; ?>
						</table>
							<?php endif; ?>
						</div>

					</div>
			  
           </div>


</div>
<div class="panel-footer">
<?php $this->load->view('admin/common/footer'); ?>
</div>

</div>
</div>
<?php $this->load->view('admin/common/bottom'); ?>
	</body>
 
	
	<script type="text/javascript">
		$(document).ready(function()
			{
				var url      = window.location.href; 
				if (url.search("#") >= 0) 
				{
				    //found it, now do something
					window.location.replace(url);
				} 
				
				$("#left_Panel").height($("#content_area").height());

				$( "#start_date_from" ).datepicker(
					{
						changeMonth: true,
						changeYear: true,
						onClose: function( selectedDate )
						{
							$( "#start_date_to" ).datepicker( "option", "minDate", selectedDate );
						}
					});
				$( "#start_date_to" ).datepicker(
					{
						changeYear: true,
						onClose: function( selectedDate )
						{
							$( "#start_date_from" ).datepicker( "option", "maxDate", selectedDate );
						}
					});
				
				$(".add-doc-btn").on('click', function()
					{
						var docid = this.id;
						var campaignid = '<?php echo $campaign_id; ?>';
						var docname = $('#doc_name_'+docid).html();
						var cityname = $('#city_name_'+docid).html();
						var specname = $('#spec_name_'+docid).html();
						$.ajax(
						{
							url:'/bdabdabda/campaigns/check_doctor_eligible_campaign',
							type:"POST",
							data:{
								'doctor_id':docid,
								'campaign_id':campaignid,
								'docname':docname,
								'cityname':cityname,
								'specname':specname
							},
							success: function(resp)
							{
								console.log(resp);
								if(resp.substring(0,7) == 'success')
								{
									location.reload();
								}
								else
								{
									alert(resp);
								}
							}
						});
					});
				
				$(".delete-doc-btn").on('click', function()
					{
						var a = confirm("Are you sure you want to remove this doctor from the campaign?");
						if(a == true)
						{
							var docid = this.id;
							var campaignid = '<?php echo $campaign_id; ?>';
							$.ajax(
							{
								url:'/bdabdabda/campaigns/remove_doctor_campaign',
								type:"POST",
								data:{
									'doctor_id':docid,
									'campaign_id':campaignid
								},
								success: function(resp)
								{
									console.log(resp);
									if(resp.substring(0,7) == 'success')
									{
										location.reload();
									}
									else
									{
										alert(resp);
									}
								}
							});
						}
					});
				
				$(".activate-btn").on('click', function()
					{
						var a = confirm("Are you sure you want to activate the assigned package for this campaign to this doctor?");
						if(a == true)
						{
							var docid = this.id;
							var campaignid = '<?php echo $campaign_id; ?>';
							$.ajax(
							{
								url:'/bdabdabda/campaigns/activate_doctor_package',
								type:"POST",
								data:{
									'doctor_id':docid,
									'campaign_id':campaignid
								},
								success: function(resp)
								{
									console.log(resp);
									if(resp.substring(0,7) == 'success')
									{
										location.reload();
									}
									else
									{
										alert(resp);
									}
								}
							});
						}
					});
				
			});
	</script>
		
 
</html>
