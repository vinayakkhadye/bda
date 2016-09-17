<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Knowlarty Phone Call Records | BDA</title>
<?php $this->load->view('admin/common/head'); ?>
</head>
<body>
<?php $this->load->view('admin/common/header'); ?>
<div class="container-fluid">
<div class="panel panel-default">
<div class="panel-heading">Phone Call Record</div> 
<div class="panel-body">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover">
  <thead>
      <tr>
          <th>id</th>
          <th>Date</th>
          <th>Time</th>
          <th>Caller Number</th>
          <th>Call Status</th>
          <th>Call Duration</th>
          <th>Extension</th>
          <th>Agent Number</th>
          <th>Response</th>
          <th>Recording URL</th>
      </tr>
  </thead>
  <tbody>
  <?php if ($flag) {
  foreach ($flag as $row) { ?>
  <tr>
  <td><?php echo $row->id; ?></td>
  <td><?php echo $row->date; ?></td>
  <td><?php echo ucfirst($row->time); ?></td>
  <td><?php echo ucfirst($row->caller_number); ?></td>
  <td class="center"><?php echo ucfirst($row->call_status); ?></td>
  <td class="center"><?php echo ucfirst($row->call_duraton); ?></td>
  <td class="center"><?php echo ucfirst($row->extension); ?></td>
  <td class="center"><?php echo ucfirst($row->agent_number); ?></td>
  <td class="center"><?php echo ucfirst($row->response); ?></td>
  <td class="center">
		<?php if($row->recording_url=="None"){echo "None";}else{?>
    <audio controls style="width:200px;">
    	<source src="<?=$row->recording_url?>" type="audio/ogg">
      <source src="<?=$row->recording_url?>" type="audio/mpeg">
      Your browser does not support the audio tag.
		</audio>
    <?php }?>
  </td>
  </tr>
  <?php }} ?>
  </tbody>
</table>
</div>
<ul class="pagination"><?php echo $this->pagination->create_links(); ?></ul>
</div>
<div class="panel-footer">
<?php $this->load->view('admin/common/footer'); ?>
</div>
  </div>
</div>
</body>
<?php $this->load->view('admin/common/bottom'); ?>
<script type="application/javascript">

var max_row=0;
var myVar ='';

function max_row_val()
{
$.ajax({
url:        '/bdabdabda/knowlarity/max_call_record',
dataType: "json",
type:       'POST',
success: function(resp){
  max_row = resp.id ;
  myVar=setInterval(function () {final_row(max_row)}, 5000);
}           
});
}
max_row_val();

function final_row(max_row_id) {
if (max_row_id) {
$.ajax({
  url:        '/bdabdabda/knowlarity/new_phone_call_record',
  type:       'POST', 
  cache:      false,
  dataType:   'json',
  data: {  'max_row' : max_row_id }, 
  success: function(resp){             
    console.log(resp);
    if(resp)
    {
    var temp = 0;
    for(i in resp)
    {
      var html = '<tr class="bgred"><td>'+resp[i].id+'</td><td>'+resp[i].date+'</td><td>'+resp[i].time+'</td><td>'+resp[i].caller_number+'</td> <td>'+resp[i].call_status+'</td><td>'+resp[i].call_duraton+'</td><td>'+resp[i].extension+'</td> <td>'+resp[i].agent_number+'</td><td><a href='+resp[i].recording_url+'>Download</a></td></tr>';
      $('#dataTables-example tbody').prepend(html);
      if(!temp)
      {
        temp = resp[i].id;
      }
    }
      max_row = temp;
    }
  }           
});
}
}

</script>
</html>
