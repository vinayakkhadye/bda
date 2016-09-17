function b64ToUint6(e) {
    return e > 64 && 91 > e ? e - 65 : e > 96 && 123 > e ? e - 71 : e > 47 && 58 > e ? e + 4 : 43 === e ? 62 : 47 === e ? 63 : 0
}

function base64DecToArr(e, t) {
    for (var i, a, n = e.replace(/[^A-Za-z0-9\+\/]/g, ""), o = n.length, l = t ? Math.ceil((3 * o + 1 >> 2) / t) * t : 3 * o + 1 >> 2, r = new Uint8Array(l), c = 0, s = 0, d = 0; o > d; d++)
        if (a = 3 & d, c |= b64ToUint6(n.charCodeAt(d)) << 6 * (3 - a), 3 === a || o - d === 1) {
            for (i = 0; 3 > i && l > s; i++, s++) r[s] = c >>> (16 >>> i & 24) & 255;
            c = 0
        }
    return r
}

function uint6ToB64(e) {
    return 26 > e ? e + 65 : 52 > e ? e + 71 : 62 > e ? e - 4 : 62 === e ? 43 : 63 === e ? 47 : 65
}

function base64EncArr(e) {
    for (var t = 2, i = "", a = e.length, n = 0, o = 0; a > o; o++) t = o % 3, o > 0 && 4 * o / 3 % 76 === 0 && (i += "\r\n"), n |= e[o] << (16 >>> t & 24), (2 === t || e.length - o === 1) && (i += String.fromCharCode(uint6ToB64(n >>> 18 & 63), uint6ToB64(n >>> 12 & 63), uint6ToB64(n >>> 6 & 63), uint6ToB64(63 & n)), n = 0);
    return i.substr(0, i.length - 2 + t) + (2 === t ? "" : 1 === t ? "=" : "==")
}

function UTF8ArrToStr(e) {
    for (var t, i = "", a = e.length, n = 0; a > n; n++) t = e[n], i += String.fromCharCode(t > 251 && 254 > t && a > n + 5 ? 1073741824 * (t - 252) + (e[++n] - 128 << 24) + (e[++n] - 128 << 18) + (e[++n] - 128 << 12) + (e[++n] - 128 << 6) + e[++n] - 128 : t > 247 && 252 > t && a > n + 4 ? (t - 248 << 24) + (e[++n] - 128 << 18) + (e[++n] - 128 << 12) + (e[++n] - 128 << 6) + e[++n] - 128 : t > 239 && 248 > t && a > n + 3 ? (t - 240 << 18) + (e[++n] - 128 << 12) + (e[++n] - 128 << 6) + e[++n] - 128 : t > 223 && 240 > t && a > n + 2 ? (t - 224 << 12) + (e[++n] - 128 << 6) + e[++n] - 128 : t > 191 && 224 > t && a > n + 1 ? (t - 192 << 6) + e[++n] - 128 : t);
    return i
}

function strToUTF8Arr(e) {
    for (var t, i, a = e.length, n = 0, o = 0; a > o; o++) i = e.charCodeAt(o), n += 128 > i ? 1 : 2048 > i ? 2 : 65536 > i ? 3 : 2097152 > i ? 4 : 67108864 > i ? 5 : 6;
    t = new Uint8Array(n);
    for (var l = 0, r = 0; n > l; r++) i = e.charCodeAt(r), 128 > i ? t[l++] = i : 2048 > i ? (t[l++] = 192 + (i >>> 6), t[l++] = 128 + (63 & i)) : 65536 > i ? (t[l++] = 224 + (i >>> 12), t[l++] = 128 + (i >>> 6 & 63), t[l++] = 128 + (63 & i)) : 2097152 > i ? (t[l++] = 240 + (i >>> 18), t[l++] = 128 + (i >>> 12 & 63), t[l++] = 128 + (i >>> 6 & 63), t[l++] = 128 + (63 & i)) : 67108864 > i ? (t[l++] = 248 + (i >>> 24), t[l++] = 128 + (i >>> 18 & 63), t[l++] = 128 + (i >>> 12 & 63), t[l++] = 128 + (i >>> 6 & 63), t[l++] = 128 + (63 & i)) : (t[l++] = 252 + (i >>> 30), t[l++] = 128 + (i >>> 24 & 63), t[l++] = 128 + (i >>> 18 & 63), t[l++] = 128 + (i >>> 12 & 63), t[l++] = 128 + (i >>> 6 & 63), t[l++] = 128 + (63 & i));
    return t
}

