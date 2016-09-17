<script type="text/javascript">
<?php
	function js_str($s)
	{
		return '"' . addcslashes(ucwords($s['name']), "\0..\37\"\\") . '":"'.$s['url_name'].'"';
	}
	function js_array($array)
	{
		$temp = array_map('js_str', $array);
		return '{' . implode(',', $temp) . '}';
	}
	if(isset($location)&& !empty($location))
	{
		echo 'var defaultlocation = ', js_array($location), ';';
	}
	else
	{
		echo 'var defaultlocation = \'\';';
	}
	if(isset($speciality) && !empty($speciality))
	{
		echo 'var defaultlist = ', js_array($speciality), ';';
	}
	else
	{
		echo 'var defaultlist = \'\';';
	}
?>
</script>
<script type="text/javascript">
var BASE_URL	=	'<?=BASE_URL?>';
var cityName	=	'<?=(isset($cityName))?$cityName:'Pune'?>';
</script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="<?=JS_URL?>jquery-ui.js"></script>
<script type="text/javascript" src="<?=JS_URL?>modernizr.min.js"></script>
<script type="text/javascript" src="<?=JS_URL?>css_browser_selector.js"></script>
<script type="text/javascript" src="<?=JS_URL?>jquery.slicknav.js"></script>
<script type="text/javascript" src="<?=JS_URL?>jquery.autocomplete.js"></script>
<script type="text/javascript" src="<?=JS_URL?>bda.min.js?v=4"></script>
<link	rel="publisher"	href="https://apis.google.com/js/platform.js?publisherid=113485870947565880552">
<script type="text/javascript">
$(document).ready(function(){
	$( "#tabs" ).tabs();
	$('#menu').slicknav();
});

var _gaq = _gaq || [];  
_gaq.push(['_setAccount', 'UA-54941907-1']);  
_gaq.push(['_trackPageview']);

(function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
</script>

<!-- Start Alexa Certify Javascript -->
<script type="text/javascript">
_atrk_opts = { atrk_acct:"01pul1aAFUE0V1", domain:"bookdrappointment.com",dynamic: true};
(function() { var as = document.createElement('script'); as.type = 'text/javascript'; as.async = true; as.src = "https://d31qbv1cthcecs.cloudfront.net/atrk.js"; var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(as, s); })();
</script>
<noscript><img src="https://d5nxst8fruw4z.cloudfront.net/atrk.gif?account=01pul1aAFUE0V1" style="display:none" height="1" width="1" alt="" /></noscript>
<!-- End Alexa Certify Javascript -->  