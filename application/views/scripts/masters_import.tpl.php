<form id="upload_data" name="upload_data" action="<?=BASE_URL?>migration/masters_import" method="post" enctype="multipart/form-data">
	Table name : <input type="text" name="table" id="table" >
  <input type="file" name="csv_file" id="csv_file" >
  <input type="submit" value="submit">
</form>