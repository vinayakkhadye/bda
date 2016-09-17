<script type="text/javascript">
var BASE_URL	=	'<?=BASE_URL?>';
var cityName	=	'<?=$cityName?>';
</script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="<?=JS_URL?>jquery-ui.js"></script>
<script src="<?=JS_URL?>modernizr.min.js"></script>
<script src="<?=JS_URL?>css_browser_selector.js"></script>
<script src="<?=JS_URL?>jquery.slicknav.js"></script>

<script src="<?=JS_URL?>bda.js?v=1"></script>
<script type="text/javascript">
script('https://apis.google.com/js/platform.js?publisherid=113485870947565880552');
$(document).ready(function(){
	$( "#tabs" ).tabs();
	$('#menu').slicknav();
});

</script>

<script>
var _gaq = _gaq || [];  
_gaq.push(['_setAccount', 'UA-54941907-1']);  
_gaq.push(['_trackPageview']);

(function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
</script>