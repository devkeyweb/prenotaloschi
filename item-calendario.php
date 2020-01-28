<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require __DIR__ . '/vendor/autoload.php';
require_once('google-calendar-api.php');

// calendarloschi.php?code=xyz
if(isset($_GET['code'])) {
  try {
    $gcal = new GoogleCalendarApi();
    
    $client = new Google_Client();    
    $client->useApplicationDefaultCredentials();

    putenv('GOOGLE_APPLICATION_CREDENTIALS=./traslochiloschi-1579269914905-815060bd2fb4.json');
    $client->setAuthConfig('./traslochiloschi-1579269914905-815060bd2fb4.json');

    $client->setApplicationName("TraslochiLoschi");

    //$httpClient = $client->authorize(); 

    $scopes = [ Google_Service_Calendar::CALENDAR, Google_Service_Calendar::CALENDAR_READONLY ];
    $client->setScopes($scopes);

  }
  catch(Exception $e) {
    //header('Location: home.php');
    echo $e->getMessage();
    exit();
  }
} else {
  //header('Location: home.php');
  //exit();
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="robots" content="noindex, nofollow">

  <!-- fullcalendar.io css -->
  <link href='../packages/core/main.css' rel='stylesheet' />
  <link href='../packages/daygrid/main.css' rel='stylesheet' />
  <link href='../packages/timegrid/main.css' rel='stylesheet' />
  <link href='../packages/list/main.css' rel='stylesheet' />

  <!-- bootstrap css -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- datetimepicker css -->
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.1.9/jquery.datetimepicker.min.css" />

  <!-- custom css -->
  <link rel="stylesheet" href="css/style.css" />

</head>

<body>

  <?php
  $service = new Google_Service_Calendar($client);  

  $calendarList = $service->calendarList->listCalendarList();

  foreach ($calendarList->getItems() as $calendarListEntry) {

    // echo "ID calendar ".$calendarListEntry->id." ".$calendarListEntry->getSummary()."<br>";
    //echo '<pre>';
    //print_r($calendarListEntry);
    //echo '</pre>';
  }

  $id_ts0001 = "npgn0246su8qp20c0n1mf2usv4@group.calendar.google.com";

    // INSERIMENTO EVENTO
    // $events = $service->events->listEvents($id_ts0001);

    // $event_to_add = new Google_Service_Calendar_Event(array(
    //   'summary' => '[PENDING] New event insert - #TSO00012sd',
    //   'location' => 'Milano, via Mazzini 202',
    //   'description' => 'Sign. Castagna - Test inserimento evento',
    //   'start' => array(
    //     'dateTime' => '2020-01-28T09:00:00-00:00',
    //     'timeZone' => 'Europe/Rome',
    //   ),
    //   'end' => array(
    //     'dateTime' => '2020-01-28T17:00:00-00:00',
    //     'timeZone' => 'Europe/Rome',
    //   ),
    //   'recurrence' => array(  // ripetilo per due giorni consecutivi
    //     'RRULE:FREQ=DAILY;COUNT=1'
    //   ),
    // ));

    // $event = $service->events->insert($id_ts0001, $event_to_add);
    // printf('Event created: %s <br/><br/>', $event->htmlLink);

  $events = $service->events->listEvents($id_ts0001);

  foreach ($events->getItems() as $event) {
    if($event->start->date != ""):
      $stardate = $event->start->date;
    else:
      $stardate = $event->start->dateTime;
    endif;

    //echo "----- ".$stardate." ".$event->id." ".$event->getSummary()." ".$event->description."<br>";
    //echo '<pre>';
    //print_r($event);
    //echo '</pre>';
  }
  ?>

  <div id="loading">loading...</div>

  <?php include "header.php"; ?>

  <!-- Page Content -->
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center">
        <h1 class="page-title">Calendario Disponibilità</h1>
        <p class="lead">Macchina: TS0001</p>
      </div>

      <div class="col-lg-4 col-xs-12">
        <!-- fullcalendar.io -->
        <div id='calendar'></div>
      </div>

      <div class="col-lg-4 col-xs-12">

        <div id='calendarDay'></div>

      </div>

      <div class="col-lg-4 col-xs-12">

        <h2>Riepilogo prenotazione</h2>

        <form action="#" method="post" name="selection-form" id="selection-form">
        <div id="form-container">

          <table class="sidebarSummary">
            <tr>
              <td class="label">Indirizzo:</td>
              <td class="content small"><?php echo $_SESSION['indirizzo']." - ".$_SESSION['citta']; ?></td>
            </tr>
            <tr>
              <td class="label">Tempo necessario per andata/ritorno:</td>
              <td class="content"><?php echo $_SESSION['oreandataritorno']; ?> <small>ore</small></td>
            </tr>
            <tr>
              <td class="label">Tempo operatività:</td>
              <td class="content"><span id="event-work-time" ></span> <small>ore</small></td>
            </tr>
            <tr id="rowTotalTime">
              <td class="label">Tempo totale:</td>
              <td class="content"><span id="event-total-time" ></span> <small>ore</small></td>
            </tr>
            <tr id="rowStartTime">
              <td class="label">Inizio intervento:</td>
              <td class="content small"><span id="event-start-time-txt" class="event-time" ></span></td>
            </tr>
            <tr id="rowEndTime">
              <td class="label">Fine intervento:</td>
              <td class="content small"><span id="event-end-time-txt" class="event-time" ></span></td>
            </tr>

          </table>

          <input type="hidden" id="citta" value="<?php echo $_SESSION['citta']; ?>" />
          <input type="hidden" id="indirizzo" value="<?php echo $_SESSION['indirizzo']; ?>" />
          <input type="hidden" id="event-spostamento-time" value="<?php echo $_SESSION['oreandataritorno']; ?>" />
          <input type="hidden" id="event-start-time" />
          <input type="hidden" id="event-end-time" />
          <button id="create-event" disabled="disabled" >Aggiungi Evento</button>
        </div>
      </form>

      </div>
    </div> <!-- /row -->

    <div class="row">    
      <div class="col-lg-12">
        <div class="stepButton">
          <button type="button" class="btBack" id="bt-back" >Torna indietro</button>
          <button type="button" class="btNext" id="submit-next-btn" disabled="disabled"  >Passo successivo</button>
         </div>
      </div>
    </div> <!-- /row -->

  </div>

  <?php include "footer.php"; ?>

  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    
  <!-- Bootstrap core JavaScript -->
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Datetimepicker jquery JavaScript -->
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.1.9/jquery.datetimepicker.min.js"></script>

  <!-- fullcalendar.io js -->
  <script src='../packages/core/main.js'></script>
  <script src='../packages/interaction/main.js'></script>
  <script src='../packages/daygrid/main.js'></script>
  <script src='../packages/timegrid/main.js'></script>
  <script src='../packages/list/main.js'></script>

  <script>
  document.addEventListener('DOMContentLoaded', function() {
    // fullcalendar.io
    /* calendario giornaliero */
    var tomorrow = new Date();
    tomorrow = formatDate(tomorrow.setDate(tomorrow.getDate() + 1));

    var calendarDay = document.getElementById('calendarDay');

    var calendarD = new FullCalendar.Calendar(calendarDay, {
      plugins: [ 'interaction', 'timeGrid'],
      header: {
        left: 'title',
        center: '',
        right: ''
      },
      defaultView: 'timeGridDay',
      minTime: '08:00:00',
      maxTime: '19:00:00',
      locale: 'it',
      defaultDate: tomorrow,
      navLinks: true, // can click day/week names to navigate views
      //businessHours: true, // display business hours
      editable: false,
      selectable: true,
      dateClick: function(info) {
        console.log(" info day ev ",info); 
      },
      select: function(info){
        $(".fc-highlight").css("background", "#49a921");
        $(".fc-highlight").css("opacity", "0.8");

        console.log( " start info:", info.end);
        $("#event-start-time-txt").html(formatDateTime(info.start));
        $("#event-end-time-txt").html(formatDateTime(info.end));
        $("#event-total-time").html(diffHours(info.start, info.end));
        var opTime = operativityTime(info.start, info.end);

        if(opTime <= 2 ){ // non posso avere operatività minore di due ore???
          $("#event-work-time").html("Attenzione! le ore di operatività devono essere superiori a 2");
          $("#create-event").attr("disabled", true);
          $("#submit-next-btn").attr("disabled", true);
        } else {
          $("#event-work-time").html(opTime);
          $("#create-event").attr("disabled", false);
          $("#submit-next-btn").attr("disabled", false);
        }
        
        $("#event-start-time").val(formatDateTime(info.start));
        $("#event-end-time").val(formatDateTime(info.end));
      },
      selectOverlap: function(event) {
        alert(' ERRORE evento sovrapposto... ', event);
      },
      events: "json-events.php",
      loading: function(bool) { 
        if (bool) $('#loading').show(); 
        else $('#loading').hide();
      },
      eventRender: function (event, element) {
        var evdate = formatDate(event.event.start);
        var allDayBool = event.event.allDay;
        //$(".fc-bgevent").css("background-color", "#c70a0a");
        //$(".fc-bgevent").css("opacity", "0.8");
        console.log("ev day ", event);
      },
    });

    calendarD.render();

    /* calendario mensile */
    /* calendario mensile */
    /* calendario mensile */
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      plugins: [ 'interaction', 'dayGrid', 'timeGrid'],
      header: {
        left: 'title',
        center: '',
        right: 'prev,next'
      },
      locale: 'it',
      defaultDate: tomorrow,
      //navLinks: true, // can click day/week names to navigate views
      //businessHours: true, // display business hours
      editable: false,
      hiddenDays: [ 0, 6 ],
      dateClick: function(info) {
        //alert('Clicked on: ' + info.dateStr);
        //alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
        //alert('Current view: ' + info.view.type);
        // change the day's background color just for fun
        //info.dayEl.style.borderColor = 'red';
        console.log(" info ",info); 

        var dataEv = info.dateStr;
          
        if($(".fc-day-grid-container td[data-date='"+dataEv+"']").hasClass('fc-past')){
          console.log(" PAST "); 
        }

        if($(".fc-day-grid-container td[data-date='"+dataEv+"']").hasClass('fc-today')){
          console.log(" TODAY "); 
        }

        if($(".fc-day-grid-container td[data-date='"+dataEv+"']").hasClass('fc-future')){ // è un evento futuro
          if(!$(".fc-day-grid-container td[data-date='"+dataEv+"']").hasClass('fullDayMonth')){ // non è ALL DAY
            console.log(" FUTURE NOT ALL DAY "); 
            $(".fc-bg table tbody tr").children().removeClass('activeDay');
            $(".fc-day-grid-container td.fc-day[data-date='"+dataEv+"']").addClass('activeDay'); // giorno attivo
            $("#calendarDay").css({"visibility": "visible"});
            calendarD.changeView('timeGridDay', info.dateStr);  
          }
        }
      },
      events: "json-events.php",
      loading: function(bool) { 
        if (bool) $('#loading').show(); 
        else $('#loading').hide();
      },
      eventRender: function (event, element) {
        var today = formatDate(new Date());
        var evdate = formatDate(event.event.start);
        var allDayBool = event.event.allDay;

        var tomorrow = new Date();
        tomorrow = formatDate(tomorrow.setDate(tomorrow.getDate() + 1));

        $(".fc-day-grid-container td.fc-day[data-date='"+today+"']").addClass('todayDay'); // giorno today
        $(".fc-day-grid-container td.fc-day[data-date='"+tomorrow+"']").addClass('activeDay'); // giorno active

        console.log(' allDayBool ',event.event);

        if (allDayBool == true) {
          $("td[data-date='"+evdate+"']").addClass('fullDayMonth');
          console.log("ev allday true "+evdate+" "+today+ " "+allDayBool);
        } else {
          $("td[data-date='"+evdate+"']").addClass('halfDayMonth');
          console.log("ev allday false "+evdate+" "+today+ " "+allDayBool);
        }
        

      },
    });

    calendar.render();
    $("#calendarDay").css({"visibility": "hidden"});

    //form inserimento evento
    //form inserimento evento
    //form inserimento evento

    // DateTimePicker plugin : http://xdsoft.net/jqplugins/datetimepicker/
    //$("#event-start-time, #event-end-time").datetimepicker({ format: 'Y-m-d H:i', minDate: 0, minTime: 0, step: 5, onShow: AdjustMinTime, onSelectDate: AdjustMinTime });
    //$("#event-date").datetimepicker({ format: 'Y-m-d', timepicker: false, minDate: 0 });

    // Send an ajax request to create event
    $("#create-event").attr('disabled', 'disabled'); 

    $("#create-event").on('click', function(e) {
      $('#loading').show(); 
      if($("#create-event").attr('data-in-progress') == 1)
        return;

      var blank_reg_exp = /^([\s]{0,}[^\s]{1,}[\s]{0,}){1,}$/,
        error = 0,
        parameters;

      $(".input-error").removeClass('input-error');

      if(!blank_reg_exp.test($("#event-title").val())) {
        $("#event-title").addClass('input-error');
        error = 1;
      }

      if($("#event-type").val() == 'FIXED-TIME') {
        if(!blank_reg_exp.test($("#event-start-time").val())) {
          $("#event-start-time").addClass('input-error');
          error = 1;
        }   

        if(!blank_reg_exp.test($("#event-end-time").val())) {
          $("#event-end-time").addClass('input-error');
          error = 1;
        }
      }
      else if($("#event-type").val() == 'ALL-DAY') {
        if(!blank_reg_exp.test($("#event-date").val())) {
          $("#event-date").addClass('input-error');
          error = 1;
        } 
      }

      if(error == 1)
        return false;

      // Event details
      parameters = {  title: $("#event-title").val(), 
        event_time: {
          start_time: $("#event-start-time").val().replace(' ', 'T') + ':00' ,
          end_time: $("#event-end-time").val().replace(' ', 'T') + ':00' ,
        },
        indirizzo: $("#indirizzo").val(),
        citta: $("#citta").val()
      };

      $.ajax({
        type: 'POST',
        url: 'ajax.php',
        data: { event_details: parameters },
        dataType: 'json',
        success: function(response) {
          $('#loading').hide(); 
          $("#create-event").removeAttr('disabled');
          $("#submit-next-btn").removeAttr('disabled');
          console.log('Event created with ID : ' + response.event_id);
          $("#calendarDay").css({"visibility": "hidden"});
              // refresha i calendari
          calendarD.refetchEvents();
          calendar.refetchEvents();
        },
        error: function(response) {
          $('#loading').hide(); 
          $("#create-event").removeAttr('disabled');
          $("#submit-next-btn").removeAttr('disabled');
          console.log(response.responseJSON.message);
        }
      }); 

    });

    // Next step
    $("#submit-next-btn").attr('disabled', 'disabled'); 

    $("#submit-next-btn").on('click', function(e) {
      document.getElementById("selection-form").action = "rent-confirm.php";
      document.getElementById("selection-form").submit();
    });


  });


  // Selected time should not be less than current time
  function AdjustMinTime(ct) {
    var dtob = new Date(),
        current_date = dtob.getDate(),
        current_month = dtob.getMonth() + 1,
        current_year = dtob.getFullYear();
          
    var full_date = current_year + '-' +
            ( current_month < 10 ? '0' + current_month : current_month ) + '-' + 
              ( current_date < 10 ? '0' + current_date : current_date );

    if(ct.dateFormat('Y-m-d') == full_date)
      this.setOptions({ minTime: 0 });
    else 
      this.setOptions({ minTime: false });
  }

  function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
  }

  function formatDateTime(dateTime) {
    var d = new Date(dateTime),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear(),
        hours = '' + d.getHours(),
        minutes = '' + d.getMinutes();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;
    if (hours.length < 2) hours = '0' + hours;
    if (minutes.length < 2) minutes = '0' + minutes;

    var dt = [year, month, day].join('-')+" "+[hours, minutes].join(':');

    return dt;
  }


  function diffHours(startH, endH) {
    var dStart = new Date(startH),
        hoursS = dStart.getHours(),
        minutesS = dStart.getMinutes();

    var dEnd = new Date(endH),
        hoursE = dEnd.getHours(),
        minutesE = dEnd.getMinutes();

    var diffH = hoursE - hoursS;

    diffM = minutesE - minutesS;
    
    console.log(diffM);

    var diff = 0;

    if(diffM < 0){
      diffM = 0.5;
      diffH = diffH - 1;
    } else if(diffM == 0){
      diffM = 0;
    } else if(diffM > 0){
      diffM = 0.5;
    }

    diff = parseFloat(diffH + diffM);

    return diff;
  }

  function operativityTime(startH, endH){

    var diffH = diffHours(startH, endH);  // float
    var timeMove = parseFloat($("#event-spostamento-time").val());
    return diffH - timeMove;
  }

  </script> 

</body>
</html>





