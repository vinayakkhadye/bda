<div style="padding-top:15px;" class="tab-content">    
<div role="tabpanel" class="tab-pane" id="familyhistory">
<div class="panel panel-default">
<div class="panel-heading">Family Disease History</div>    
<div  id="family_disease" class="panel-body">    
        <?php $fKey	=	0;
if(isset($family_details) && is_array($family_details) && sizeof($family_details)>0){   
foreach($family_details as $fKey=>$fVal){
$member_name = explode("#&#",$fVal->member_name);?>
<div class="row"> <div class="col-sm-12">            
<div class="form-group form-inline">
<label class="control-label">Disease Name</label>
<input type="text" class="form-control" value="<?=$fVal->disease?>" readonly/>
<div class="checkbox">
<label><input readonly type="checkbox" <?=(in_array(0,$member_name))?'checked="checked"':''?> />&nbsp;Father</label></div>
<div class="checkbox">
<label><input readonly type="checkbox" <?=(in_array(1,$member_name))?'checked="checked"':''?> />&nbsp;Mother</label></div>
<div class="checkbox">
<label><input readonly type="checkbox" <?=(in_array(2,$member_name))?'checked="checked"':''?> />
&nbsp;Sibling</label></div>
</div>
<div class="form-group">
<label class="control-label">Description</label>
<textarea cols="45" rows="2" class="form-control" placeholder="Additional Information" readonly><?=$fVal->summary?></textarea> 
</div>
<button class="btn btn-danger glyphicon glyphicon-minus" id="family_delete_details" db-id="<?=$fVal->id?>" onclick="removeelement(this);" 
title="delete" > Remove</button>
</div></div>
<div class="row"><hr></div>
<?php }$fKey++;}?>
</div></div>
<div class="panel panel-default">
<div class="panel-heading"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Family Disease</div>    
<div class="panel-body">    
<div class="form-group form-inline">
	<label for="family_detail_disease" class="control-label">Disease Name</label>
	<input type="text" class="form-control" id="family_detail_disease" />
	<div class="checkbox"><label><input type="checkbox" id="family_detail_mem1" />&nbsp;Father</label></div>
	<div class="checkbox"><label><input type="checkbox" id="family_detail_mem2"/>&nbsp;Mother</label></div>
	<div class="checkbox"><label><input type="checkbox" id="family_detail_mem3"/>&nbsp;Sibling</label></div>
</div>
<div class="form-group">
	<label for="additional_info" class="control-label">Description</label>
	<textarea cols="45" rows="2" class="form-control" id="additional_info" placeholder="Additional Information"></textarea> 
</div>
	<button class="btn btn-success glyphicon glyphicon-plus" id="family_details" onclick="return addelement(this);"> Save</button>
</div></div></div>

<div role="tabpanel" class="tab-pane" id="selfhistory">
<div class="panel panel-default">
<div class="panel-heading">Past Disease</div>    
<div  id="self_disease" class="panel-body">    
<?php if(isset($past_disease) && is_array($past_disease) && sizeof($past_disease)>0){
foreach($past_disease as $dKey=>$dVal){?>
<div id="" class="row"> <div class="col-sm-12">    
<div class="form-group">
  <label class="control-label">Disease Name</label>
  <input type="text" class="form-control" id="disease_name" value="<?=$dVal->disease_name ?>" readonly />
</div>
<div class="form-group form-inline">
  <label class="control-label">Incidence</label>
  <input type="text" class="form-control" value="<?=$month[$dVal->disease_from_month]?>" readonly/>
  <input type="text" class="form-control" value="<?=$dVal->disease_from_year?>" readonly/> Duration Months 
  <input type="text"  class="form-control" id="disease_duration" value="<?=$dVal->disease_duration ?>" readonly placeholder="Duration"/>
</div>     
<!--<div class="form-group">
  <label class="control-label">Duration</label>
  <input type="text"  class="form-control" id="disease_duration" value="<?=$dVal->disease_duration ?>" readonly />
</div>-->
<div class="form-group">
  <label class="control-label">Details</label>
  <textarea class="form-control" rows="2" cols="45" id="disease_details" readonly><?=$dVal->disease_details ?></textarea>
</div>
  <button class="btn btn-danger glyphicon glyphicon-minus" id="past_disease_delete" db-id="<?=$dVal->id ?>" onclick="return removeelement(this);"> Remove</button>    
   </div> </div><div class="row"><hr></div>    

<?php }}?>
</div></div>
<div class="panel panel-default">
<div class="panel-heading"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Disease</div>    
<div class="panel-body">
    
