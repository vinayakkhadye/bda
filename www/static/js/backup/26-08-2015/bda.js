// JavaScript Document  
document.addEventListener("contextmenu", function(e){
    e.preventDefault();
}, false);
// Base 64 encoded
"use strict";

/*\
|*|
|*|  Base64 / binary data / UTF-8 strings utilities
|*|
|*|  https://developer.mozilla.org/en-US/docs/Web/JavaScript/Base64_encoding_and_decoding
|*|
\*/

/* Array of bytes to base64 string decoding */

function b64ToUint6 (nChr) {

  return nChr > 64 && nChr < 91 ?
      nChr - 65
    : nChr > 96 && nChr < 123 ?
      nChr - 71
    : nChr > 47 && nChr < 58 ?
      nChr + 4
    : nChr === 43 ?
      62
    : nChr === 47 ?
      63
    :
      0;

}

function base64DecToArr (sBase64, nBlocksSize) {

  var
    sB64Enc = sBase64.replace(/[^A-Za-z0-9\+\/]/g, ""), nInLen = sB64Enc.length,
    nOutLen = nBlocksSize ? Math.ceil((nInLen * 3 + 1 >> 2) / nBlocksSize) * nBlocksSize : nInLen * 3 + 1 >> 2, taBytes = new Uint8Array(nOutLen);

  for (var nMod3, nMod4, nUint24 = 0, nOutIdx = 0, nInIdx = 0; nInIdx < nInLen; nInIdx++) {
    nMod4 = nInIdx & 3;
    nUint24 |= b64ToUint6(sB64Enc.charCodeAt(nInIdx)) << 6 * (3 - nMod4);
    if (nMod4 === 3 || nInLen - nInIdx === 1) {
      for (nMod3 = 0; nMod3 < 3 && nOutIdx < nOutLen; nMod3++, nOutIdx++) {
        taBytes[nOutIdx] = nUint24 >>> (16 >>> nMod3 & 24) & 255;
      }
      nUint24 = 0;

    }
  }

  return taBytes;
}

/* Base64 string to array encoding */

function uint6ToB64 (nUint6) {

  return nUint6 < 26 ?
      nUint6 + 65
    : nUint6 < 52 ?
      nUint6 + 71
    : nUint6 < 62 ?
      nUint6 - 4
    : nUint6 === 62 ?
      43
    : nUint6 === 63 ?
      47
    :
      65;

}

function base64EncArr (aBytes) {

  var nMod3 = 2, sB64Enc = "";

  for (var nLen = aBytes.length, nUint24 = 0, nIdx = 0; nIdx < nLen; nIdx++) {
    nMod3 = nIdx % 3;
    if (nIdx > 0 && (nIdx * 4 / 3) % 76 === 0) { sB64Enc += "\r\n"; }
    nUint24 |= aBytes[nIdx] << (16 >>> nMod3 & 24);
    if (nMod3 === 2 || aBytes.length - nIdx === 1) {
      sB64Enc += String.fromCharCode(uint6ToB64(nUint24 >>> 18 & 63), uint6ToB64(nUint24 >>> 12 & 63), uint6ToB64(nUint24 >>> 6 & 63), uint6ToB64(nUint24 & 63));
      nUint24 = 0;
    }
  }

  return sB64Enc.substr(0, sB64Enc.length - 2 + nMod3) + (nMod3 === 2 ? '' : nMod3 === 1 ? '=' : '==');

}

/* UTF-8 array to DOMString and vice versa */

