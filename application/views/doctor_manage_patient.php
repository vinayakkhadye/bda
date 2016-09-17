<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Book Dr Appointment</title>
<script src="<?php echo JS_URL; ?>login/jquery.min.js"></script>
<script src="<?php echo JS_URL; ?>login/jquery-ui-new.js"></script>
<link id="bs-css" href="<?php echo CSS_URL; ?>login/jquery-ui-new.css" rel="stylesheet">
<link href="<?php echo CSS_URL; ?>login/maine.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>login/style.css" />
<link type="text/css" rel="stylesheet" href="<?php echo CSS_URL; ?>login/bootstrap.min.css"/>
<style type="text/css">
    /*this is just to organize the demo checkboxes*/
    label
    {
        margin-right: 20px;
    }
    .from_text4
    {
        font-size: 18px;
    }
</style>
<script type="text/javascript">
    function delete_patient(id){
        if(confirm("are you sure you want to delete this patient")){
            $.get("<?=BASE_URL?>doctor/patient_delete/"+id,{
                },function(data){
                    $("#patient_"+id).hide('slow');
                    $("#patient_"+id).remove();
                });
        }
    }
</script>
<style type="text/css">
    .pagination > a {
        background-color: #ff7648;
        color: #900;
        font-family: Verdana,Geneva,sans-serif;
        font-size: 16px;
        line-height: 20px;
        margin-left: 2px;
        padding-left: 5px;
        padding-right: 5px;
    }
</style>
<script>
    $(document).ready(function()
        {
            $(".delete-clinic-btn").click(function()
                {
                    var a = confirm('Are you sure you want to delete this clinic/hospital?');
                    if(a == true)
                    {
                        var clinic = this.id;
                        var clinicid = clinic.substr(6);
                        $.ajax(
                            {
                                url : '/doctor/deleteclinic/'+clinicid,
                                success: function(resp)
                                {
                                    $(location).attr('href','/doctor/manageclinic');
                                }
                            });
                    }
                });
        });

</script>
</head>
<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="pricetable">
    <?php $this->load->view('headertopfull1'); ?>
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
                    <?php $this->load->view('doctor_sidebar'); ?>
                    <td width="53" valign="top">&nbsp;
                        



                    </td>
                    <td align="center" valign="top">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td height="50">&nbsp;
                                    
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" class="maine_from">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td height="45" bgcolor="#3dc4bf">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td colspan="3" height="45" class="from_page_tetel">
                                                            Manage  Your Patient Details
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="5" bgcolor="#F6F6F6">&nbsp;
                                                

                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="23" align="center">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td colspan="6" height="25" class="from_text5">
                                                            <form method="get" action="<?=BASE_URL."doctor/patient_manage" ?>">
                                                                Search :
                                                                <select name="clinic_id">
                                                                    <option value="">
                                                                        select clinic
                                                                    </option>
                                                                    <?php
                                                                    foreach ($clinics as $ckey=>$cval) {
                                                                        ?>
                                                                        <option value="<?=$cval['id'] ?>"
                                                                                    <?=((isset($get_clinic_id) && $get_clinic_id == $cval['id'])?'selected':''  ) ?>
                                                                                    >
                                                                            <?=$cval['name'] ?>
                                                                        </option>
                                                                        <?php
                                                                    }?>
                                                                </select>
                                                                <input type="text" placeholder="Patient name" name="patient_name" value="<?=isset($get_patient_name)?$get_patient_name:'' ?>" />

                                                                <input type="submit" value="search" />
                                                            </form>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td colspan="6" height="25" class="from_text5">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="350" height="25" align="center" class="from_text5">
                                                            Patient's Name
                                                        </td>
                                                        <td width="129" align="center" class="from_text5">
                                                            Mobile  No.
                                                        </td>
                                                        <td width="410" align="center" class="from_text5">
                                                            Clinic Name
                                                        </td>
                                                        <td width="140" align="center" class="from_text5">
                                                            Added Date
                                                        </td>
                                                        <td width="294" align="center" class="from_text5">
                                                            Actions<br />
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    if (is_array($patient_data) && sizeof($patient_data) > 0) {
                                                        foreach ($patient_data as $key=>$val) {
                        /*if(isset($clinics[$val['clinic_id']])){*/
                                                            ?>
                                                            <tr id="patient_<?=$val['id']?>">
                                                                <td width="350" height="35" align="center" bgcolor="#ececec" class="from_text4">
                                                                    <?=$val['name'] ?>
                                                                </td>
                                                                <td width="129" height="35" align="center" bgcolor="#ececec" class="from_text4">
                                                                    <?=$val['mobile_number'] ?>
                                                                </td>
                                                                <td width="410" height="35" align="center" bgcolor="#ececec" class="from_text4">
                                                                    <?=isset($clinics[$val['clinic_id']]['name'])?$clinics[$val['clinic_id']]['name']:'' ?>
                                                                </td>
                                                                <td width="140" height="35" align="center" bgcolor="#ececec" class="from_text4">
                                                                    <?=date("Y-m-d H:i",strtotime($val['created_on'])) ?>
                                                                </td>
                                                                <td width="294" height="35" align="center" bgcolor="#ececec">
                                                                    <a href="<?=BASE_URL?>doctor/patient_save/<?=$val['id']?>">
                                                                        <img src="<?=IMAGE_URL?>Edit.png" width="96" height="32" />
                                                                    </a>
                                                                    <!--<img src="<?=IMAGE_URL?>Delete.png" width="96" height="32" onclick="delete_patient(<?=$val['id']?>)" style="cursor:pointer" />-->
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        /*}*/
                        }
                                                    }?>
                                                    <tr>
                                                        <td class="from_text4-red" align="right" colspan="6" style="font-size:1.4em"> <!--pagination-->
                                                            <?php

                                                            if (isset($pagination['sPage']['url'])) {
                                                                ?>
                                                                <a href="<?=$pagination['sPage']['url'] ?>">
                                                                    first
                                                                </a>
                                                                <?php
                                                            } ?>
                                                            <?php
                                                            if (isset($pagination['prePage']['url'])) {
                                                                ?>
                                                                <a href="<?=$pagination['prePage']['url'] ?>">
                                                                    previous
                                                                </a>
                                                                <?php
                                                            } ?>
                                                            <?php
                                                            if (isset($pagination['page']) && is_array($pagination['page']) && sizeof($pagination['page']) > 0) {
                                                                foreach ($pagination['page'] as $pkey=>$pval) {
                                                                    ?>
                                                                    <a href="<?=$pval['url'] ?>">
                                                                        <?=$pkey ?>
                                                                    </a>
                                                                    <?php
                                                                }
                                                            }?>
                                                            <?php
                                                            if (isset($pagination['nextPage']['url'])) {
                                                                ?>
                                                                <a href="<?=$pagination['nextPage']['url'] ?>">
                                                                    next
                                                                </a>
                                                                <?php
                                                            } ?>
                                                            <?php
                                                            if (isset($pagination['lPage']['url'])) {
                                                                ?>
                                                                <a href="<?=$pagination['lPage']['url'] ?>">
                                                                    last
                                                                </a>
                                                                <?php
                                                            } ?>

                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="53" align="right" bgcolor="#f5f5f5">
                                                &nbsp;&nbsp;&nbsp;
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;
                                    

                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;
                                    

                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width="53" valign="top">&nbsp;
                        



                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td height="35" align="center" valign="middle" bgcolor="#033f44" class="text">
            � 2014 BookdrAppointment.com, All rights reserved�
        </td>
    </tr>
</table>
</body>
</html>