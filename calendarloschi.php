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
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.1.9/jquery.datetimepicker.min.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.1.9/jquery.datetimepicker.min.js"></script>

<style type="text/css">

#logo {
  text-align: center;
  width: 200px;
    display: block;
    margin: 100px auto;
    border: 2px solid #2980b9;
    padding: 10px;
    background: none;
    color: #2980b9;
    cursor: pointer;
    text-decoration: none;
}

</style>
</head>

<body>

  <?php
  $service = new Google_Service_Calendar($client);  

  $calendarList = $service->calendarList->listCalendarList();

  foreach ($calendarList->getItems() as $calendarListEntry) {

    echo "ID calendar ".$calendarListEntry->id." ".$calendarListEntry->getSummary()."<br>";
    
    //echo '<pre>';
    //print_r($calendarListEntry);
    //echo '</pre>';
  }

  echo "<br/><br/>";

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

    echo "----- ".$stardate." ".$event->id." ".$event->getSummary()." ".$event->description."<br>";
      //echo '<pre>';
      //print_r($event);
      //echo '</pre>';
  }
  ?>


  <div id="form-container">
    <input type="text" id="event-title" placeholder="Event Title" autocomplete="off" />
    <select id="event-type"  autocomplete="off">
      <option value="FIXED-TIME">Fixed Time Event</option>
      <option value="ALL-DAY">All Day Event</option>
    </select>
    <input type="text" id="event-start-time" placeholder="Event Start Time" autocomplete="off" />
    <input type="text" id="event-end-time" placeholder="Event End Time" autocomplete="off" />
    <input type="text" id="event-date" placeholder="Event Date" autocomplete="off" />
    <button id="create-event">Create Event</button>
  </div>

  <script>

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
            $("#create-event").removeAttr('disabled');
            alert('Event created with ID : ' + response.event_id);
          },
          error: function(response) {
              $("#create-event").removeAttr('disabled');
              alert(response.responseJSON.message);
          }
      });
  });

  </script>



</body>
</html>





