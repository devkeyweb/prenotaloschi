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

    // Redirect to the page where user can create event
    //header('Location: home.php');
    //exit();
  }
  catch(Exception $e) {
    echo $e->getMessage();
    exit();
  }
} else {

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

<link rel="stylesheet" href="css/style.css" />
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.1.9/jquery.datetimepicker.min.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.1.9/jquery.datetimepicker.min.js"></script>

  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <style>



  </style>

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

<body>

  <div id="loading">loading...</div>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg static-top">
    <div class="container">
      <a class="navbar-brand" href="#"><img src="./img/traslochi-aziende-uffici.png" class="logoHeader" /></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Home
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Services</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center">
        <h1 class="mt-5">Calendario Disponibilità</h1>
        <p class="lead">Macchina: TS0001</p>
      </div>

      <div class="col-lg-8 col-xs-12">
        <div id='calendar'></div>
      </div>

      <div class="col-lg-4 col-xs-12">
        <h2>Crea nuovo evento</h2>
        <div id="form-container">
          <input type="text" id="event-title" placeholder="Titolo evento" autocomplete="off" /><br/>
          <select id="event-type"  autocomplete="off"><br/>
            <option value="FIXED-TIME">Evento Fixed Time</option>
            <option value="ALL-DAY">Evento All Day </option>
          </select><br/>
          <input type="text" id="event-start-time" placeholder="Data inizio" autocomplete="off" /><br/>
          <input type="text" id="event-end-time" placeholder="Data fine" autocomplete="off" /><br/>
          <input type="text" id="event-date" placeholder="Data Evento" autocomplete="off" /><br/><br/>
          <button id="create-event">Aggiungi Evento</button>
        </div>

      </div>

    </div>
  </div>

  <footer >
    <!-- Page Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          Copyright 2018 - Privacy - Cookies Policy<br/>
Loschi traslochi di Luca Loschi - Sede: Via Carlo Marx 95 – 41012 Carpi (MO) -<br/>
P.IVA: 03495650362 - CF: LSCLCU73S04B819Q - CCIAA/REA: MO 392898 059 698416 340 4227572 - loschitraslochi@yahoo.it<br/><br/>Web application a cura di Key-web marketing

        </div>
      </div>
    </div>
  </footer>
    
  <!-- Bootstrap core JavaScript -->
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- fullcalendar.io -->
<link href='../packages/core/main.css' rel='stylesheet' />
<link href='../packages/daygrid/main.css' rel='stylesheet' />
<link href='../packages/timegrid/main.css' rel='stylesheet' />
<link href='../packages/list/main.css' rel='stylesheet' />
<script src='../packages/core/main.js'></script>
<script src='../packages/interaction/main.js'></script>
<script src='../packages/daygrid/main.js'></script>
<script src='../packages/timegrid/main.js'></script>
<script src='../packages/list/main.js'></script>
<script>

  document.addEventListener('DOMContentLoaded', function() {
    // fullcalendar.io
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
      },
      locale: 'it',
      defaultDate: '2020-01-30',
      navLinks: true, // can click day/week names to navigate views
      businessHours: true, // display business hours
      editable: false,
      dateClick: function(info) {
        alert('Clicked on: ' + info.dateStr);
        alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
        alert('Current view: ' + info.view.type);
        // change the day's background color just for fun
        //info.dayEl.style.backgroundColor = 'red';
        //console.log(" info ",info);
        
        if(info.view.type == 'dayGridMonth' || info.view.type == 'basicWeek') {
          calendar.changeView('timeGridDay', info.dateStr);      
        }
      },
      

      events: "json-events.php",
      loading: function(bool) { 
        if (bool) $('#loading').show(); 
        else $('#loading').hide();
      },
      eventColor: '#ff0000',
      eventRender: function (event, element) {
        console.log("ev ",event.event.start);
        //var dataToFind = moment(event.event.start).format('YYYY-MM-DD');
        //$("td[data-date='"+dataToFind+"']").addClass('activeDay');
      },
    });

    calendar.render();

    //form inserimento evento
    //form inserimento evento
    //form inserimento evento
    // DateTimePicker plugin : http://xdsoft.net/jqplugins/datetimepicker/
    $("#event-start-time, #event-end-time").datetimepicker({ format: 'Y-m-d H:i', minDate: 0, minTime: 0, step: 5, onShow: AdjustMinTime, onSelectDate: AdjustMinTime });
    $("#event-date").datetimepicker({ format: 'Y-m-d', timepicker: false, minDate: 0 });

    $("#event-type").on('change', function(e) {
      if($(this).val() == 'ALL-DAY') {
        $("#event-date").show();
        $("#event-start-time, #event-end-time").hide();
      }
      else {
        $("#event-date").hide(); 
        $("#event-start-time, #event-end-time").show();
      }
    });

    // Send an ajax request to create event
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

      if($("#event-type").val() == 'FIXED-TIME') {
        // If end time is earlier than start time, then interchange them
        if($("#event-end-time").datetimepicker('getValue') < $("#event-start-time").datetimepicker('getValue')) {
          var temp = $("#event-end-time").val();
          $("#event-end-time").val($("#event-start-time").val());
          $("#event-start-time").val(temp);
        }
      }

      // Event details
      parameters = {  title: $("#event-title").val(), 
              event_time: {
                start_time: $("#event-type").val() == 'FIXED-TIME' ? $("#event-start-time").val().replace(' ', 'T') + ':00' : null,
                end_time: $("#event-type").val() == 'FIXED-TIME' ? $("#event-end-time").val().replace(' ', 'T') + ':00' : null,
                event_date: $("#event-type").val() == 'ALL-DAY' ? $("#event-date").val() : null
              },
              all_day: $("#event-type").val() == 'ALL-DAY' ? 1 : 0,
            };

      console.log("par",parameters);

      $("#create-event").attr('disabled', 'disabled');
      $.ajax({
            type: 'POST',
            url: 'ajax.php',
            data: { event_details: parameters },
            dataType: 'json',
            success: function(response) {
              $('#loading').hide(); 
              $("#create-event").removeAttr('disabled');
              console.log('Event created with ID : ' + response.event_id);
              // refresha il calendario
              calendar.refetchEvents()
            },
            error: function(response) {
              $('#loading').hide(); 
              $("#create-event").removeAttr('disabled');
              console.log(response.responseJSON.message);
            }
        });
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


  </script> 

</body>

</html>


</body>
</html>





