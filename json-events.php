<?php

require __DIR__ . '/vendor/autoload.php';
require_once('google-calendar-api.php');

$year = date('Y');
$month = date('m');

$gcal = new GoogleCalendarApi();
    
$client = new Google_Client();    
$client->useApplicationDefaultCredentials();

putenv('GOOGLE_APPLICATION_CREDENTIALS=./traslochiloschi-1579269914905-815060bd2fb4.json');
$client->setAuthConfig('./traslochiloschi-1579269914905-815060bd2fb4.json');

$client->setApplicationName("TraslochiLoschi");


$scopes = [ Google_Service_Calendar::CALENDAR, Google_Service_Calendar::CALENDAR_READONLY ];
$client->setScopes($scopes);

$service = new Google_Service_Calendar($client);  

$id_ts0001 = "npgn0246su8qp20c0n1mf2usv4@group.calendar.google.com";

$allevents = array();

$events = $service->events->listEvents($id_ts0001);

foreach ($events->getItems() as $event) {
	$stardate = "";
	$enddate = "";
	$allDay = false;

    // se start->date è vuoto significa che ho uno startdate e un enddate e l'evento non è allDay, se non è vuoto l'evento è allDay
    if(isset($event->start->date)): // evento all day
      $stardate = $event->start->date;
      //$enddate = $event->start->dateTime;
      $allDay = true;
      $classNames = ['fullDay'];
    else: // evento NON all day
      $stardate = $event->start->dateTime;
      $enddate = $event->end->dateTime;
      $classNames = ['halfDay'];
    endif;

    $array = array(
	    //'id' => $event->id,
	    //'title' => $event->getSummary(),
	    'start' => $stardate,
	    'end' => $enddate,
	    //'editable' => false,
	    'allDay' => $allDay,
	    //'rendering' => 'background',
	    'overlap' => 'false',
        //'color' => '#ff0000',
        'classNames' => $classNames
	);

	$allevents[] = $array;
    //echo "----- ".$stardate." ".$event->id." ".$event->getSummary()." ".$event->description."<br>";
}

// echo json_encode(array(
//   array(
//     'id' => 111,
//     'title' => "Evento 1",
//     'start' => "$year-$month-10",
//     'url' => "http://www.mrwebmaster.it/"
//   ),
//   array(
//     'id' => 222,
//     'title' => "Evento 2",
//     'start' => "2020-01-16T13:15:30Z",
//     'end' => "2020-01-16T14:15:30Z",
//     'allDay' => false
//   ),
//   array(
//     'id' => 333,
//     'title' => "Evento 3",
//     'start' => "$year-$month-20",
//     'end' => "$year-$month-22",
//     'url' => "http://www.google.it/"
//   )
// ));

echo json_encode($allevents);


?>