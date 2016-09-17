<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
    <title>Import Process | BDA</title>
		<?php $this->load->view('admin/common/head'); ?>
	</head>
	<body>
		<?php $this->load->view('admin/common/header'); ?>
    <div class="container-fluid">
    <div class="panel panel-default">
    <div class="panel-heading">Import Process</div>
    <div class="panel-body">
    <div class="note">
    <span><h2>File Upload</h2></span>
    <span><h4>Note</h4></span>
    <li>First upload images related to the doctor file you will be uploading </li>
    <li>You can select multiple file.</li>
    <li>upload only image files.</li>
    </div>
    <form name="upload_image_data" action="/bdabdabda/import/doctor_image_upload" method="post" enctype="multipart/form-data" data-toggle="validator">
    <p>
    <label>Multiple File :</label>
    <input type="file" name="photos[]" multiple="multiple" required >
    </p>
    <p>
    <input type="submit" value="submit" class="btn btn-primary">
    </p>
    </form>
    <hr />
    <div class="note">
    <span style="font-weight:bold"><h2>Bulk Upload Doctors</h2></span>
    <span style="font-weight:bold">Note</span>
    <li>Provide .csv file in CSV(Comma delimited) format</li>
    <li>Ensure to select appropriate city before submit</li>
    <li>Use this file to refer format of csv sheet needs to be uploaded.</li>
    <li>
    <a href="/bdabdabda/import/download_file?file_name=/uploads/sample_files/col_order_test.csv">click here to download sheet format</a>
    </li>
    </div>
    <form name="upload_bulk_data" action="/bdabdabda/import/doctor_data" method="post" enctype="multipart/form-data" data-toggle="validator"	>
    <p>
    <label>File :</label>
    <input type="file" name="csv_file" id="csv_file" class="csv_file" required >
    </p>
    <p>
    <label>City :</label>
    <select id="location_details" onchange="setDetails(this)" required >
    <option value=''>Select City</option>
    <?php foreach($city as $key=>$val){?>
    <option value='<?php echo json_encode($val); ?>'><?=$val['name'] ?></option>
    <?php } ?>
    </select>
    </p>
    <input type="hidden" name="city_id" id="city_id" value=""  required/>
    <input type="hidden" name="city_name" id="city_name" value="" required />
    <p>
    <input type="submit" value="submit"  class="btn btn-primary" >
    </p>
    </form>
    <hr />
    <div class="note">
    <span style="font-weight:bold"><h2>Doctor With Ids Format</h2></span>
    <span style="font-weight:bold">Note</span>
    <li>Provide .csv file in CSV(Comma delimited) format</li>
    <li>Use this file to refer format of csv sheet needs to be uploaded.</li>
    <li>
    <a href="/bdabdabda/import/download_file?file_name=/uploads/sample_files/col_order_withid_test.csv">
    click here to download sheet format</a>
    </li>
    </div>
    <form name="upload_withid_data" action="/bdabdabda/import/doctor_withids" method="post" enctype="multipart/form-data" data-toggle="validator">
    <p>
    <label>File :</label>
    <input type="file" name="csv_file" id="csv_file" class="csv_file" required >
    </p>
    <p>
    <input type="submit" value="submit" class="btn btn-primary"  >
    </p>
    </form>
    </div>
    <div class="panel-footer">
    <?php $this->load->view('admin/common/footer'); ?>
    </div>
    </div>
    </div>
	</body>
	<?php $this->load->view('admin/common/bottom'); ?>
	<!-- PAGE SPECIFIC JS-->
	<script type="text/javascript" >
    function setDetails(obj){
			var val = JSON.parse(obj.value);
			console.log(val);
			document.getElementById('city_id').value=val.id;
			document.getElementById('city_name').value=val.name;
			
    }
		function validate()
		{
			/*if(document.getElementById("city_id").options.selectedIndex==undefined)
			{
				alert("please select City.");
				return false;	
			}*/
			if(document.getElementsByClassName('csv_file').files.length==0)
			{
				alert("please select File to upload.");
				return false;	
			}
/*			if(document.getElementById('csv_file').files[0].type!=="text/csv")
			{
				alert(document.getElementById('csv_file').files[0].type);
				console.log(document.getElementById('csv_file').files[0]);
				alert("File should be in CSV(Comma delimited) Format");
				return false;	
			}
*/		}
</script>
	<!-- PAGE SPECIFIC JS-->
</html>
