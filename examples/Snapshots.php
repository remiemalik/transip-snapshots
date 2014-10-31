<?php 

require_once('TransIp.php');

/**
 * Configuration settings
 */
$mailReciever = "place your reciever email address here";
$mailSender = "From: Username<username@domain.com>\r\n";


$transIp = new TransIp();

$vpses = $transIp->getVpses();
$snapshots = $transIp->getSnapShots($vpses);


	
if(count($snapshots) > 0){
	
    $removedMessage = getRemovedSnapshotsMessage($transIp, $snapshots, $vpses);
	
 	$createdMessage = getCreatedSnapshotsMessage($transIp, $snapshots, $vpses);
	$greetingMessage = getMessage("endConversation");
	
	$message = $removedMessage . $createdMessage . $greetingMessage;
	$headers = getMessage("headerFormat");

	sendEmail($mailReciever, "TransIp Snapshots", $message, $headers);
	
}

/**
 * 
 * @param unknown $transIp
 * @param unknown $snapshots
 * @param unknown $vpses
 * @return string
 */
function getRemovedSnapshotsMessage($transIp, $snapshots, $vpses){
	$message = getMessage("startConversation");
	$count = 0;
	foreach ($snapshots as $snapshot){
		$transIp->setRemoveSnapShot($vpses[$count]->name, $snapshot[0]->name);
		$message .= "- with label:" . $snapshot[0]->description . " on " . $vpses[$count++]->description . "  at " .  date("d-m-Y H:m"). "<br>";
		insertPause();
	}
	
	return $message;
}

/**
 * 
 * @param unknown $transIp
 * @param unknown $snapshots
 * @param unknown $vpses
 * @return string
 */
function getCreatedSnapshotsMessage($transIp, $snapshots, $vpses){
	$message = getMessage("creationSentence");
	
	foreach ($vpses as $vps){
		$createdDateTime = new DateTime();
		$snapshotName = "backup " . $createdDateTime->format("d-m-Y");
		$transIp->setCreateSnapshot($vps->name, $snapshotName);
		$message .= "- with label: " . $snapshotName . " on " . $vps->description . " at " . $createdDateTime->format("d-m-Y H:m") . "<br/>";
		insertPause();
	}
	return $message;
}

/**
 * 
 */
function insertPause(){
	sleep(2);
}

/**
 * 
 * @param unknown $type
 * @return string
 */
function getMessage($type) {
	$message = "";
	
	switch ($type) {
		case "startConversation" :
			$message .= "Dear User," . "<br/><br/>";
			$message .= "Your vps-snapshots have been removed for: " . "<br/>";
			break;
		case "endConversation" :
			$message .= "<br/><br/>" . "Kind regards,<br/><br/>";
			$message .= "TransIp";
			break;
		case "creationSentence" :
			$message = "<br/><br/>" . "Your vps-snapshots have been created for: " . "<br/>";
			break;
		case "headerFormat" :
			$message .= "MIME-Version: 1.0\r\n";
			$message .= "Content-type: text/html; charset=iso-8859-1\r\n";
			$message .= "From: TransIp<email@domain.com>\r\n";
		break;
	}
	return $message;
}

/**
 * 
 * @param unknown $emailTo
 * @param unknown $subject
 * @param unknown $message
 * @param unknown $headers
 */

function sendEmail($emailTo, $subject, $message, $headers){
	mail($emailTo, $subject, $message, $headers);
}




?>
