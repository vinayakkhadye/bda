// JavaScript Document  
function url_encode(str)
{
	return  str.toLowerCase().trim().replace(/[^A-Z0-9&]+/ig,'-');
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
			$(this).attr("value",ui.item.value.toLowerCase());
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
			$(this).attr("value",ui.item.value.toLowerCase());
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
			$.getJSON( BASE_URL+"api/search/doctor/?city_name="+cityName+"&query="+request.term,{}, function(data)
			{
				return response(data);
			});
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
	}
	if($("#clinic_name").length>0)
	{
		$("#clinic_name").autocomplete(
	{
		source: function( request, response )
		{
			$.getJSON( BASE_URL+"api/search/clinic/?city_name="+cityName+"&query="+request.term,{},function(data)
			{
				return response(data);
			});
		},
		minLength: 3,
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
	})	
	}
	if($("#term").length>0)
	{
		$(".owl-carousel .owl-item > .item").live('click',function(){
			$("#speciality").val($(this).find("#term").html().toLowerCase());
		});
	}
	
	$("#tabs-1 > input[type=submit]").live('click',function(){
		var speciality_name = url_encode($("#speciality").val());
		var location_name = url_encode($("#location").val());
		if(location_name && speciality_name)
		{
			var url = encodeURI(BASE_URL+cityName+"/"+speciality_name+"/"+location_name);
		}else if(speciality_name)
		{
			var url = encodeURI(BASE_URL+cityName+"/"+speciality_name);
		}else if(location_name)
		{
			var url = encodeURI(BASE_URL+cityName+"/"+location_name);
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
										html	+=	'<li><a href="javascript:;">'+time_list[j]+'</a></li>';
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
							//console.log(panel);
							//console.log($(panel).find(".select-time-panel > ul >li > a"));
							$(panel).find(".select-time-panel > ul >li > a").click(function(){
								console.log($(this).parent().parent());
								doctor_id	=	 $(this).parent().parent().attr("doc");
								clinic_id	=	 $(this).parent().parent().attr("cli");
								date	=	 $(this).parent().parent().attr("date");
								url	=	'/bookappointment.html?clinic_id='+clinic_id+'&doctor_id='+doctor_id+'&date='+date+'&time='+$(this).html().toLowerCase()+'#apt';
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
		console.log($(this).parent().parent().parent());
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
										html	+=	'<li><a href="javascript:;">'+time_list[j]+'</a></li>';
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
							//console.log(panel);
							//console.log($(panel).find(".select-time-panel > ul >li > a"));
							$(panel).find(".select-time-panel > ul >li > a").click(function(){
								console.log($(this).parent().parent());
								doctor_id	=	 $(this).parent().parent().attr("doc");
								clinic_id	=	 $(this).parent().parent().attr("cli");
								date	=	 $(this).parent().parent().attr("date");
								url	=	'/bookappointment.html?clinic_id='+clinic_id+'&doctor_id='+doctor_id+'&date='+date+'&time='+$(this).html().toLowerCase()+'#apt';
								window.location.href	=	url;
								//
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
			console.log(response.error);
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
	set_clinic_map($(this).attr('latitude'),$(this).attr('longitude'))
	$(".view-map-popup").bPopup();
});


});