function url_encode(e) {
    return e.toLowerCase().trim().replace(/[^A-Z0-9& ]+/gi, "").replace(/[^A-Z0-9&]+/gi, "-")
}

function script(e) {
    var t = document.createElement("script");
    t.type = "text/javascript", t.async = !0, t.src = e, document.getElementsByTagName("head")[0].appendChild(t)
}

function fb_login() {
    FB.login(function(e) {
        e.authResponse && fb_api()
    }, {
        scope: "email,public_profile",
        return_scopes: !0
    })
}

function fb_api() {
    FB.api("/me", function(e) {
        $("#patient_name").val(e.name), $("#email_id").val(e.email), $("#fb_id").val(e.id), "male" == e.gender ? $("#male").attr("checked", !0) : "female" == e.gender && $("#female").attr("checked", !0)
    })
}
document.addEventListener("contextmenu", function(e) {
    e.preventDefault()
}, !1), $("#show_link").live("click", function() {
    $("#more_cities").toggleClass("display-block")
}), $("#facebook_login").live("click", function() {
    FB.getLoginStatus(function(e) {
        if ("connected" === e.status) {
            {
                e.authResponse.userID, e.authResponse.accessToken
            }
            fb_api()
        } else "not_authorized" === e.status, fb_login()
    })
}), $(function() {
    "use strict";
    var e = !1,
        t = $.map(defaultlist, function(e, t) {
            return {
                value: t,
                data: e
            }
        }),
        i = $.map(defaultlocation, function(e, t) {
            return {
                value: t,
                data: e
            }
        });
    $("#speciality").autocomplete({
        minChars: 0,
        lookup: t,
        lookupFilter: function(e, t, i) {
            var a = new RegExp("\\b" + $.Autocomplete.utils.escapeRegExChars(i), "gi");
            return a.test(e.value)
        },
        onSelect: function(e) {
            $("#speciality").attr("url-data", e.data), $("#speciality").attr("value", e.value)
        },
        onHint: function(e) {
            $("#speciality-x").val(e)
        }
    }), $("#speciality").blur(function() {
        e = !1;
        var i = $(this).val();
        $.each(t, function(t, a) {
            a.value == i && (e = !0)
        }), 0 == e && ($("#speciality").val(""), $("#speciality").attr("url-data", ""))
    }), $("#location").autocomplete({
        lookup: i,
        lookupFilter: function(e, t, i) {
            var a = new RegExp("\\b" + $.Autocomplete.utils.escapeRegExChars(i), "gi");
            return a.test(e.value)
        },
        onSelect: function(e) {
            $("#location").attr("url-data", e.data), $("#location").attr("value", e.value)
        },
        onHint: function(e) {
            $("#location-x").val(e)
        }
    }), $("#location").blur(function() {
        e = !1;
        var t = $(this).val();
        $.each(i, function(i, a) {
            a.value == t && (e = !0)
        }), 0 == e && ($("#location").val(""), $("#location").attr("url-data", ""))
    }), $("#doctor_name").autocomplete({
        minChars: 3,
        serviceUrl: "/api/search/doctor_web/" + cityName,
        onSelect: function(e) {
            $("#doctor_name").attr("value", e.value)
        },
        onHint: function(e) {
            $("#doctor_name-x").val(e)
        }
    }), $("#doctor_name").keyup(function(e) {
        13 == e.keyCode && $("#tabs-2 > input[type=submit]").click()
    }), $("#clinic_name").autocomplete({
        minChars: 3,
        serviceUrl: "/api/search/clinic_web/" + cityName,
        onSelect: function(e) {
            $("#clinic_name").attr("value", e.value)
        },
        onHint: function(e) {
            $("#clinic_name-x").val(e)
        }
    }), $("#clinic_name").keyup(function(e) {
        13 == e.keyCode && $("#tabs-3 > input[type=submit]").click()
    })
}), $(function() {
    $("#term").length > 0 && $(".owl-carousel .owl-item > .item").live("click", function() {
				window.location.href = encodeURI(BASE_URL + cityName + "/" + $(this).find("#term").html().toLowerCase());
    }), $("#tabs-1 > input[type=submit]").live("click", function() {
        var e = $("#speciality").attr("url-data"),
            t = $("#location").attr("url-data");
        if (t && e) var i = encodeURI(BASE_URL + cityName + "/" + e + "/" + t);
        else if (e) var i = encodeURI(BASE_URL + cityName + "/" + e);
        i && (window.location.href = i)
    }), $("#tabs-2 > input[type=submit]").live("click", function() {
        var e = url_encode($("#doctor_name").val());
        if (e) var t = encodeURI(BASE_URL + cityName + "/doctor/" + e);
        t && (window.location.href = t)
    }), $("#tabs-3 > input[type=submit]").live("click", function() {
        var e = url_encode($("#clinic_name").val());
        if (e) var t = encodeURI(BASE_URL + cityName + "/clinic/" + e);
        t && (window.location.href = t)
    }), $(".appointment_via_phone").click(function() {
        var e = $(this).parent().parent().parent().parent().children(".phone-appointment-panel"),
            t = $(this).parent().parent().parent().parent().children(".cf").children("#doctor_id").html(),
            i = $(this).parent().parent().parent().parent().children(".cf").children("#clinic_id").html();
        $(e).toggle("fast", "linear", function() {
            0 == $(e).children(".phone-no-panel").length && $.ajax({
                type: "POST",
                url: "/api/search/phone_number",
                dataType: "json",
                data: {
                    clinic_id: i,
                    doctor_id: t
                },
                success: function(t) {
                    if (1 == t.response.status) {
                        var i = '<div class="phone-no-panel"><p class="phone-no">' + t.response.number_data + '</p><!--<p>Dial Extension: 204</p>--><!--<div class="phone-icon-panel"></div>--></div><div class="phone-appointment-details"><p>In case you are unable to get connected, Please call Bookdrappointment.com Helpline No : 022 49246246 (10 am to 7 pm, Monday to Saturday). Your missed call details will be provided to the Clinic.</p></div>';
                        $(e).html(i)
                    } else {
                        var i = '<div class="phone-appointment-details"><p style="font-size:2em;">Sorry for the inconvinience..</p></div>';
                        $(e).html(i)
                    }
                },
                beforeSend: function() {
                    var t = '<div class="phone-appointment-details"><p style="font-size:2em;">Getting Phone Number..</p></div>';
                    $(e).html(t)
                }
            })
        })
    }), $(".appointment_via_time").click(function() {
        var e = $(this).parent().parent().parent().parent().children(".select-date-slider"),
            t = $(this).parent().parent().parent().parent().children(".cf").children("#doctor_id").html(),
            a = $(this).parent().parent().parent().parent().children(".cf").children("#clinic_id").html();
        $(e).toggle("fast", "linear", function() {
            0 == $(e).children("#select-date-slider-owl-demo").length && $.ajax({
                type: "POST",
                url: "/api/search/available_slots",
                dataType: "json",
                data: {
                    clinic_id: a,
                    doctor_id: t,
                    is_patient: 1
                },
                success: function(n) {
                    if (1 == n.response.status) {
                        var o = '<div id="select-date-slider-owl-demo" class="owl-carousel">';
                        for (i in n.response.slots_data) {
                            o += '<div class="item">', o += '<div class="select-date-heading">' + n.response.slots_data[i].week_day + "<br>" + n.response.slots_data[i].date + "</div>", o += '<div class="select-time-panel"><ul doc="' + t + '" cli="' + a + '" date="' + n.response.slots_data[i].org_date + '">';
                            for (k in n.response.slots_data[i].time)
                                if (time_list = n.response.slots_data[i].time[k], time_list.constructor === Array || time_list.constructor === Object)
                                    for (j in time_list) {
                                        var l = "clinic_id=" + a + "&doctor_id=" + t + "&date=" + n.response.slots_data[i].org_date + "&time=" + time_list[j].toLowerCase(),
                                            r = strToUTF8Arr(l),
                                            c = base64EncArr(r);
                                        o += '<li><a href="javascript:;" data="' + c + '" >' + time_list[j] + "</a></li>"
                                    }
                                o += "</ul></div>", o += "</div>"
                        }
                        o += "</div>", o += '<div class="dateSliderCustomNavigation"><a class="btn prev-select-date-slider">Previous</a><a class="btn next-select-date-slider">Next</a></div>', $(e).html(o)
                    } else {
                        var o = '<div class="book_time_slot_msg"><p style="font-size:2em;">Sorry for the inconvinience..</p></div>';
                        $(e).html(o)
                    }
                },
                beforeSend: function() {
                    var t = '<div class="book_time_slot_msg"><p style="font-size:2em;">Select date and time.</p></div>';
                    $(e).html(t)
                },
                complete: function() {
                    var t = $(e).children("#select-date-slider-owl-demo");
                    t.owlCarousel({
                        items: 3,
                        itemsDesktop: [1e3, 3],
                        itemsDesktopSmall: [900, 2],
                        itemsTablet: [600, 2],
                        itemsMobile: [480, 1],
                        slideSpeed: 1e3,
                        autoPlay: !1
                    }), $(e).children(".dateSliderCustomNavigation").children(".next-select-date-slider").click(function() {
                        t.trigger("owl.next")
                    }), $(e).children(".dateSliderCustomNavigation").children(".prev-select-date-slider").click(function() {
                        t.trigger("owl.prev")
                    }), $(e).find(".select-time-panel > ul >li > a").click(function() {
                        data = $(this).attr("data"), url = "/bookappointment?data=" + data + "#apt", window.location.href = url
                    })
                }
            })
        })
    }), $(".profile_appointment_via_phone").click(function() {
        var e = $(this).parent().parent().parent().children(".phone-appointment-panel"),
            t = $(this).parent().parent().parent().children(".cf").children("#doctor_id").html(),
            i = $(this).parent().parent().parent().children(".cf").children("#clinic_id").html();
        $(e).toggle("fast", "linear", function() {
            0 == $(e).children(".phone-no-panel").length && $.ajax({
                type: "POST",
                url: "/api/search/phone_number",
                dataType: "json",
                data: {
                    clinic_id: i,
                    doctor_id: t
                },
                success: function(t) {
                    if (1 == t.response.status) {
                        var i = '<div class="phone-no-panel"><p class="phone-no">' + t.response.number_data + '</p><!--<p>Dial Extension: 204</p>--><!--<div class="phone-icon-panel"></div>--></div><div class="phone-appointment-details"><p>In case you are unable to get connected, Please call Bookdrappointment.com Helpline No : 022 49246246 (10 am to 7 pm, Monday to Saturday). Your missed call details will be provided to the Clinic.</p></div>';
                        $(e).html(i)
                    } else {
                        var i = '<div class="phone-appointment-details"><p style="font-size:2em;">Sorry for the inconvinience..</p></div>';
                        $(e).html(i)
                    }
                },
                beforeSend: function() {
                    var t = '<div class="phone-appointment-details"><p style="font-size:2em;">Getting Phone Number..</p></div>';
                    $(e).html(t)
                }
            })
        })
    }), $(".profile_appointment_via_time").click(function() {
        var e = $(this).parent().parent().parent().children(".select-date-slider"),
            t = $(this).parent().parent().parent().children(".cf").children("#doctor_id").html(),
            a = $(this).parent().parent().parent().children(".cf").children("#clinic_id").html();
        $(e).toggle("fast", "linear", function() {
            0 == $(e).children("#select-date-slider-owl-demo").length && $.ajax({
                type: "POST",
                url: "/api/search/available_slots",
                dataType: "json",
                data: {
                    clinic_id: a,
                    doctor_id: t
                },
                success: function(n) {
                    if (1 == n.response.status) {
                        var o = '<div id="select-date-slider-owl-demo" class="owl-carousel">';
                        for (i in n.response.slots_data) {
                            o += '<div class="item">', o += '<div class="select-date-heading">' + n.response.slots_data[i].week_day + "<br>" + n.response.slots_data[i].date + "</div>", o += '<div class="select-time-panel"><ul doc="' + t + '" cli="' + a + '" date="' + n.response.slots_data[i].org_date + '">';
                            for (k in n.response.slots_data[i].time)
                                if (time_list = n.response.slots_data[i].time[k], time_list.constructor === Array)
                                    for (j in time_list) {
                                        var l = "clinic_id=" + a + "&doctor_id=" + t + "&date=" + n.response.slots_data[i].org_date + "&time=" + time_list[j].toLowerCase(),
                                            r = strToUTF8Arr(l),
                                            c = base64EncArr(r);
                                        o += '<li><a href="javascript:;" data="' + c + '" >' + time_list[j] + "</a></li>"
                                    }
                                o += "</ul></div>", o += "</div>"
                        }
                        o += "</div>", o += '<div class="dateSliderCustomNavigation"><a class="btn prev-select-date-slider">Previous</a><a class="btn next-select-date-slider">Next</a></div>', $(e).html(o)
                    } else {
                        var o = '<div class="book_time_slot_msg"><p style="font-size:2em;">Sorry for the inconvinience..</p></div>';
                        $(e).html(o)
                    }
                },
                beforeSend: function() {
                    var t = '<div class="book_time_slot_msg"><p style="font-size:2em;">Select date and time.</p></div>';
                    $(e).html(t)
                },
                complete: function() {
                    var t = $(e).children("#select-date-slider-owl-demo");
                    t.owlCarousel({
                        items: 3,
                        itemsDesktop: [1e3, 3],
                        itemsDesktopSmall: [900, 2],
                        itemsTablet: [600, 2],
                        itemsMobile: [480, 1],
                        slideSpeed: 1e3,
                        autoPlay: !1
                    }), $(e).children(".dateSliderCustomNavigation").children(".next-select-date-slider").click(function() {
                        t.trigger("owl.next")
                    }), $(e).children(".dateSliderCustomNavigation").children(".prev-select-date-slider").click(function() {
                        t.trigger("owl.prev")
                    }), $(e).find(".select-time-panel > ul >li > a").click(function() {
                        data = $(this).attr("data"), url = "/bookappointment?data=" + data + "#apt", window.location.href = url
                    })
                }
            })
        })
    }), $("#bda_login_btn").click(function() {
        $("#login_container").hide(), $("#bda_loigin_popup").show()
    }), $("#bda_back_btn").click(function() {
        $("#login_container").show(), $("#bda_loigin_popup").hide()
    }), $("#user_login_btn").click(function() {
        var e = $("#email").val(),
            t = $("#password").val();
        $.ajax({
            url: "/bookappointment/check",
            type: "POST",
            data: {
                email: e,
                pass: t
            },
            success: function(e) {
                $("#loginerror").html();
                var e = JSON.parse(e);
                e.error ? $("#loginerror").html(e.error) : ($("#user_id").val(e.id), $("#patient_name").val(e.name), $("#email_id").val(e.email_id), $("#mobile_number").val(e.contact_number), $("#fb_id").val(e.facebook_id), $("#user_type").val(e.usertype), "m" == e.gender ? $("#male").attr("checked", !0) : "f" == e.gender && $("#female").attr("checked", !0))
            }
        })
    }), $("#view-map").click(function() {
        $(".view-map-popup").bPopup()
    }), $(".clniic-view-map").click(function() {
        var e = $(this).attr("latitude"),
            t = $(this).attr("longitude");
        $("#view-map-popup-link").attr("href", "https://www.google.com/maps/dir//" + e + "," + t + "/"), $("#view-map-popup-img").attr("src", "http://maps.googleapis.com/maps/api/staticmap?center=" + e + "," + t + "&zoom=14&scale=false&size=600x300&maptype=roadmap&format=png&visual_refresh=true&markers=size:mid|color:red|label:1|" + e + "," + t + "&markers=size:mid|color:red|label:1|" + e + "," + t), $(".view-map-popup").bPopup()
    }), $("#login").click(function() {
        $("#login1-col").hide(), $("#login2-col").show(), $("#login_error_msg").hide()
    }), $("#backto_login_signup").click(function() {
        $("#login1-col").show(), $("#login2-col").hide(), $("#login_error_msg").hide()
    }), $("#login_button").click(function() {
        var e = $("#email").val(),
            t = $("#pass").val();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "/login/check",
            data: {
                email: e,
                pass: t
            },
            success: function(e) {
                e.error ? ($("#login_error_msg").html(e.error), $("#login_error_msg").show()) : e.redirect && (window.location.href = e.redirect)
            }
        }), $(this).closest("form").submit()
    }), $("#mobile_number").keydown(function(e) {
        -1 !== $.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) || 65 == e.keyCode && e.ctrlKey === !0 || e.keyCode >= 35 && e.keyCode <= 39 || (e.shiftKey || e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105) && e.preventDefault()
    })
});