<div class="form-group">
<label class="control-label">Disease Name</label>
<input type="text" class="form-control" id="disease_name">
</div>
<div class="form-group form-inline">
	<label class="control-label">Incidence</label>
  <input type="text" class="form-control autocomplete-from-month" id="disease_from_month_label" placeholder="Ex. January"  /> Month
  <input type="hidden"  id="disease_from_month" />
  <input type="text" class="form-control autocomplete-from-year" placeholder="Year of onslaught"id="disease_from_year"/> Year
  <input type="text"  class="form-control" id="disease_duration" placeholder="Duration"/> in Months
</div>     
<div class="form-group">
	<label class="control-label">Details</label>
	<textarea class="form-control" rows="2" cols="45" id="disease_details"></textarea>	
</div>
<button class="btn btn-success glyphicon glyphicon-plus" id="past_disease" onclick="return addelement(this);"> Add</button>    
</div></div>    
</div>

<div role="tabpanel" class="tab-pane" id="surgicalhistory">
<div class="panel panel-default">
<div class="panel-heading"><span class="glyphicon" aria-hidden="true"></span>Past Surgeries</div>    
<div id="past_surgeries" class="panel-body">      
<?php if(isset($past_surgery) && is_array($past_surgery) && sizeof($past_surgery)>0){
foreach($past_surgery as $dKey=>$dVal){?>
<div class="form-group form-inline">    
<label class="control-label">Surgery</label>
<input type="text" class="form-control" value="<?=$dVal->surgery_name?>" readonly />
<input type="text" class="form-control" value="<?=$dVal->reason?>" readonly />
<input type="text" class="form-control" value="<?=$dVal->surgery_date?>" readonly />
<button class="btn btn-danger glyphicon glyphicon-minus" id="past_surgery_delete" db-id="<?=$dVal->id ?>" onclick="return removeelement(this);"></button>
</div>
<?php } }?>
</div></div>    
    <div class="panel panel-default">
<div class="panel-heading"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Past Surgeries</div>    
<div class="panel-body">  
<div class="form-inline">    
<div class="form-group">
<label class="control-label">Surgery</label>
<input type="text" class="form-control" id="surgery_name" Placeholder="Name of Surgery"/>
</div>
<div class="form-group">
<!--<label class="control-label">Reason</label>-->
<input type="text" class="form-control" id="surgery_reason" placeholder="Reason">
</div>
<div class="form-group">
<!--<label class="control-label">Date</label>-->
<input type="text" id="surgery_date" placeholder="Date Of Surgery" class="form-control">
<button class="btn btn-success glyphicon glyphicon-plus" id="past_surgery" onclick="return addelement(this);"></button>
</div></div></div></div>
</div>
<div role="tabpanel" class="tab-pane" id="allergies">
<div class="panel panel-default">
<div class="panel-heading">Allergies</div>    
<div id="allergies_list" class="panel-body">    
<?php if(isset($allergic) && is_array($allergic) && sizeof($allergic)>0){
foreach($allergic as $dKey=>$dVal){?>
<div class="form-group form-inline">
<label class="control-label">Allergy Type</label>
<input type="text" class="form-control" value="<?=$allergy[$dVal->allery_type]?>" readonly />
<label class="control-label">Specify</label>
<input type="text" class="form-control" value="<?=$dVal->allergic?>" readonly/>
<button class="btn btn-danger glyphicon glyphicon-minus" id="allergy_detail_delete" db-id="<?=$dVal->id ?>" onclick="return removeelement(this);"></button>
</div>
<?php }}?>
</div></div>
<div class="panel panel-default">
<div class="panel-heading"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Allergies</div>    
<div class="panel-body">     
<div class="form-inline">
<div class="form-group">
<label class="control-label">Allergy Type</label>
<input type="text" id="allery_type_label" class="form-control autocomplete-allery" />
<input type="hidden" id="allery_type" />
</div>
 <div class="form-group">
