<?php

ini_set('max_execution_time', 300000000);

require_once "include.php";

if (!ISSET($_REQUEST['period'])) die ("Inform period.");
if (!ISSET($_REQUEST['cl'])) die ("Inform CL.");

$periodId 	= $_REQUEST['period'];
$clId 		= $_REQUEST['cl'];

// Test if periods exists

$sql = "SELECT * FROM period WHERE id=$periodId";
$res = $db->select($sql);
if (count($res) == 0){
	die("Period '$periodId' not found. Create it and try again.");
}

echo "Deleting data from period: $periodId and CL: $clId<br />";
$sql = "DELETE FROM `adt_icx_gcdp` WHERE periodId=$periodId AND clID=$clId";
$db->update($sql); 
$sql = "DELETE FROM `adt_icx_gip` WHERE periodId=$periodId AND clID=$clId";
$db->update($sql); 
$sql = "DELETE FROM `adt_ogx_gcdp` WHERE periodId=$periodId AND clID=$clId";
$db->update($sql); 
$sql = "DELETE FROM `adt_ogx_gip` WHERE periodId=$periodId AND clID=$clId";
$db->update($sql); 


?>