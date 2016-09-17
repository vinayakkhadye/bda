<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <?php $this->load->view('login/common/head'); ?>
  <!-- Full Calendar Library -->
	<link href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.css" type="text/css" rel="stylesheet">
  <link href="<?php echo CSS_URL; ?>login/dhtmlxscheduler.css?v=5"	type="text/css" rel="stylesheet" />
  <link href='<?php echo STATIC_URL; ?>fullcalendar/fullcalendar.css'	type="text/css"  rel='stylesheet' />
  <link href='<?php echo STATIC_URL; ?>fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
  <link href="<?php echo CSS_URL; ?>login/loginstyle.css"	type="text/css" rel="stylesheet" />  
</head>
<body>
<?php $this->load->view('login/common/doctor_header'); ?>
<div class="container H550">
 <div class="row">
  <div class="col-lg-11 col-md-11 col-sm-11 col-xs-11 col-lg-offset-1 col-md-offset-1 col-sm-offset-1 col-sx-offset-1">
  <div id="calendar_td" ><!--style="max-width:1197px;"	-->
    <!-- fullcalendar div -->
    <div id='calendar'></div>
    <input type="hidden" id="current_clinic_id" name="current_clinic_id" value="<?php echo $scheduler_clinic_id; ?>" autocomplete='off'/>
    <input type="hidden" id="current_clinic_duration" name="current_clinic_duration" value="<?php echo $scheduler_clinic_duration; ?>" autocomplete='off'/>
    <!-- 00:15 -->
    
  </div>
  </div>
</div>
</div>
<!-- Add Appointment dialog box -->
<div id="dialog-form" class="dhx_cal_light dhx_cal_light_wide" style="height: 450px; display:none;">
<form id="appointment_form" method="POST">
  <div class="dhx_cal_ltitle" style="cursor: pointer;">
    <span class="dhx_mark">&nbsp;</span>
    <!--<span id="add_appt_date" class="dhx_time">[DATE]</span>--> <!-- pick this from the event clicked-->
    <input type="hidden" name="appt_id" id="appt_id" />
    <!--<input type="hidden" name="schedule_time" id="appt_date"/>-->
    <input type="hidden" name="doctor_id" value="<?php echo $doctorid; ?>"/>
    <input type="hidden" name="old_patient_id" id="old_patient_id" value="0" />
    <input type="hidden" name="old_patient_contact_no" id="old_patient_contact_no" value="0" />
    <input type="hidden" name="patient_id" id="patient_id" value="0" />
    <input type="hidden" name="user_id" id="user_id" value="" />
    <span class="dhx_title" id="appointment_dialog_title"><b>Add Appointment</b></span>
  </div>

  <div  style="height: 251px;">
    <div class="dhx_wrap_section">
      <div class="dhx_cal_lsection">Select Clinic<span class="mandatory">*</span></div>
      <div class="dhx_cal_ltext">
        <select id="clinic_id" name="clinic_id" class="form-control required" style="width: 264px;" >
          <?php 
          $clicnicArr = json_decode($clinics);
          foreach($clicnicArr as $c){ ?>
            <option value="<?php echo $c->id; ?>" <?=($scheduler_clinic_id==$c->id)?'selected="selected"':'' ?>  ><?php echo $c->name; ?></option>
          <?php } ?>
        </select>
      </div>
    </div>

    <div class="dhx_wrap_section">
      <div class="dhx_cal_lsection" style="float: left; margin-right: 10px;">Date<span class="mandatory">*</span></div>
      <div  style="float: left;">
        <input type="text" name="appt_date" id="appt_date" class="form-control required" style="width: 124px;" autocomplete="off" readonly/>
      </div>
      <div class="dhx_cal_lsection" style="float: left; width: 45px;">Time<span class="mandatory">*</span></div>
      <div class="dhx_cal_ltext" style="float: left;">
        <input type="text" name="appt_time" id="appt_time" class="form-control required" style="width: 76px;" autocomplete="off" readonly/>
      </div>
      
    </div>
    
    <div class="dhx_wrap_section">
      <div class="dhx_cal_lsection">Patient Name<span class="mandatory">*</span></div>
      <div class="dhx_cal_ltext">
        <input type="text" name="patient_name" id="patient_name" class="form-control required isEditable" autocomplete="off"/>
      </div>
    </div>
    
    <div class="dhx_wrap_section">
      <div class="dhx_cal_lsection" style="float: left; margin-right: 10px;">Contact<span class="mandatory">*</span></div>
      <div  style="float: left;">
        <input type="text" name="patient_contact_no" id="patient_contact_no" class="form-control required isEditable" style="width: 124px;" autocomplete="off"/>
      </div>
      <div class="dhx_cal_lsection" style="float: left; width: 45px;">Email</div>
      <div class="dhx_cal_ltext" style="float: left;">
        <input type="text" name="patient_email" id="patient_email" class="form-control isEditable" style="width: 170px;" autocomplete="off"/>
      </div>
      
    </div>
    
    <div class="dhx_wrap_section">
      <div class="dhx_cal_lsection" style="float: left;">Gender</div>
      <div class="dhx_cal_ltext" style="float: left;">
        <select id="patient_gender" name="patient_gender" class="form-control" style="width: 124px;">
        <option value="">Select Gender</option><option value="m">Male</option><option value="f">Female</option>
        </select>
      </div>
      <div class="dhx_cal_lsection" style="float: left;margin-right: 8px;width: 47px;">DOB</div>
      <div  style="float: left;">
        <input type="text" name="patient_dob" id="dob" class="form-control isEditable" style="width: 170px;" autocomplete="off" readonly/>
      </div>
    </div>

    <div class="dhx_wrap_section">
      <div class="dhx_cal_lsection" >Patient Address</div>
      <div class="dhx_cal_ltext">
        <input type="text" name="patient_address" id="patient_address" class="form-control isEditable" autocomplete="off"/>
      </div>
    </div>
  
    <div class="dhx_wrap_section">
      <div class="dhx_cal_lsection">Reason for Visit</div>
      <div class="dhx_cal_ltext">
        <input type="text" name="reason_for_visit" id="reason_for_visit" class="form-control" autocomplete="off" />
      </div>
    </div>
    
  <div class="dhx_btn_set dhx_left_btn_set dhx_save_btn_set">
    <div class="dhx_save_btn"></div>
    <div onclick="save_appointment();" id="save_appointment">Save</div>
  </div>
  <div id="del_appt_btn" style="display:none;" class="dhx_btn_set dhx_left_btn_set dhx_save_btn_set">
    <div class="dhx_save_btn"></div>
    <div onclick="delete_appointment();" id="delete_appointment">Delete</div>
  </div>
  <div class="dhx_btn_set dhx_left_btn_set dhx_cancel_btn_set"> 
    <div class="dhx_cancel_btn" ></div>
    <div onclick="$( '#dialog-form' ).dialog('close');">Cancel</div>
  </div>
  </div>