<label class="control-label">Specify</label>
<input type="text" class="form-control" id="allergic" />
 </div>
<button class="btn btn-success glyphicon glyphicon-plus" id="allergy_detail" onclick="return addelement(this);"></button>
</div></div></div>
</div>
    
<div role="tabpanel" class="tab-pane active" id="medications">
<div class="panel panel-default">
<div class="panel-heading">Ongoing Medications</div>    
<div class="panel-body">
<div id="ongoingmeds_list" class="row">
<?php if(isset($medication) && is_array($medication) && sizeof($medication)>0){
{?><?php }    
foreach($medication as $dKey=>$dVal){?>
         <div class="col-sm-6 col-lg-6 col-md-6 col-xs-10 form-group form-inline">
<!--<label class="control-label"></label>-->
<input type="text" class="form-control" value="<?=$dVal->medication?>" readonly />
<button class="btn btn-danger glyphicon glyphicon-minus" id="medication_delete" db-id="<?=$dVal->id ?>" onclick="return removeelement(this);"></button>
            </div>
<!--<div class="form-group"></div> -->
    <?php }}?>
</div></div></div>
<div class="panel panel-default">
<div class="panel-heading"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Ongoing Medications</div>    
<div class="panel-body">       
<div class="form-group form-inline">
<!--<label for="medication" class="control-label">Ongoing Meditation</label>-->
<input type="text" class="form-control" id="medication" />
<button class="btn btn-success glyphicon glyphicon-plus" id="medication_detail" onclick="return addelement(this);"></button>
</div>
</div>
</div>
</div>
</div>
<script type="application/javascript">
var allery=	[{"label":"Food Allergy","id":"1"},{"label":"Durg Allergy","id":"2"},{"label":"Environmental Allergy","id":"3"},{"label":"Animal Allergy","id":"4"}];

$( ".autocomplete-allery" ).autocomplete({
	source: allery,
	select: function( event, ui ) {
		$("#allery_type").attr("value", ui.item.id)
	},
	minLength: 0
}).focus(function() {
    $(this).autocomplete("search", $(this).val());
});	

var year=	["2015","2014","2013","2012","2011","2010","2009","2008","2007","2006","2005","2004","2003"];
$( ".autocomplete-from-year" ).autocomplete({
	source: year,
	minLength: 0
}).focus(function() {
    $(this).autocomplete("search", $(this).val());
});	
var month=	[{"label":"January","id":"1"},{"label":"February","id":"2"},{"label":"March","id":"3"},{"label":"April","id":"4"},{"label":"May","id":"5"},{"label":"June","id":"6"},{"label":"Jully","id":"7"},{"label":"August","id":"8"},{"label":"September","id":"9"},{"label":"October","id":"10"},{"label":"Novemeber","id":"11"},{"label":"December","id":"12"}];
$( ".autocomplete-from-month" ).autocomplete({
	source: month,
	select: function( event, ui ) {
		$("#disease_from_month").attr("value", ui.item.id)
	},
	minLength: 0
}).focus(function() {
    $(this).autocomplete("search", $(this).val());
});	
$("#surgery_date").datetimepicker({
	timepicker:false,
	format:'m-d-Y'
});

</script>
<script>
$('#historytabs a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
})
</script>