function UTF8ArrToStr (aBytes) {

  var sView = "";

  for (var nPart, nLen = aBytes.length, nIdx = 0; nIdx < nLen; nIdx++) {
    nPart = aBytes[nIdx];
    sView += String.fromCharCode(
      nPart > 251 && nPart < 254 && nIdx + 5 < nLen ? /* six bytes */
        /* (nPart - 252 << 30) may be not so safe in ECMAScript! So...: */
        (nPart - 252) * 1073741824 + (aBytes[++nIdx] - 128 << 24) + (aBytes[++nIdx] - 128 << 18) + (aBytes[++nIdx] - 128 << 12) + (aBytes[++nIdx] - 128 << 6) + aBytes[++nIdx] - 128
      : nPart > 247 && nPart < 252 && nIdx + 4 < nLen ? /* five bytes */
        (nPart - 248 << 24) + (aBytes[++nIdx] - 128 << 18) + (aBytes[++nIdx] - 128 << 12) + (aBytes[++nIdx] - 128 << 6) + aBytes[++nIdx] - 128
      : nPart > 239 && nPart < 248 && nIdx + 3 < nLen ? /* four bytes */
        (nPart - 240 << 18) + (aBytes[++nIdx] - 128 << 12) + (aBytes[++nIdx] - 128 << 6) + aBytes[++nIdx] - 128
      : nPart > 223 && nPart < 240 && nIdx + 2 < nLen ? /* three bytes */
        (nPart - 224 << 12) + (aBytes[++nIdx] - 128 << 6) + aBytes[++nIdx] - 128
      : nPart > 191 && nPart < 224 && nIdx + 1 < nLen ? /* two bytes */
        (nPart - 192 << 6) + aBytes[++nIdx] - 128
      : /* nPart < 127 ? */ /* one byte */
        nPart
    );
  }

  return sView;

}

function strToUTF8Arr (sDOMStr) {

  var aBytes, nChr, nStrLen = sDOMStr.length, nArrLen = 0;

  /* mapping... */

  for (var nMapIdx = 0; nMapIdx < nStrLen; nMapIdx++) {
    nChr = sDOMStr.charCodeAt(nMapIdx);
    nArrLen += nChr < 0x80 ? 1 : nChr < 0x800 ? 2 : nChr < 0x10000 ? 3 : nChr < 0x200000 ? 4 : nChr < 0x4000000 ? 5 : 6;
  }

  aBytes = new Uint8Array(nArrLen);

  /* transcription... */

  for (var nIdx = 0, nChrIdx = 0; nIdx < nArrLen; nChrIdx++) {
    nChr = sDOMStr.charCodeAt(nChrIdx);
    if (nChr < 128) {
      /* one byte */
      aBytes[nIdx++] = nChr;
    } else if (nChr < 0x800) {
      /* two bytes */
      aBytes[nIdx++] = 192 + (nChr >>> 6);
      aBytes[nIdx++] = 128 + (nChr & 63);
    } else if (nChr < 0x10000) {
      /* three bytes */
      aBytes[nIdx++] = 224 + (nChr >>> 12);
      aBytes[nIdx++] = 128 + (nChr >>> 6 & 63);
      aBytes[nIdx++] = 128 + (nChr & 63);
    } else if (nChr < 0x200000) {
      /* four bytes */
      aBytes[nIdx++] = 240 + (nChr >>> 18);
      aBytes[nIdx++] = 128 + (nChr >>> 12 & 63);
      aBytes[nIdx++] = 128 + (nChr >>> 6 & 63);
      aBytes[nIdx++] = 128 + (nChr & 63);
    } else if (nChr < 0x4000000) {
      /* five bytes */
      aBytes[nIdx++] = 248 + (nChr >>> 24);
      aBytes[nIdx++] = 128 + (nChr >>> 18 & 63);
      aBytes[nIdx++] = 128 + (nChr >>> 12 & 63);
      aBytes[nIdx++] = 128 + (nChr >>> 6 & 63);
      aBytes[nIdx++] = 128 + (nChr & 63);
    } else /* if (nChr <= 0x7fffffff) */ {
      /* six bytes */
      aBytes[nIdx++] = 252 + (nChr >>> 30);
      aBytes[nIdx++] = 128 + (nChr >>> 24 & 63);
      aBytes[nIdx++] = 128 + (nChr >>> 18 & 63);
      aBytes[nIdx++] = 128 + (nChr >>> 12 & 63);
      aBytes[nIdx++] = 128 + (nChr >>> 6 & 63);
      aBytes[nIdx++] = 128 + (nChr & 63);
    }
  }

  return aBytes;

}
// base 64 encoded value
function url_encode(str)
{
	return  str.toLowerCase().trim().replace(/[^A-Z0-9&]+/ig,'-');
}
function script(url)
{
	var scriptObject = document.createElement('script');
	scriptObject .type = 'text/javascript';
	scriptObject .async = true;
	scriptObject .src = url;
	document.getElementsByTagName('head')[0].appendChild(scriptObject );            
}

