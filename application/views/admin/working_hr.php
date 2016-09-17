<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
  	<title>Knowlarity Working Hours | BDA</title>
		<?php $this->load->view('admin/common/head'); ?>
	</head>
	<body>
		<?php $this->load->view('admin/common/header'); ?>
    <div class="container-fluid">
    <div class="panel panel-default">
    <div class="panel-heading">Knwolarit Working Hours</div>
		<div class="panel-body">
		<form id="upload_data" name="upload_data" action="" method="post">
          <div class="form-group">
            <div class="radio">
            	<label><input type="radio" name="working" id="optionsRadios1" value="1" <?=($flag['is_working_hour']==1)?'checked':''?> >Working Hr</label>
            </div>
            <div class="radio">
            	<label><input type="radio" name="working" id="optionsRadios2" value="0" <?=($flag['is_working_hour']==0)?'checked':''?>>Away Hr</label>
            </div>
            <input type="submit" value="submit" class="btn btn-primary"  >
					</div>
          </form>    
    </div>
    <div class="panel-footer">
    <?php $this->load->view('admin/common/footer'); ?>
    </div>
		</div>
		</div>
	</body>
	<?php $this->load->view('admin/common/bottom'); ?>
</html>