</form>	
</div>

<div id="dialog-alert" class="dhtmlx_modal_box dhtmlx-alert" style="display:none;">
  <div class="dhtmlx_popup_text">
    <span id="alert_msg"></span>
  </div>
  <div class="dhtmlx_popup_controls">
    <div class="dhtmlx_popup_button dhtmlx_ok_button">
      <!--<div onclick="$( '#dialog-alert' ).dialog('close');">OK</div>-->
      <div onclick="abort('dialog-alert');">OK</div>
    </div>
  </div>
</div>
    
<div id="dialog-alert-confirm" class="dhtmlx_modal_box dhtmlx-alert" style="display:none;">
  <div class="dhtmlx_popup_text">
    <span id="alert_msg_confirm"></span>
  </div>
  <div class="dhtmlx_popup_controls">
    <div class="dhtmlx_popup_button dhtmlx_ok_button">
      <div onclick="proceed('dialog-alert-confirm');">OK</div>
    </div>
            <div class="dhtmlx_popup_button dhtmlx_ok_button">
                <div onclick="abort('dialog-alert-confirm');">Cancel</div>
    </div>
  </div>
</div>		

<!-- BLock Appointment Dialog -->
<div id="dialog-block" class="dhx_cal_light dhx_cal_light_wide" style="height: 450px; display:none; ">
  <div id="tabs-1">
    <form id="block_form" method="POST">
    <div class="dhx_cal_ltitle" style="cursor: pointer;">
      <span class="dhx_mark">&nbsp;</span>
      <input type="hidden" name="doctor_id" value="<?php echo $doctorid; ?>"/>
      <input type="hidden" name="clinic_id" value="<?php echo $scheduler_clinic_id; ?>"/>
      <input type="hidden" name="doctor_name" value="<?php echo $name; ?>"/>
      <input type="hidden" name="doctor_email" value="<?php echo $userdetails->email_id; ?>"/>
      <input type="hidden" name="contact_number" value="<?php echo $userdetails->contact_number; ?>"/>
      <span class="dhx_title" id="appointment_dialog_title"><b>Block Time Slots</b></span>
    </div>
    <div style="height: 110px;">
      <div class="dhx_wrap_section">
        <div class="dhx_cal_lsection" style="float: left;">Select Date</div>
        <div class="dhx_cal_lsection" style="float: left; width: 55px;">From</div>
        <div class="dhx_cal_ltext" style="float: left;">
          <input type="text" name="block_start_date" id="block_start_date" class="form-control required" style="width: 100px;" autocomplete="off"/>
        </div>
        <div class="dhx_cal_lsection" style="float: left;margin-right: 8px;width: 47px;">To</div>
        <div  style="float: left;">
          <input type="text" name="block_end_date" id="block_end_date" class="form-control required" style="width: 100px;" autocomplete="off"/>
        </div>
      </div>
      
      <div class="dhx_btn_set dhx_left_btn_set dhx_save_btn_set">
        <div class="dhx_save_btn"></div>
        <div onclick="block_time();" id="">Save</div>
      </div>
      <div class="dhx_btn_set dhx_left_btn_set dhx_cancel_btn_set"> 
        <div class="dhx_cancel_btn" ></div>
        <div onclick="$( '#dialog-block' ).dialog('close');">Cancel</div>
      </div>
    </div>
  </form>
  </div>
