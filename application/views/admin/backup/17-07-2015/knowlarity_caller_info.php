<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Knowlarty Call Informaion | BDA</title>
<?php $this->load->view('admin/common/head'); ?>
</head>
<body>
<?php $this->load->view('admin/common/header'); ?>
<div class="container-fluid">
<div class="panel panel-default">
<div class="panel-heading">Caller Info</div> 
<div class="panel-body">
<table class="table table-striped table-bordered table-hover">
  <thead>
      <tr>
          <th>Id</th>
          <th>Caller Number</th>
          <th>Agent Number</th>
          <th>Extension</th> 
          <th>Last Call Time</th> 
      </tr>
  </thead>
  <tbody>
		<?php if ($flag) {
    foreach ($flag as $row) { ?>
    <tr>
    <td><?php echo $row->id; ?></td>
    <td><?php echo $row->caller_number; ?></td>
    <td><?php echo ucfirst($row->agent_number); ?></td>
    <td><?php if($row->extension == 1){echo "Patient";}elseif ($row->extension == 2) {echo "Doctors";}else{echo "Others";}?></td>
    <td class="center"><?php echo ucfirst($row->last_call_time); ?></a></td>
    </tr>
    <?php }} ?>
  </tbody>
</table>
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
url:        '/bdabdabda/knowlarity/max_caller_info',
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
url:        '/bdabdabda/knowlarity/new_caller_info',
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
    var ext ='';
    if(resp[i].extension == 1)
              {
              ext= "Patient";
              }
            else if(resp[i].extension == 1)
               {
                ext =  "Doctors";
               }
            else{
                ext = "Others";
                }
    var html = '<tr class="bgred"><td>'+resp[i].id+'</td><td>'+resp[i].caller_number+'</td><td>'+resp[i].agent_number+'</td> <td>'+ext+'</td> <td>'+resp[i].last_call_time+'</td></tr>';
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
