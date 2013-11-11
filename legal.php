<?php

ini_set('max_execution_time', 300000000); //3000 seconds = 50 minutes

require_once "include.php";

//if (!ISSET($_REQUEST['cl'])) die ("Inform CL.");
if (!ISSET($_REQUEST['period'])) die ("Inform period.");

//$cl 		= $_REQUEST['cl'];
$periodId 	= $_REQUEST['period'];
//$cl 		= 1000000313;
//$periodId 	= 1;

$from = '';
$to = '';

$sql = "SELECT * FROM cl ORDER BY name";
$res = $db->select($sql);

foreach($res as $cl) {
	
	$sql = "SELECT * FROM legal_item WHERE id <> 11";
	$res2 = $db->select($sql);
	
	foreach($res2 as $item) {
		$insert = "INSERT INTO legal(clID,legalID,status,comment,periodId) VALUES ($cl[clID],$item[id],'','',$periodId)";
		$db->insert($insert);
		echo $insert."<br />";
	}
}

?>