</div>

<div id="loading" class="modal fade loader" role="dialog">
  <img src="/static/images/bdaloader.gif" id="loading" class="PA10">
</div>
<?php $this->load->view('login/common/footer'); ?>
<?php $this->load->view('login/common/bottom'); ?>
<!-- Full Calendar Library -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo JS_URL; ?>login/jquery.plugin.js" type="text/javascript"></script>
<script src='<?php echo STATIC_URL; ?>fullcalendar/lib/moment.min.js' type="text/javascript"></script>
<script src='<?php echo STATIC_URL; ?>fullcalendar/fullcalendar.js' type="text/javascript"></script>
<!-- PAGE SPECIFIC JS-->
<script type="text/javascript">
  var blocker = false;
  $(document).ready(function()
  {	
  
    var patient_list = <?php echo $patients; ?>; 
    var slotduration = "<?php echo $scheduler_clinic_duration; ?>"; 
    console.log('slot duration: ' + slotduration);
    var viewLoad = "<?php echo $scheduler_view; ?>"; 
  
    $("#appt_time").datetimepicker(
    {
      datepicker:false,
      format:'h:i a',
      formatTime: 'h:i a',
      step:<?php echo $slots; ?>
    });
    $("#appt_date").datetimepicker(
    {
      timepicker:false,
      minDate:'-1970/01/01',
      format:'d-m-Y'
    });

    if( $("#user_id").val() == "" ){
      $("#dob").datetimepicker(
      {
        timepicker:false,
        maxDate:'+1970/01/01',
        format:'d-m-Y'
      });
    }
    
    $("#block_start_date").datetimepicker({
      format:'d-m-Y h:i a',
      formatTime: 'h:i a'
    });
    
    $("#block_end_date").datetimepicker({
      format:'d-m-Y h:i a',
      formatTime: 'h:i a'
    });

    $( "#patient_name" ).autocomplete({
      source: patient_list,
      minLength: 0,
      select: function( event, ui ) {
        if(ui.item){
          var name_num = ui.item.label;  
          var label_bits = ui.item.label.split(" ");
          var xx = name_num.indexOf(label_bits[label_bits.length-1])
          /*if (label_bits.length > 2) {
            this.value = label_bits[0] + ' ' + label_bits[1];
          } else {
              this.value = label_bits[0];
          }*/
          this.value = name_num.slice(0,xx);
          $("#patient_contact_no").val(label_bits[label_bits.length-1]);
          $("#patient_id").val(ui.item.value);
          $('#patient_gender').val(ui.item.gender);
              $('#patient_email').val(ui.item.email);
              $('#dob').val(ui.item.dob);
              $('#patient_address').val(ui.item.address);
              $('#reason_for_visit').val("");
                return false;
        }
      },
      focus: function() {
            return false;
          },
      open: function() {
        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
      },
      close: function() {
        $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
      }
    });
    
    
    var calendar =$('#calendar').fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay'
      },
      defaultDate: new Date(),
      firstDay:1,
      editable: true,
      selectable: true,
      disableResizing: false,
      selectHelper: true,
      defaultView:viewLoad,
      slotDuration: slotduration, 
      slotEventOverlap:false,
      axisFormat: 'h:mm a',
      minTime:"8:00:00",
      disableDragging: true,
      timeFormat: ' ',
      select: function(start, end, jsEvent, view) {

        if(end-start == 86400000){
          calendar.fullCalendar('gotoDate', start);
          calendar.fullCalendar('changeView', "agendaDay");
        }else{
          var datestr = start.toString();
          datestr = datestr.substring(0, datestr.length - 8);
          var d = new Date(datestr);
          var checkclickedStart = d.getTime();

          var datestrEnd = end.toString();
          datestrEnd = datestrEnd.substring(0, datestrEnd.length - 8);
          var e = new Date(datestrEnd);
          var checkclickedEnd = e.getTime();

          var flag = true;
          $('#calendar').fullCalendar('clientEvents', function (event) {
            if(event.type == 'blockedSlot'){
              if(event.start!==null && event.end!==null)
              {
              var format_event_start = event.start._i.replace(/-/g, '/');
              var dStart = new Date(format_event_start);
              var format_event_end = event.end._i.replace(/-/g, '/');
              var dEnd = new Date(format_event_end);
              
              if(checkclickedStart >= dStart.getTime() && dEnd.getTime() > checkclickedEnd ){
                      var r = confirm("Do you wish to unblock this time slot?");
                  if (r == true) {
                     $.ajax({
                          type: "POST",
                          url: "<?php echo BASE_URL;?>api/scheduler/delete_blocked_slots",
                          data: {'id':event.id,'doctor_email':'<?php echo $userdetails->email_id; ?>','doctor_name':'<?php echo $name; ?>','contact_number':'<?php echo $userdetails->contact_number; ?>' },
                          dataType: "json",
                          beforeSend:function(){
                      loading();
                    },
                          success: function(data) {
                            removeLoading();
                            $('#calendar').fullCalendar( 'removeEvents',event.id );
                            $( '#alert_msg' ).text("Time Slot Unblocked Successfully");
                            $( '#dialog-alert' ).dialog('open');
                          },
                          error: function(){
                              
                          }
                      });
                  } 
                  
                flag = false;
                return false;
              }
              }
            
            }
                      
                  });
          if(flag){
          $('#clinic_id').val($('#current_clinic_id').val());
          
          var current = new Date();
          /*if(current <= d){*/
          
          var selected_time =formatAMPM(d);
          $('#appt_time').val(selected_time);
          
          var selected_date = (d.getDate() < 10? '0' : '') + (d.getDate())+"-"+(d.getMonth() < 9? '0' : '') + (d.getMonth()+1)+"-"+d.getFullYear();
          $('#appt_date').val(selected_date);	
          $('#appointment_dialog_title').html("<b>Add Appointment</b>");		
          $('#del_appt_btn').hide();	
          add_dialog.dialog( "open" );	
          /*}else{
						$( '#alert_msg' ).text("Appointments cannot be scheduled for past date/time");
						$( '#dialog-alert' ).dialog('open');
          }*/
          }
        }
      },
      loading: function (bool) { 
          if (bool) 
            loading(); 
          else 
            removeLoading();    
      },
      viewRender:function(view,element){
        currentView = view.name;
        renderEvents(view.name);
        
        $.ajax({
                type: "POST",
                url: "<?php echo BASE_URL;?>api/scheduler/set_scheduler_view",
                data: {'view':currentView},
                dataType: "json",
                beforeSend:function(){
            
          },
                success: function(data) {
                  
                },
                error: function(){
                    
                }
            });
        },
      eventClick: function(calEvent, jsEvent, view) {
        
          jsEvent.preventDefault();
        if(view.name == "month") {
          calendar.fullCalendar('gotoDate', calEvent.start);
            calendar.fullCalendar('changeView', "agendaDay");
        }else{
          
          $.ajax({
                  type: "GET",
                  url: "<?php echo BASE_URL;?>api/scheduler/get_appointment_by_id?id="+calEvent.id,
                  beforeSend:function(){
              loading(); 
            },
                  success: function(data) {
                    removeLoading(); 
                      var obj = eval(data);
                      $('#appt_id').val(obj.id);
                      $('#old_patient_id').val(obj.patient_id);
                      $('#patient_id').val(obj.patient_id);
                      $('#user_id').val(obj.user_id);

                      $('#patient_name').val(obj.patient_name);
                      $('#old_patient_contact_no').val(obj.patient_contact_no);
                      $('#patient_contact_no').val(obj.patient_contact_no);
                      $('#reason_for_visit').val(obj.reason_for_visit);
                      $('#patient_gender').val(obj.patient_gender);
                      $('#patient_email').val(obj.patient_email);	                
                      $('#clinic_id').val(obj.clinic_id);
                      var d = new Date(obj.scheduled_time).toUTCString();
                      d = new Date(d);
                      //var d = new Date(obj.scheduled_time);
                      $('#appt_time').val(formatAMPM(d));

                      $('#dob').val(obj.patient_dob);
                  $('#patient_address').val(obj.patient_address);
              var datestr = calEvent.start.toString();
              datestr = datestr.substring(0, datestr.length - 8);
              var d = new Date(datestr);
              var selected_date = (d.getDate() < 10? '0' : '') + (d.getDate())+"-"+(d.getMonth() < 9? '0' : '') + (d.getMonth()+1)+"-"+d.getFullYear();
              $('#appt_date').val(selected_date);
              if (!obj.patient_id) {
                  $('#appointment_dialog_title').html("<b>Edit Appointment - New Patient</b>");
              } else {
                $('#appointment_dialog_title').html("<b>Edit Appointment</b>");
              }    
              $('#del_appt_btn').show();	
              add_dialog.dialog( "open" );
                      // do what ever you want with the server response
                  },
                  error: function(){
                    removeLoading(); 
                      alert('Some Error Occurred!');
                  }
              });
        }
      },
      eventDrop: function(event, delta, revertFunc) {
         
        if (!confirm("Are you sure you want to rescedule this appointment")) {
          revertFunc();
          return;
        }					
            if($('#current_clinic_id').val() == 0){
          $( '#alert_msg' ).text("Please select a clinic from the top to reschedule appointment");
                $( '#dialog-alert').dialog('open');
                revertFunc();
                return;
        }
            var resched_datetime	=	event.start.format().toString();
        
            var datebits	= resched_datetime.split("T");
        
            var data = {
          'appt_id':event.id,
          'doctor_id':<?php echo $doctorid; ?>,
          'dr_name':'<?php echo $name; ?>',
          'clinic_id':$('#current_clinic_id').val(),
          'clinic_address':'<?=$clniic_details['address']?>',
          'clinic_name':'<?=$clniic_details['name']?>',
          'reason_for_visit':event.reason_for_visit,
          'clinic_number':'<?=$clniic_details['contact_number']?>',
          're_date':datebits[0],
          're_time':datebits[1],
          'mobile_number':event.mobile_number,
          'patient_email':event.patient_email,
          'patient_name':event.patient_name
        }
        $.ajax({
                type: "POST",
                url: "<?php echo BASE_URL;?>api/scheduler/reschedule_appointment",
                data: data,
                beforeSend:function(){
            loading(); 
          },
                success: function(data) {
                  removeLoading(); 
                },
                error: function(){
                  removeLoading(); 
                    revertFunc();
                }
            });
        },
        eventRender: function(event, element, calEvent) {
         element.find(".fc-title").attr("mobno",event.mobile_number);
         element.find(".fc-title").attr("reason_for_visit",event.reason_for_visit);
         element.find("td.fc-event-container").append($("<span style=\"color: #229b96; padding-top: 4px; font-weight: bolder; margin-left: -11px;\"> Appointment/s </span>"));
          },
        eventAfterAllRender:function( view ) {
          if(view.name == "month"){
          
          if($('.fc-title').length > 0){
            //$('.fc-title').css('font-size','0.8em');
            //$('.fc-title').css('text-align','center');
            console.log($('.fc-title').css('font-size'));
            
          }
        }else{
          if($('.fc-title').length > 0){
            //$('.fc-title').css('font-size','0.5em');
            //$('.fc-title').css('text-align','left');
            console.log($('.fc-title').css('font-size'));	
          }
        }
        }
    });
    
    var currentView = calendar.fullCalendar('getView').name;
    var add_dialog = $( "#dialog-form" ).dialog({
      autoOpen: false,
      width: "600px",
      dialogClass: 'noTitleStuff',
      modal: true,
      close : function(event, ui) {
          $('#appointment_form')[0].reset();
        }
    });
    
    var alert_dialog = $( "#dialog-alert" ).dialog({
      autoOpen: false,
      dialogClass: 'noTitleStuff',
      modal: true,
    });

    var alert_dialog_confirm = $( "#dialog-alert-confirm" ).dialog({
      autoOpen: false,
      dialogClass: 'noTitleStuff',
      modal: true
    });
    
    var block_dialog = $( "#dialog-block" ).dialog({
      autoOpen: false,
      dialogClass: 'noTitleStuff',
      modal: true,
      width: "500px",
      close : function(event, ui) {
          $('#block_form')[0].reset();
        }
    });
    
    $('#clinics_dd').on('change',function(){
      $.ajax({
              type: "POST",
              url: "<?php echo BASE_URL;?>api/scheduler/change_clinic_id",
              data: {'id':$(this).val(), 'duration':$(this).find('option:selected').attr("duration")},
              dataType: "json",
              beforeSend:function(){
                loading(); 
              },
              success: function(data) {
                window.location.reload();
              },
              error: function(){
                  removeLoading();
                alert('Some Error occurred in processing the request! Please try again');
              }
          });
      //renderEvents(currentView);
    });
    
    $( "#hiddenField" ).datepicker({
          showOn: "button",
          buttonText: "Select Date",
          onSelect: function(dateText, inst) {
              var d = new Date(dateText);
              $('#calendar').fullCalendar('gotoDate', d);
          }
      }).next(".ui-datepicker-trigger").addClass("fc-state-default");
    
  }); // end ready()
    
  $('.isEditable').bind("keydown", function(event) {
      if($("#user_id").val() != "") {
      $( '#alert_msg' ).text("Personal details of a registered user cannot be edited");
            $( '#dialog-alert').dialog('open');
      //$(this).attr('readonly','readonly');
      return false;
    }
  });



  function formatAMPM(date) {
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var ampm = hours >= 12 ? 'pm' : 'am';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? '0'+minutes : minutes;
    var strTime = hours + ':' + minutes + ' ' + ampm;
    return strTime;
  }
  function renderEvents(view){
    if(view == "month"){
        $('#calendar').fullCalendar('removeEvents');
        $('#calendar').fullCalendar('removeEventSources');
        $('#calendar').fullCalendar('refetchEvents');
      if($('#calendar').fullCalendar( 'clientEvents') == "") {
        $('#calendar').fullCalendar( 'addEventSource', '<?php echo BASE_URL;?>api/scheduler/get_appointments_count?view='+view+'&did=<?php echo $doctorid; ?>&cid='+$('#current_clinic_id').val());
      }
    }
    if(view == "agendaWeek"){
      $('#calendar').fullCalendar('removeEvents');
        $('#calendar').fullCalendar('removeEventSources');
        $('#calendar').fullCalendar('refetchEvents');
      if($('#calendar').fullCalendar( 'clientEvents') == "") {
        $('#calendar').fullCalendar( 'addEventSource', '<?php echo BASE_URL;?>api/scheduler/get_appointments?view='+view+'&did=<?php echo $doctorid; ?>&cid='+$('#current_clinic_id').val());
      }	
    }
    if(view == "agendaDay"){
      $('#calendar').fullCalendar('removeEvents');
        $('#calendar').fullCalendar('removeEventSources');
      
      $('#calendar').fullCalendar('refetchEvents');
      if($('#calendar').fullCalendar( 'clientEvents') == "") {
        $('#calendar').fullCalendar( 'addEventSource', '<?php echo BASE_URL;?>api/scheduler/get_appointments?view='+view+'&did=<?php echo $doctorid; ?>&cid='+$('#current_clinic_id').val());	
      }	
    }
    
    if( !$('#clinics_dd').length )         // use this if you are using id to check
    {
        // Add the "dropdowns" to the day headers
        var clinics = eval('<?php echo $clinics; ?>');
            $('.fc-left').append("<select id='clinics_dd' class='form-control' style='background-color: #f6f6f6; padding: 3px; width: 184px;'><select>");
						//<option duration='"+clinics[0].duration+"' value='0'>All Clinics </option> 

            var options = $("#clinics_dd");
        $.each(clinics, function() {
            options.append($("<option />").val(this.id).text(this.name).attr('duration',this.duration));
        });
    }
    if( !$('#btn_block').length ) {
      $('.fc-right').append("<button onclick='$( \"#dialog-block\" ).dialog(\"open\");' id='btn_block' class='fc-button fc-state-default' style='background-color: #f6f6f6; padding: 3px;'>Block Time Slots</button>");
    }
    
    if( !$('#hiddenField').length ) {
      $('.fc-left').append("<input type='hidden' id='hiddenField' class='' />");
    }
    $('#clinics_dd').val(<?php echo $scheduler_clinic_id; ?>);
    $(".fc-bgevent").addClass("disabled");
  }
  function loading()
	{
				$("#loading").modal();
  }
  function removeLoading() {
		$("#loading").modal('hide');
  }
  function abort(box){
		$('#calendar').fullCalendar('refetchEvents');
    blocker = true;			
    $( '#'+box ).dialog('close');
  }
  function proceed(box){
    blocker = false;
    $( '#'+box ).dialog('close');
  }
  function block_time(){
    var formData = $( "#block_form" ).serialize();
    var flag =true;
    $('#block_form *').filter('.required').each(function(){
        if($(this).val() == "" || $(this).val() == null){
          $( '#alert_msg' ).text("Please Fill the required fields");
              $( '#dialog-alert' ).dialog('open');
              block_dialog.dialog('open');
              flag = false;
        return;
      }
    });
    
    if(flag){
      $.ajax({
              type: "POST",
              url: "<?php echo BASE_URL;?>api/scheduler/block_slot",
              data: formData,
              dataType: "json",
              beforeSend:function(){
								loading();
							},
              success: function(data) {
                removeLoading();
                $( '#dialog-block' ).dialog('close');
                $( '#alert_msg' ).text("Time slots has been blocked");
                $( '#dialog-alert' ).dialog('open');
                //$('#calendar').fullCalendar('refetchEvents');
              },
              error: function(){
                removeLoading();
                  alert('Some Error occurred in processing the request!');
              }
          });
        }
  }
  function delete_appointment(){
    
    var	appt_id		=	$("#appt_id").val();
    var	contact		=	$("#patient_contact_no").val();
    if (confirm("Are you sure you want to delete this appointment!") == false){
        return false; 
    }				
    $.ajax({
            type: "POST",
            url: "<?php echo BASE_URL;?>api/scheduler/delete_appointment",
            data: {'appt_id':appt_id,'contact':contact,'doctor_id':<?php echo intval($doctorid); ?>,'clinic_id':<?php echo intval($scheduler_clinic_id); ?>},
            beforeSend:function(){
              loading();
            },
            success: function(data) {
              removeLoading();
              
              $('#calendar').fullCalendar( 'removeEvents',appt_id);
              $( '#dialog-form' ).dialog('close');
              $( '#alert_msg' ).text("Appointment Deleted Successfully");
              $( '#dialog-alert' ).dialog('open');
            },
            error: function(){
              removeLoading();
                alert('Some Error occurred in processing the request!');
            }
        });

  }
  function save_appointment(){
    var formData = $( "#appointment_form" ).serialize();
    var flag =true;
    $('#appointment_form *').filter('.required').each(function(){
        if($(this).val() == "" || $(this).val() == null){
          $( '#dialog-block' ).dialog('close');
          $( '#alert_msg' ).text("Please Fill the required fields");
              $( '#dialog-alert' ).dialog('open');
              flag = false;
        return;
      }
    });
    
    if(flag){
      $.ajax({
              type: "POST",
              url: "<?php echo BASE_URL;?>api/scheduler/save_appointment",
              data: formData,
              dataType: "json",
              beforeSend:function(){
          loading(); 
        },
              success: function(data) {
                removeLoading();
                //$('#calendar').fullCalendar('refetchEvents');
                $( '#dialog-form' ).dialog('close');
                if($("#appt_id").val() == "")
                  $( '#alert_msg' ).text("Appointment Added Successfully");
                else
                  $( '#alert_msg' ).text("Appointment Updated Successfully");
                $( '#dialog-alert' ).dialog('open');
              },
              error: function(){
                removeLoading();
                    alert('Some Error occurred in processing the request!');
              }
          });
        }
  }
  </script>
<!-- PAGE SPECIFIC JS-->
</body>
</html>
