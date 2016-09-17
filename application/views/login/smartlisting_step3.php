<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php $this->load->view('login/common/head'); ?>
</head>
<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="pricetable">
<?php $this->load->view('login/common/doctor_header'); ?>
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
                <a href="/"><img src="<?php echo IMAGE_URL; ?>home_icon.jpg" width="23" height="23" /></a>
              </td>
              <td width="44" valign="bottom">
                <img src="<?php echo IMAGE_URL; ?>devaiter.jpg" width="44" height="40" />
              </td>
              <td class="text">
                Edit Profile
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
        <?php $this->load->view('login/doctor_sidebar'); ?>
        <td width="53" valign="top">&nbsp;
          
        </td>
        <td width="985" valign="top">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td height="50">&nbsp;
                
              </td>
            </tr>
            <tr>
              <td class="maine_from">

                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="45" bgcolor="#3dc4bf">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td height="45" class="from_page_tetel">
                            Provide your profile details
                          </td>
                          <td>&nbsp;
                            
                          </td>
                          <td width="150" align="center" class="text">
                            Step 1 of 3
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td height="90" align="center">
                      <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="47">
                            <div id="circle1">
                              1
                            </div>
                          </td>
                          <td class="from_tetel_text">
                            Professional Details
                          </td>
                          <td width="47">
                            <div id="circle1">
                              2
                            </div>
                          </td>
                          <td>
                            <span class="from_tetel_text">
                              Clinic / Hospital Details
                            </span>
                          </td>
                          <td width="47">
                            <div id="circle1">
                              3
                            </div>
                          </td>
                          <td>
                            <span class="from_tetel_text">
                              Account Setup
                            </span>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td bgcolor="#F6F6F6">
                      <div class="meter">
                        <span id="meterperct" style="width:100%">
                        </span>
                        <p>
                        </p>
                      </div>
                    </td>
                  </tr>
                </table>

                <?php //$this->load->view('sl_step1'); ?>

              </td>
            </tr>
            <!--<tr>
            <td>
            &nbsp;
            </td>
            </tr>-->
          </table>
          <?php //$this->load->view('sl_step2'); ?>
          
          <?php $this->load->view('login/sl_step3'); ?>
        </td>
        <td width="53">&nbsp;
          
        </td>
      </tr>
    </table>
  </td>
</tr>
</table>
<?php $this->load->view('login/common/footer'); ?>
<?php $this->load->view('login/common/bottom'); ?>
<script type="text/javascript">
<!-- PAGE SPECIFIC JS-->
$(document).ready(function(){
$("#sl_step1").hide();
$("#sl_step2").hide();
$("#sl_step3").show();
});
<!-- PAGE SPECIFIC JS-->
</script>
</body>
</html>
