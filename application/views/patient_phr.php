<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Book Dr Appointment</title>
	<link id="bs-css" href="<?php echo CSS_URL; ?>login/jquery-ui-new.css" rel="stylesheet">
	<link href="<?php echo CSS_URL; ?>login/maine.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>login/style.css" />
	<link type="text/css" rel="stylesheet" href="<?php echo CSS_URL; ?>login/bootstrap.min.css"/>
	<style type="text/css">
	.PB10 {padding-bottom:20px;}
	/*this is just to organize the demo checkboxes*/
	label
	{
	margin-right: 20px;
	}
	.continue_bnt {cursor:pointer}
	.modalbpopup 
	{
	background-color: #fff;
	border-radius: 15px;
	box-shadow: 0 0 7px 1px #999;
	min-height: 400px;
	padding: 15px;
	min-width: 500px;
	}
	.from_text4-org_1{
		cursor: pointer;
	}
	.imageBox
	{
	position: relative;
	height: 400px;
	width: 400px;
	border:1px solid #aaa;
	background: #fff;
	overflow: hidden;
	background-repeat: no-repeat;
	cursor:move;
	}
	
	.imageBox .thumbBox
	{
	position: absolute;
	top: 50%;
	left: 50%;
	width: 126px;
	height: 152px;
	margin-top: -76px;
	margin-left: -63px;
	border: 1px solid rgb(102, 102, 102);
	box-shadow: 0 0 0 1000px rgba(0, 0, 0, 0.5);
	background: none repeat scroll 0% 0% transparent;
	}
	
	.imageBox .spinner
	{
	position: absolute;
	top: 0;
	left: 0;
	bottom: 0;
	right: 0;
	text-align: center;
	line-height: 400px;
	background: rgba(0,0,0,0.7);
	}
	</style>
    <style type="text/css">
    .FL{float:left;}
	.MR10{margin-right:10px;}
	.ML10{margin-left:10px;}
	#report_more{
		clear:both;
	}
	.report_more{
		padding-top:10px;
		padding-left:30px;
	}


	.report_txt{
		background-color: #fff;
		border-color: #d4d4d4;
		border-style: solid;
		border-width: 1px;
		height: 31px;
	}
	.report_file{
		background-color: #fff;
		border-color: #d4d4d4;
		height: 31px;
		width:100px;
		opacity: 0;
		position: relative;
		z-index: 2;		
	}

.btn-primary {
    background-color: #428bca;
    border-color: #357ebd;
    color: #fff;
	position: relative; 
	top: -32px;
}
.btn {
    -moz-user-select: none;
    border: 1px solid transparent;
    border-radius: 4px;
    cursor: pointer;
    display: inline-block;
    font-size: 14px;
    font-weight: normal;
    line-height: 1.42857;
    margin-bottom: 0;
    padding: 6px 12px;
    text-align: center;
    vertical-align: middle;
    white-space: nowrap;
}	
	
    </style>
    
	<script src="<?php echo JS_URL; ?>login/jquery.min.js"></script>
	<script src="<?php echo JS_URL; ?>login/jquery-ui-new.js"></script>
	<script src="<?php echo JS_URL; ?>login/jquery-cropimg-plugin.js"></script>
	<script src="<?php echo JS_URL; ?>jquery.bpopup.min.js"></script>
	<script type="text/javascript">
	function calculatebmi_old()
	{
		var height_feet = $("#height_feet").val();
		var height_inches =  parseInt($("#height_inches").val());
		var weight =  parseInt($("#weight").val());
		var feet = parseFloat(height_feet+"."+height_inches);
		var meter = (feet/3.28).toFixed(2);
		var bmi = (weight / (meter * meter)).toFixed(2);
		$("#bmi_value").val(bmi);
	}
	function calculatebmi()
	{
		var height_feet = parseInt($("#height_feet").val());
		var height_inches =  parseInt($("#height_inches").val());
		var weight =  parseInt($("#weight").val());
		if(height_feet && weight ){
			if(isNaN(height_inches)){
				height_inches = 0;
			}
			var total_inches = (height_feet*12)+height_inches;
			
			var meter = (total_inches/39.370);
			var bmi = (weight / (meter * meter)).toFixed(2);
			$("#bmi_value").val(bmi);
		}
	}

	function hide_steps()
	{
	$("#general_info_table").hide();
	$("#family_history_table").hide();
	$("#past_disease_table").hide();
	$("#reports_table").hide();
	$(".general_info_step").attr("id","circle2");
	$(".famili_history_step").attr("id","circle2");
	$(".past_disease_step").attr("id","circle2");
	$(".reports_step").attr("id","circle2");
	}
	function remove_tr(obj,type='',id='')
	{
		if(confirm("Are you sure you want to permenantly delete this entry"))
		{
			if(type && id){
				if(!isNaN(id)){
					var form_data = {"type":type,"id":id};
					$.ajax({
						type: 'POST',
						url: "<?=BASE_URL?>patient/patient_delete_bytype",
						data: form_data,
						success: function(data)
						{
							console.log($(obj).closest( "div" ).remove());
						},
						error:function(data)
						{
							console.log("oops");
						}
					});
				}
			}else{
				$( obj ).closest( "tr" ).remove()
			}
		}
	}
