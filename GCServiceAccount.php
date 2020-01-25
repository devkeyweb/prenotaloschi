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
echo '<pre>'.var_export($listaCalendari,true).'</pre>';


// echo "<pre>";
// print_r($service);
// echo "</pre>";

// $calendarList = $service->calendarList->listCalendarList();

// foreach ($calendarList->getItems() as $calendarListEntry) {

// 			echo $calendarListEntry->getSummary()."<br>\n";


// 			// get events 
// 			$events = $service->events->listEvents($calendarListEntry->id);


// 			foreach ($events->getItems() as $event) {
// 			    echo "-----".$event->getSummary()."<br>";
// 			}
// }





// echo "<pre>";
// print_r($calendarList);
// echo "</pre>";


// $calendarId = 'primary';
// $optParams = array(
//   'maxResults' => 10,
//   'orderBy' => 'startTime',
//   'singleEvents' => true,
//   'timeMin' => date('c'),
// );
// $results = $service->events->listEvents($calendarId, $optParams);
// $events = $results->getItems();

// if (empty($events)) {
//     print "No upcoming events found.\n";
// } else {
//     print "Upcoming events:\n";
//     foreach ($events as $event) {
//         $start = $event->start->dateTime;
//         if (empty($start)) {
//             $start = $event->start->date;
//         }
//         printf("%s (%s)\n", $event->getSummary(), $start);
//     }
// }


?>

<html><body>

<?php
/*
$calendarList  = $service->calendarList->listCalendarList();

while(true) {
	foreach ($calendarList->getItems() as $calendarListEntry) {

			echo $calendarListEntry->getSummary()."<br>\n";


			// get events 
			$events = $service->events->listEvents($calendarListEntry->id);


			foreach ($events->getItems() as $event) {
			    echo "-----".$event->getSummary()."<br>";
			}
		}
		$pageToken = $calendarList->getNextPageToken();
		if ($pageToken) {
			$optParams = array('pageToken' => $pageToken);
			$calendarList = $service->calendarList->listCalendarList($optParams);
		} else {
			break;
		}
	}
  */  
?>