$("#show_link").live('click',function(){
	$("#more_cities").toggleClass('display-block');
});

$("#facebook_login").live('click',function(){
	FB.getLoginStatus(function(response)
	{
	if (response.status === 'connected')
	{
		var uid = response.authResponse.userID;
		var accessToken = response.authResponse.accessToken;
		fb_api();
	}
	else if (response.status === 'not_authorized')
	{
		fb_login();
	}
	else
	{
		fb_login();
	}
	});
});
function fb_login()
{
	FB.login(function(response)
	{
		if (response.authResponse)
		{
			fb_api();
		}
	},
	{
	scope: 'email,public_profile',return_scopes: true
	});
}
function fb_api()
{
	FB.api('/me', function(response)
	{
		$("#patient_name").val(response.name);
		$("#email_id").val(response.email);
		$("#fb_id").val(response.id);
		
		if(response.gender == "male")
		{
			$("#male").attr('checked', true);
		}
		else if(response.gender == "female")
		{
			$("#female").attr('checked', true);
		}
	});
}


$(function(){
	if($("#speciality").length>0)
	{
		$("#speciality").autocomplete(
	{
		source: defaultlist,
		minLength: 0,
		search: function()
		{
			var term =  this.value 
		},
		select: function( event, ui )
		{
			this.value = ui.item.label;
			$(this).attr("value",ui.item.label);
			$(this).attr("url-data",ui.item.value.toLowerCase());
			return false;
		}
	}).focus(function(){
		$(this).autocomplete("search", this.value);
	});
	}
	if($("#location").length>0)
	{
		$("#location").autocomplete(
	{
		source: defaultlocation,
		minLength: 0,
		search: function()
		{
		var term =  this.value 
		},
		select: function( event, ui )
		{
			this.value = ui.item.label;
			$(this).attr("value",ui.item.label);
			$(this).attr("url-data",ui.item.value.toLowerCase());
			return false;
		}
	}).focus(function(){
		$(this).autocomplete("search", this.value);
	});					
	}
	if($("#doctor_name").length>0)
	{
		$("#doctor_name").autocomplete(
		{
			source: function( request, response )
			{
				if(request.term.length>2)
				{
				$.getJSON( BASE_URL+"api/search/doctor/?city_name="+cityName+"&query="+request.term,{}, function(data)
				{
				return response(data);
				});
				}
			},
			
			minLength: 0,
			search: function()
			{
				var term =  this.value 
			},
			select: function( event, ui )
			{
				this.value = ui.item.label;
				$(this).attr("value",ui.item.value.toLowerCase());
				return false;
			}
		}).focus(function(){
			$(this).autocomplete("search", this.value);
		});					

		$("#doctor_name").keyup(function (e) {
				if (e.keyCode == 13) {
						$("#tabs-2 > input[type=submit]").click();
				}
		});	
	}
	if($("#clinic_name").length>0)
	{
		$("#clinic_name").autocomplete(
	{
		source: function( request, response )
		{
			if(request.term.length>2)
			{
				$.getJSON( BASE_URL+"api/search/clinic/?city_name="+cityName+"&query="+request.term,{},function(data)
				{
					return response(data);
				});
			}
		},
		minLength: 3,
		search: function()
		{
		//var term =  this.value 
		},
		select: function( event, ui )
		{
			this.value = ui.item.label;
			$(this).attr("value",ui.item.value.toLowerCase());
			return false;
		}
	})	

	$("#clinic_name").keyup(function (e) {
		if (e.keyCode == 13) {
				$("#tabs-3 > input[type=submit]").click();
		}
	});	

	}
	if($("#term").length>0)
	{
		$(".owl-carousel .owl-item > .item").live('click',function(){
			//$("#speciality").attr("value",$(this).find("#display_term").text());
			//$("#speciality").attr("url-data",$(this).find("#term").html().toLowerCase());
			window.location.href = encodeURI(BASE_URL + cityName + "/" + $(this).find("#term").html().toLowerCase())
		});
	}
	
	$("#tabs-1 > input[type=submit]").live('click',function(){
		var speciality_name = $("#speciality").attr("url-data");
		var location_name = $("#location").attr("url-data");
		if(location_name && speciality_name)
		{
			var url = encodeURI(BASE_URL+cityName+"/"+speciality_name+"/"+location_name);
		}else if(speciality_name)
		{
			var url = encodeURI(BASE_URL+cityName+"/"+speciality_name+"/all");
		}else if(location_name)
		{
			//var url = encodeURI(BASE_URL+cityName+"/"+location_name);
		}
		if(url)window.location.href = url;
	});
	
	$("#tabs-2 > input[type=submit]").live('click',function(){
		var doctor_name = url_encode($("#doctor_name").val());
		if(doctor_name)
		{
			var url = encodeURI(BASE_URL+cityName+"/doctor/"+doctor_name);
		}
		if(url)window.location.href = url;
	});
	
	$("#tabs-3 > input[type=submit]").live('click',function(){
		var clinic_name = url_encode($("#clinic_name").val());
		if(clinic_name)
		{
			var url  = encodeURI(BASE_URL+cityName+"/clinic/"+clinic_name);
		}
		if(url)window.location.href = url;
	});
	
	$(".appointment_via_phone").click(function(obj){
		var panel			=	$(this).parent().parent().parent().parent().children('.phone-appointment-panel');
		var doctor_id	=	$(this).parent().parent().parent().parent().children('.cf').children('#doctor_id').html();
		var clniic_id	=	$(this).parent().parent().parent().parent().children('.cf').children('#clinic_id').html();
		$(panel).toggle("fast","linear",function(){
			if ($(panel).children('.phone-no-panel').length==0){
				$.ajax({
					type: "POST",
					url :	"/api/search/phone_number",
					dataType : "json",
					data: {'clinic_id':clniic_id,'doctor_id':doctor_id},
					success:function(obj){
					if(obj.response.status==1)
					{
						var html	=	'<div class="phone-no-panel"><p class="phone-no">'+obj.response.number_data+'</p><!--<p>Dial Extension: 204</p>--><!--<div class="phone-icon-panel"></div>--></div><div class="phone-appointment-details"><p>In case you are unable to get connected, Please call Bookdrappointment.com Helpline No : 022 49246246 (10 am to 7 pm, Monday to Saturday). Your missed call details will be provided to the Clinic.</p></div>';
						$(panel).html(html);
					}
					else
					{
						var html	=	'<div class="phone-appointment-details"><p style="font-size:2em;">Sorry for the inconvinience..</p></div>';
						$(panel).html(html);
					}
					},
					beforeSend:function(){
						var html	=	'<div class="phone-appointment-details"><p style="font-size:2em;">Getting Phone Number..</p></div>';
						$(panel).html(html);
					}
				});
			}
		});
	});	
	$(".appointment_via_time").click(function(){
		var panel			=	$(this).parent().parent().parent().parent().children('.select-date-slider');
		var doctor_id	=	$(this).parent().parent().parent().parent().children('.cf').children('#doctor_id').html();
		var clniic_id	=	$(this).parent().parent().parent().parent().children('.cf').children('#clinic_id').html();
		$(panel).toggle("fast","linear",function(){
			if ($(panel).children('#select-date-slider-owl-demo').length==0){
				$.ajax({
					type: "POST",
					url :	"/api/search/available_slots",
					dataType : "json",
					data: {'clinic_id':clniic_id,'doctor_id':doctor_id,'is_patient':1},/**/
					success:function(obj){
					if(obj.response.status==1)
					{
						var html	=	'<div id="select-date-slider-owl-demo" class="owl-carousel">';
            for(i in obj.response.slots_data)
						{
							html	+= '<div class="item">';
							html	+=	'<div class="select-date-heading">'+obj.response.slots_data[i]['week_day']+'<br>'+obj.response.slots_data[i]['date']+'</div>';
							html	+=	'<div class="select-time-panel"><ul doc="'+doctor_id+'" cli="'+clniic_id+'" date="'+ obj.response.slots_data[i]['org_date'] +'">';
							for(k in obj.response.slots_data[i]['time'])
							{
								time_list	=	obj.response.slots_data[i]['time'][k];
								if(time_list.constructor === Array || time_list.constructor === Object)
								{
									for(j in time_list)
									{
										var sMyInput = "clinic_id="+clniic_id+"&doctor_id="+doctor_id+"&date="+obj.response.slots_data[i]['org_date']
										+"&time="+time_list[j].toLowerCase();
										var aMyUTF8Input = strToUTF8Arr(sMyInput);
										var sMyBase64 = base64EncArr(aMyUTF8Input);										
										html	+=	'<li><a href="javascript:;" data="'+sMyBase64+'" >'+time_list[j]+'</a></li>';
									}
								}
							}
							html	+=	'</ul></div>';
							html	+=	'</div>';
						}
						html	+=	'</div>';
						html	+=	'<div class="dateSliderCustomNavigation"><a class="btn prev-select-date-slider">Previous</a><a class="btn next-select-date-slider">Next</a></div>';
						$(panel).html(html);
					}
					else
					{
						var html	=	'<div class="book_time_slot_msg"><p style="font-size:2em;">Sorry for the inconvinience..</p></div>';
						$(panel).html(html);
					}
					},
					beforeSend:function(){
						var html	=	'<div class="book_time_slot_msg"><p style="font-size:2em;">Select date and time.</p></div>';
						$(panel).html(html);
					},
					complete:function(){
							var owl2 = $(panel).children('#select-date-slider-owl-demo');
							owl2.owlCarousel({
							items : 3, //10 items above 1000px browser width
							itemsDesktop : [1000,3], //5 items between 1000px and 901px
							itemsDesktopSmall : [900,2], // 3 items betweem 900px and 601px
							itemsTablet: [600,2], //2 items between 600 and 0;
							itemsMobile : [480,1], // itemsMobile disabled - inherit from itemsTablet option
							slideSpeed: 1000,
							autoPlay: false
							});
							
							// Custom Navigation Events
							$(panel).children('.dateSliderCustomNavigation').children('.next-select-date-slider').click(function(){
							owl2.trigger('owl.next');
							})
							$(panel).children('.dateSliderCustomNavigation').children('.prev-select-date-slider').click(function(){
							owl2.trigger('owl.prev');
							})
							$(panel).find(".select-time-panel > ul >li > a").click(function(){
								//doctor_id	=	 $(this).parent().parent().attr("doc");
								//clinic_id	=	 $(this).parent().parent().attr("cli");
								//date	=	 $(this).parent().parent().attr("date");
								data	=	$(this).attr("data");
								//url	=	'/bookappointment.html?clinic_id='+clinic_id+'&doctor_id='+doctor_id+'&date='+date+'&time='+$(this).html().toLowerCase()+'#apt';
								url	=	'/bookappointment?data='+data+'#apt';
								
								window.location.href	=	url;
								//
							});

					}
				});
			}
		});
	});	

	$(".profile_appointment_via_phone").click(function(obj){
		
		var panel			=	$(this).parent().parent().parent().children('.phone-appointment-panel');
		var doctor_id	=	$(this).parent().parent().parent().children('.cf').children('#doctor_id').html();
		var clniic_id	=	$(this).parent().parent().parent().children('.cf').children('#clinic_id').html();
		$(panel).toggle("fast","linear",function(){
			if ($(panel).children('.phone-no-panel').length==0){
				$.ajax({
					type: "POST",
					url :	"/api/search/phone_number",
					dataType : "json",
					data: {'clinic_id':clniic_id,'doctor_id':doctor_id},
					success:function(obj){
					if(obj.response.status==1)
					{
						var html	=	'<div class="phone-no-panel"><p class="phone-no">'+obj.response.number_data+'</p><!--<p>Dial Extension: 204</p>--><!--<div class="phone-icon-panel"></div>--></div><div class="phone-appointment-details"><p>In case you are unable to get connected, Please call Bookdrappointment.com Helpline No : 022 49246246 (10 am to 7 pm, Monday to Saturday). Your missed call details will be provided to the Clinic.</p></div>';
						$(panel).html(html);
					}
					else
					{
						var html	=	'<div class="phone-appointment-details"><p style="font-size:2em;">Sorry for the inconvinience..</p></div>';
						$(panel).html(html);
					}
					},
					beforeSend:function(){
						var html	=	'<div class="phone-appointment-details"><p style="font-size:2em;">Getting Phone Number..</p></div>';
						$(panel).html(html);
					}
				});
			}
		});
	});	
	$(".profile_appointment_via_time").click(function(){
		var panel			=	$(this).parent().parent().parent().children('.select-date-slider');
		var doctor_id	=	$(this).parent().parent().parent().children('.cf').children('#doctor_id').html();
		var clniic_id	=	$(this).parent().parent().parent().children('.cf').children('#clinic_id').html();
		$(panel).toggle("fast","linear",function(){
			if ($(panel).children('#select-date-slider-owl-demo').length==0){
				$.ajax({
					type: "POST",
					url :	"/api/search/available_slots",
					dataType : "json",
					data: {'clinic_id':clniic_id,'doctor_id':doctor_id},
					success:function(obj){
					if(obj.response.status==1)
					{
						var html	=	'<div id="select-date-slider-owl-demo" class="owl-carousel">';
            for(i in obj.response.slots_data)
						{
							html	+= '<div class="item">';
							html	+=	'<div class="select-date-heading">'+obj.response.slots_data[i]['week_day']+'<br>'+obj.response.slots_data[i]['date']+'</div>';
							html	+=	'<div class="select-time-panel"><ul doc="'+doctor_id+'" cli="'+clniic_id+'" date="'+ obj.response.slots_data[i]['org_date'] +'">';
							for(k in obj.response.slots_data[i]['time'])
							{
								time_list	=	obj.response.slots_data[i]['time'][k];
								if(time_list.constructor === Array)
								{
									for(j in time_list)
									{
										//html	+=	'<li><a href="javascript:;">'+time_list[j]+'</a></li>';
										var sMyInput = "clinic_id="+clniic_id+"&doctor_id="+doctor_id+"&date="+obj.response.slots_data[i]['org_date']
										+"&time="+time_list[j].toLowerCase();
										var aMyUTF8Input = strToUTF8Arr(sMyInput);
										var sMyBase64 = base64EncArr(aMyUTF8Input);										
										html	+=	'<li><a href="javascript:;" data="'+sMyBase64+'" >'+time_list[j]+'</a></li>';
																			
									}
								}
							}
							html	+=	'</ul></div>';
							html	+=	'</div>';
						}
						html	+=	'</div>';
						html	+=	'<div class="dateSliderCustomNavigation"><a class="btn prev-select-date-slider">Previous</a><a class="btn next-select-date-slider">Next</a></div>';
						$(panel).html(html);
					}
					else
					{
						var html	=	'<div class="book_time_slot_msg"><p style="font-size:2em;">Sorry for the inconvinience..</p></div>';
						$(panel).html(html);
					}
					},
					beforeSend:function(){
						var html	=	'<div class="book_time_slot_msg"><p style="font-size:2em;">Select date and time.</p></div>';
						$(panel).html(html);
					},
					complete:function(){
							var owl2 = $(panel).children('#select-date-slider-owl-demo');
							owl2.owlCarousel({
							items : 3, //10 items above 1000px browser width
							itemsDesktop : [1000,3], //5 items between 1000px and 901px
							itemsDesktopSmall : [900,2], // 3 items betweem 900px and 601px
							itemsTablet: [600,2], //2 items between 600 and 0;
							itemsMobile : [480,1], // itemsMobile disabled - inherit from itemsTablet option
							slideSpeed: 1000,
							autoPlay: false
							});
							
							// Custom Navigation Events
							$(panel).children('.dateSliderCustomNavigation').children('.next-select-date-slider').click(function(){
							owl2.trigger('owl.next');
							})
							$(panel).children('.dateSliderCustomNavigation').children('.prev-select-date-slider').click(function(){
							owl2.trigger('owl.prev');
							})
							$(panel).find(".select-time-panel > ul >li > a").click(function(){
								//doctor_id	=	 $(this).parent().parent().attr("doc");
								//clinic_id	=	 $(this).parent().parent().attr("cli");
								//date	=	 $(this).parent().parent().attr("date");
								//url	=	'/bookappointment.html?clinic_id='+clinic_id+'&doctor_id='+doctor_id+'&date='+date+'&time='+$(this).html().toLowerCase()+'#apt';
								data	=	$(this).attr("data");
								//url	=	'/bookappointment.html?clinic_id='+clinic_id+'&doctor_id='+doctor_id+'&date='+date+'&time='+$(this).html().toLowerCase()+'#apt';
								url	=	'/bookappointment?data='+data+'#apt';
								window.location.href	=	url;
							});

					}
				});
			}
		});
	});	

$("#bda_login_btn").click(function(){
	$("#login_container").hide();
	$("#bda_loigin_popup").show();
});
$("#bda_back_btn").click(function(){
	$("#login_container").show();
	$("#bda_loigin_popup").hide();
});

$("#user_login_btn").click(function(){
	var email = $("#email").val();
	var pass = $("#password").val();
	$.ajax({
	url : '/bookappointment/check',
	type : 'POST',
	data :
	{
		'email'	: email,
		'pass'	: pass
	},
	success: function(response)
	{
		$("#loginerror").html();
		var response = JSON.parse(response);
		if(response.error)
		{
			$("#loginerror").html(response.error);
		}
		else
		{
			$("#user_id").val(response.id);
			$("#patient_name").val(response.name);
			$("#email_id").val(response.email_id);
			$("#mobile_number").val(response.contact_number);
			$("#fb_id").val(response.facebook_id);
			$("#user_type").val(response.usertype);
			if(response.gender == "m")
			{
			$("#male").attr('checked', true);
			}else if(response.gender == "f")
			{
			$("#female").attr('checked', true);
			}
		}
	}
	});
});

$("#view-map").click(function(){
	$(".view-map-popup").bPopup();
});
$("#clniic-view-map").click(function(){
	var latitude	=	$(this).attr('latitude');
	var longitude	=	$(this).attr('longitude');
	$("#view-map-popup-link").attr("href",'https://www.google.com/maps/dir//'+latitude+','+longitude+'/');
	$("#view-map-popup-img").attr("src",'http://maps.googleapis.com/maps/api/staticmap?center='+latitude+','+longitude+'&zoom=14&scale=false&size=600x300&maptype=roadmap&format=png&visual_refresh=true&markers=size:mid|color:red|label:1|'+latitude+','+longitude+'&markers=size:mid|color:red|label:1|'+latitude+','+longitude)
	$(".view-map-popup").bPopup();
});



$("#login").click(function(){
	$("#login1-col").hide();
	$("#login2-col").show();
	$("#login_error_msg").hide();
});
$("#backto_login_signup").click(function(){
	$("#login1-col").show();
	$("#login2-col").hide();
	$("#login_error_msg").hide();
});
$("#login_button").click(function(){
	var email	=	 $("#email").val();
	var pass	=	 $("#pass").val();
	$.ajax({
	type: "POST",
	dataType : "json",
	url :	"/login/check",
	data: {'email':email,'pass':pass},
	success:function(obj){
		if(obj.error)
		{
			$("#login_error_msg").html(obj.error);
			$("#login_error_msg").show();
		}
		else if(obj.redirect)
		{
			window.location.href=obj.redirect;
		}
		
	},
	});
	$(this).closest("form").submit();
});
$("#mobile_number").keydown(function (e) {
		// Allow: backspace, delete, tab, escape, enter and .
		if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
				 // Allow: Ctrl+A
				(e.keyCode == 65 && e.ctrlKey === true) || 
				 // Allow: home, end, left, right
				(e.keyCode >= 35 && e.keyCode <= 39)) {
						 // let it happen, don't do anything
						 return;
		}
		// Ensure that it is a number and stop the keypress
		if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
				e.preventDefault();
		}
});

});