function report_more(obj)
	{
    //console.log(obj);
		var curTR = $(obj).closest('div');
    //console.log(curTR);
    //return false;
		newTR = $("#report_tocopy").clone();
		console.log(newTR);
		//sepTR = $("#separator").clone();
		newTR.insertAfter(curTR);
		newTR.show();
		newTR.attr("id","report_more");
		
		var mem0 = newTR.find("#report_category_copy");	
		mem0.attr("name","report_category["+(parseInt(mem0.attr("dataid"))+1)+"]");
		$("#report_tocopy").find("#report_category_copy").attr("dataid",parseInt(mem0.attr("dataid"))+1);

		var mem1 = newTR.find("#report_date_copy");	
		mem1.attr("name","report_date["+(parseInt(mem1.attr("dataid"))+1)+"]");
		$("#report_tocopy").find("#report_date_copy").attr("dataid",parseInt(mem1.attr("dataid"))+1);
		mem1.datepicker(
		{
			dateFormat: "dd-mm-yy",
			defaultDate: "-25y",
			changeMonth: true,
			changeYear: true,
			yearRange: "1900:2014"
		});

		var mem2 = newTR.find("#report_reason_copy");	
		mem2.attr("name","report_reason["+(parseInt(mem2.attr("dataid"))+1)+"]");
		$("#report_tocopy").find("#report_reason_copy").attr("dataid",parseInt(mem2.attr("dataid"))+1);

		var mem3 = newTR.find("#report_attachment_copy");	
		mem3.attr("name","report_attachment_"+(parseInt(mem3.attr("dataid"))+1)+"");
		$("#report_tocopy").find("#report_attachment_copy").attr("dataid",parseInt(mem3.attr("dataid"))+1);


		$(obj).hide();
		$(curTR).children().find('#report_details_remove').show();
	}		
	$(document).ready(function(){
	$("#select_file_btn").click(function(){
	$(".modalbpopup").bPopup({
	positionStyle: 'fixed',
	closeClass: 'modalclose'
	});
	$("#file").trigger('click');
	});
	});
	</script>
