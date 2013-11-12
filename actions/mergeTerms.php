<?php
header('Content-Type: text/html; charset=iso-8859-1');

ini_set('max_execution_time', 300000000); 

require_once "include.php";

if (!ISSET($_REQUEST['src'])) die ("Inform period source.");
if (!ISSET($_REQUEST['des'])) die ("Inform period destination.");
if (!ISSET($_REQUEST['clId'])) die ("Inform cl.");
$src 		= $_REQUEST['src'];
$des 		= $_REQUEST['des'];
$clId 		= $_REQUEST['clId'];

//Used for tests
//$src = 1; 	 	// CONAL  2012
//$des = 1360;  	// CONADE 2013
//$clId = 13428806; // @BH

$sql = "SELECT `name`, `status`, id FROM term WHERE periodId=$des and clId=$clId";
$res = $db->select($sql);

$updated=0;
$newTerms=0;

if (count($res) > 0){
	foreach($res as $new) {
		//echo "Checking if name '$new[name]' was already audidated.<br />";

		//$sql = "SELECT status FROM term WHERE periodId=$src AND REPLACE(LOWER(name),'  ','') = '".trim(strtolower($new['name']))."' AND clId=$clId ";
		$sql = "SELECT status FROM term WHERE periodId=$src AND REPLACE(LOWER(name),'  ','') = '".trim(strtolower($new['name']))."'";
		$res2 = $db->select($sql);

		if (count($res2) > 0){
			//Always get the first. More than one result is not expected, but could happen when data table is dirty.
			$oldStatus = $res2[0]['status'];
			$newStatus = updateDocStatus($oldStatus);

			$sql = "UPDATE term SET status='$newStatus' WHERE periodId=$des and clId=$clId and REPLACE(LOWER(name),'  ','') = '".trim(strtolower($new['name']))."'";
			//echo $sql .'<br />';
			$db->update($sql);
			$updated++;
		}else{
			$newTerms++;
			//Nothing found means that is a new member. Keep status as NE.
		}
	}
	echo "Number of new terms or not found on previous audit: '$newTerms' and updated terms: '$updated'.";
}else{
	echo "No terms for this CL.";
	die();
}

function updateDocStatus($curStatus){
	$newStatus = '';

	switch ($curStatus){
		case 'OK':
			return 'S';
			break;
		case 'NE2':
		case 'NA2':
			return '-';
			break;
		case 'NA':
		case 'NE':
			return 'NE2';
			break;
	}

	return $curStatus;
}

?>