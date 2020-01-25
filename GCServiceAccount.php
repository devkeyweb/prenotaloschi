<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/vendor/autoload.php';
session_start();	 	
/************************************************	
 The following 3 values an befound in the setting	
 for the application you created on Google 	 	
 Developers console.	 	 Developers console.
 The Key file should be placed in a location	 
 that is not accessable from the web. outside of 
 web root.	 
 	 	 
 In order to access your GA account you must	
 Add the Email address as a user at the 	
 ACCOUNT Level in the GA admin. 	 	
 ************************************************/
	
$client = new Google_Client();	 	
$client->useApplicationDefaultCredentials();

putenv('GOOGLE_APPLICATION_CREDENTIALS=./traslochiloschi-1579269914905-815060bd2fb4.json');
$client->setAuthConfig('./traslochiloschi-1579269914905-815060bd2fb4.json');

$client->setApplicationName("TraslochiLoschi");

//$httpClient = $client->authorize(); 

$scopes = [ Google_Service_Calendar::CALENDAR, Google_Service_Calendar::CALENDAR_READONLY ];
$client->setScopes($scopes);

// OR use environment variables (recommended)

// if($client->getAuth()->isAccessTokenExpired()) {	 	
// 	$client->getAuth()->refreshTokenWithAssertion($cred);	 	
// }	 	
$service = new Google_Service_Calendar($client);  

$listaCalendari = $service->calendarList->listCalendarList();
//echo '<pre>'.var_export($listaCalendari,true).'</pre>';

$calendarList = $service->calendarList->listCalendarList();

foreach ($calendarList->getItems() as $calendarListEntry) {

	echo "ID calendar ".$calendarListEntry->id." ".$calendarListEntry->getSummary()."<br>";
	
	//echo '<pre>';
	//print_r($calendarListEntry);
	//echo '</pre>';


	// get events 
	$events = $service->events->listEvents($calendarListEntry->id);

	// foreach ($events->getItems() as $event) {
	// 	if($event->start->date != ""):
	// 		$stardate = $event->start->date;
	// 	else:
	// 		$stardate = $event->start->dateTime;
	// 	endif;

	// 	echo "----- ".$stardate." ".$event->id." ".$event->getSummary()." ".$event->description."<br>";
	// 	//echo '<pre>';
	// 	//print_r($event);
	// 	//echo '</pre>';
	// }
}

// npgn0246su8qp20c0n1mf2usv4@group.calendar.google.com TS-0001
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









