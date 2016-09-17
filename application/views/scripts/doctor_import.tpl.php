<form id="upload_data" name="upload_data" action="<?=BASE_URL?>migration/doctor_import" method="post" enctype="multipart/form-data">
<!--    <input type="text" name="file_name" id="file_name" value="" placeholder="CSV File Name" />
	<input type="text" name="log_file_name" id="log_file_name" value="" placeholder="Log File Name" />-->
	
	<input type="file" name="csv_file" id="csv_file" >
    <select id="location_details" onchange="setDetails(this)" >
		<option value='-1'>Select City</option>
        <?php foreach($city as $key=>$val){?>
            <option value='<?php echo json_encode($val); ?>'><?=$val['name'] ?></option>
        <?php } ?>
    </select>
    <input type="hidden" name="city_id" id="city_id" value="" />
	<input type="hidden" name="city_name" id="city_name" value="" />
    <input type="submit" value="submit">
</form>
<script type="text/javascript" >
    function setDetails(obj){
        var val = JSON.parse(obj.value);
        console.log(val);
        document.getElementById('city_id').value=val.id;
		document.getElementById('city_name').value=val.name;

    }
</script>