</head>
<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="pricetable">
<?php $this->load->view('headertop_patient'); ?>
<tr>
<td>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td bgcolor="#229B96" class="top_bg2">
				<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="pricetableCopy">
					<tr>
						<td width="135" height="41">&nbsp;
						</td>
						<td width="35" align="center">
							<a href="/">
								<img src="<?php echo IMAGE_URL; ?>home_icon.jpg" width="23" height="23" />
							</a>
						</td>
						<td width="44" valign="bottom">
							<img src="<?php echo IMAGE_URL; ?>devaiter.jpg" width="44" height="40" />
						</td>
						<td class="text">
							Dashboard
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</td>
</tr>
<tr>
<td valign="top" bgcolor="#f1f2e3">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<?php $this->load->view('patient_sidebar'); ?>
			<td width="53" valign="top">&nbsp;</td>
			<td align="center" valign="top">
				<form name="patient_save" id="patient_save" method="post" enctype="multipart/form-data">
					<input type="hidden" name="patient_id" value="<?=$patient_id?>"/>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr><td height="50">&nbsp;</td></tr>
						<tr>
							<td class="maine_from" id="maine_from">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td height="45" bgcolor="#3dc4bf">
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr>
													<td height="45" class="from_page_tetel">
														Personal Health Reports
													</td>
													<td>&nbsp;
														
													</td>
													<td width="150" align="center" class="text">&nbsp;
														
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr id="reports_table">
										<td bgcolor="#FFFFFF">
											<table width="100%" border="0" cellspacing="0" cellpadding="0" >
											  <tr>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
											  </tr>

											  <?php if(isset($reports) && is_array($reports) && sizeof($reports)>0){?>
                                                <tr>
                                                <td colspan="4">
												  <?php foreach($reports as $rKey=>$rVal){?>
                                                    <div id="report_more">
                                                        <span class="FL">
                                                        	<input name="report_detail_id[<?=$rKey?>]" type="hidden" value="<?=$rVal->id?>" />
                                                        	<select id="report_category" name="report_category[<?=$rKey?>]" class="ML10 MR10 from_list_menu2">
                                                                    <option value="">Category </option>
                                                                    <?php foreach($report_categories as $rcVal){?>
                                                                    	<option value="<?=$rcVal ?>" <?=($rVal->category==$rcVal)?'selected="selected"':''?> >
																		<?=$rcVal ?>
                                                                        </option>
                                                                    <?php } ?>
															</select>
														</span>
                                                        <span class="FL">
                                                        	<input class="MR10 report_txt" type="text" id="report_date" name="report_date[<?=$rKey?>]" 
                                                            placeholder="Date" value="<?=$rVal->date?>">
														</span>
                                                        <span class="FL">
                                                        	<input class="MR10 report_txt" type="text" id="report_reason" name="report_reason[<?=$rKey?>]" 
                                                            placeholder="Note.. " value="<?=$rVal->reason?>">
														</span>
                                                        <span class="FL" style="height:44px;">
                                                        	<input class="report_file MR10 " type="file" name="report_attachment_<?=$rKey?>" 
                                                            id="report_attachment">
                                                            <div class="btn btn-primary">Select File</div>
                                                        </span>
                                                        <span class="FL">
															<?php if($rKey==$reports_count || $reports_count==0){ ?>
                                                                <img id="report_details_more" src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" 
                                                                onclick="report_more(this);" style="float:left" />
                                                                <span class="from_text4-org_1" id="report_details_remove" style="display:none;float:left"  
                                                                onclick="remove_tr(this,'report_detail','<?=$rVal->id?>');">&nbsp;Remove</span>
                                                            <?php }else{?>
                                                                <span id="report_details_remove"  onclick="remove_tr(this,'report_detail','<?=$rVal->id?>');" 
                                                                class="from_text4-org_1" style="float:left">&nbsp;Remove</span>
                                                            <?php }?>
                                                        </span>
                                                        <span class="ML10"><?=$rVal->attachment?></span>
                                                    </div>
                                                  <?php } ?>
                                                   </td>
                                                </tr>
											  <?php }else{ ?>
                                                <tr>
    	                                            <td colspan="4">
                                                    <div class="report_more">
                                                        <span class="FL">
                                                        	<select id="report_category" name="report_category[0]" class="ML10 MR10 from_list_menu2">
                                                                    <option value="">Category </option>
                                                                    <option value="Prescription">Prescription</option>
                                                                    <option value="Lab Report">Lab Report</option>
                                                                    <option value="Allergy">Allergy</option>
                                                                    <option value="gkhk">Immunization</option>
                                                                    <option value="Surgery">Surgery</option>
															</select>
														</span>
                                                        <span class="FL">
                                                        	<input class="MR10 report_txt" type="text" id="report_date" name="report_date[0]" 
                                                            placeholder="Date">
														</span>
                                                        <span class="FL">
                                                        	<input class="MR10 report_txt" type="text" id="report_reason" name="report_reason[0]" 
                                                            placeholder="Note.. ">
														</span>
                                                        <span class="FL" style="height:44px;">
                                                        	<input class="report_file MR10" type="file" name="report_attachment_0" id="report_attachment">
                                                            <div class="btn btn-primary">Select File</div>
                                                        </span>
                                                        <span>
                                                        	<img id="report_details_more" src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" 
                                                            onclick="report_more(this);"  style="float:left" />
                                                        	<span id="report_details_remove" style="display:none;float:left" 
                                                            onclick="remove_tr(this);" class="from_text4-org_1" >&nbsp;Remove</span>                                                        </span>
                                                    </div>
	                                                </td>
                                                </tr>
											  <?php }?>
                                              
											  <tr>
													<td align="right">&nbsp;</td>
													<td>&nbsp;</td>
													<td>&nbsp;</td>
													<td>&nbsp;</td>
												</tr>
											  <tr id="separator" style="display:none">
												<td colspan="4"><hr></td>
											  </tr>
                                              <tr>
													<td colspan="5" height="53" align="right" bgcolor="#f5f5f5">

                                                    <input class="continue_bnt" style="padding-right:45px;float:right;margin-right:10px;"  type="submit" value="submit" />
                                                    
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr><td>&nbsp;</td></tr>
						<tr><td>&nbsp;</td></tr>
					</table>
				</form>
			</td>
		</tr>
	</table>
