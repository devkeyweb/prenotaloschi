<?php
session_start();
header('Content-type: application/json');

require __DIR__ . '/vendor/autoload.php';
require_once('google-calendar-api.php');

try {
	// Get event details
	$eventdata = $_POST['event_details'];

    //$gcal = new GoogleCalendarApi();
    
    $client = new Google_Client();    
	$client->useApplicationDefaultCredentials();

	putenv('GOOGLE_APPLICATION_CREDENTIALS=./traslochiloschi-1579269914905-815060bd2fb4.json');
	$client->setAuthConfig('./traslochiloschi-1579269914905-815060bd2fb4.json');

	$client->setApplicationName("TraslochiLoschi");

	$scopes = [ Google_Service_Calendar::CALENDAR, Google_Service_Calendar::CALENDAR_READONLY ];
	$client->setScopes($scopes);

	$service = new Google_Service_Calendar($client);
	// // npgn0246su8qp20c0n1mf2usv4@group.calendar.google.com TS-0001
	$id_ts0001 = "npgn0246su8qp20c0n1mf2usv4@group.calendar.google.com";
	$events = $service->events->listEvents($id_ts0001);

	// INSERIMENTO EVENTO
	$event_to_add = new Google_Service_Calendar_Event(array(
	  'summary' => '[PENDING]'.$eventdata['title'],
	  'location' => 'Milano, via Mazzini 202',
	  'description' => 'Sign. Castagna - Test inserimento evento',
	  'start' => array(
	    'dateTime' => $eventdata['event_time']['start_time'],
	    'timeZone' => 'Europe/Rome',
	  ),
	  'end' => array(
	    'dateTime' => $eventdata['event_time']['end_time'],
	    'timeZone' => 'Europe/Rome',
	  ),
	  'recurrence' => array(  // ripetilo per due giorni consecutivi
	    'RRULE:FREQ=DAILY;COUNT=1'
	  ),
	));

	$event = $service->events->insert($id_ts0001, $event_to_add);
	echo json_encode([ 'event_id' => $event->htmlLink]); // $event->htmlLink 
}
catch(Exception $e) {
	//header('Bad Request', true, 400);
    echo json_encode(array( 'error' => 1, 'message' => $e->getMessage() ));
}

?>