</td>
</tr>
<tr>
<td height="35" align="center" valign="middle" bgcolor="#033f44" class="text">
	2014 BookdrAppointment.com, All rights reserved
</td>
</tr>
</table>
<div id="report_tocopy" style="display:none">
    <span class="FL">
        <select id="report_category_copy" name="report_category[<?=$reports_count?>]" class="ML10 MR10 from_list_menu2" dataid="<?=$reports_count?>">
            <option value="">Category </option>
            <?php foreach($report_categories as $rcVal){?>
	            <option value="<?=$rcVal ?>"><?=$rcVal ?></option>
            <?php } ?>
        </select>
    </span>
    <span class="FL">
        <input class="MR10 report_txt" type="text" id="report_date_copy" placeholder="Date" name="report_date[<?=$reports_count?>]" 
        dataid="<?=$reports_count?>" >
    </span>
    <span class="FL">
        <input class="MR10 report_txt" type="text" id="report_reason_copy" name="report_reason[<?=$reports_count?>]" 
        placeholder="Note.. " dataid="<?=$reports_count?>">
    </span>
    <span class="FL" style="height:44px;">
        <input class="report_file MR10" type="file" name="report_attachment_<?=$reports_count?>" id="report_attachment_copy" 
        dataid="<?=$reports_count?>">
        <div class="btn btn-primary">Select File</div>
    </span>
    <span>
        <img id="report_details_more" src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" 
        onclick="report_more(this);"  style="float:left" />
        <span id="report_details_remove" style="display:none;float:left" 
        onclick="remove_tr(this);" class="from_text4-org_1" >&nbsp;Remove</span>
    </span>
</div>
<div class="modalbpopup" style="display: none;">
<div class="container">
	<div class="imageBox">
		<div class="thumbBox"></div>
		<div class="spinner" style="display: none">Loading...</div>
	</div>
	<div class="action">
		<input type="file" id="file" style="float:left; width: 250px">
		<input type="button" id="btnCrop" value="Crop" style="float: right; width: 75px; margin:5px 40px 5px 5px;" class="modalclose">
		<input type="button" id="btnZoomIn" value="+" style="float: right; width: 25px; margin:5px 2px;">
		<input type="button" id="btnZoomOut" value="-" style="float: right; width: 25px; margin:5px 2px;">
	</div>
	<div class="cropped"></div>
</div>
</div>
<script type="text/javascript">
$(window).load(function()
{
$("#dob").datepicker(
{
	dateFormat: "dd-mm-yy",
	defaultDate: "-25y",
	changeMonth: true,
	changeYear: true,
	yearRange: "1900:2014"
});
$("#surgery_date").datepicker(
{
	dateFormat: "dd-mm-yy",

	defaultDate: "-25y",
	changeMonth: true,
	changeYear: true,
	yearRange: "1900:2014"
});
$("#report_date").datepicker(
{
	dateFormat: "dd-mm-yy",

	defaultDate: "-25y",
	changeMonth: true,
	changeYear: true,
	yearRange: "1900:2014"
});

var options =
{
thumbBox: '.thumbBox',
spinner: '.spinner',
imgSrc: 'avatar.png'
}
var cropper;
$('#file').on('change', function()
{
	var reader = new FileReader();
	reader.onload = function(e)
	{
		options.imgSrc = e.target.result;
		//cropper = $('.imageBox').cropbox(options);
	}
	reader.readAsDataURL(this.files[0]);
	this.files = [];
})
$('#btnCrop').on('click', function()
{
	var img = cropper.getDataURL()
	//$('.cropped').append('<img src="'+img+'">');
	$('#profileimgbox').html('<img src="'+img+'">');

	//alert($('#file').val());
	var imgtype= img.substr(0, img.indexOf(','));
	//alert(imgtype);
	var base64imgvalue= img.substr(img.indexOf(',')+1, 999999999);
	//console.log(base64imgvalue);
	$('#profile_pic_base64').val(base64imgvalue);
	$('#profile_pic_base64_name').val($('#file').val());
})
$('#btnZoomIn').on('click', function()
{
	cropper.zoomIn();
})
$('#btnZoomOut').on('click', function()
{
	cropper.zoomOut();
})
});
</script>
</body>
</html>