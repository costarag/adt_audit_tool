<?php

ini_set('max_execution_time', 300000000);

require_once "include.php";

if (!ISSET($_REQUEST['period'])) die ("Inform period.");
if (!ISSET($_REQUEST['periodSrc'])) die ("Inform periodSrc. Usually last month. E.g. 134 (13: 2013, 4: Abril)");

$periodId 	= $_REQUEST['period'];
$periodSrc 	= $_REQUEST['periodSrc'];

// Test if periods exists
$sql = "SELECT * FROM period WHERE id=$periodSrc";
$res = $db->select($sql);
if (count($res) == 0){
	die("Period source '$periodSrc' not found. Create it and try again.");
}

$sql = "SELECT * FROM period WHERE id=$periodId";
$res = $db->select($sql);
if (count($res) == 0){
	die("Period '$periodId' not found. Create it and try again.");
}

echo "Deleting data from period: $periodId <br />";
$sql = "DELETE FROM `adt_icx_gcdp` WHERE periodId=$periodId";
$db->update($sql); 
$sql = "DELETE FROM `adt_icx_gip` WHERE periodId=$periodId";
$db->update($sql); 
$sql = "DELETE FROM `adt_ogx_gcdp` WHERE periodId=$periodId";
$db->update($sql); 
$sql = "DELETE FROM `adt_ogx_gip` WHERE periodId=$periodId";
$db->update($sql); 

echo "Copying data from period '$periodSrc' to '$periodId'. <br/><br/>";

echo "* GCDPi <br />";

$sql =  "INSERT INTO `adt_icx_gcdp` ";
$sql .= "(`id`,`name`,`formMAId`,`formMAName`,`type`,`status`,`dtRA`,`dtMA`,`dtRE`,`dtEND`,`contract`,`san`,`can`,`rne`,`tr_checklist`,`fu_1st`,`fu_3rd`,`visita_fechamento`,`clID`,`periodId`,`formId`) ";
$sql .= "SELECT `id`,`name`,`formMAId`,`formMAName`,`type`,`status`,`dtRA`,`dtMA`,`dtRE`,`dtEND`,`contract`,`san`,`can`,`rne`,`tr_checklist`,`fu_1st`,`fu_3rd`,`visita_fechamento`,`clID`,$periodId,`formId` ";
$sql .= "FROM `adt_icx_gcdp` ";
$sql .= "WHERE periodId=$periodSrc";
$db->insert($sql); 
//echo $sql;

echo "* GIPi <br />";

$sql =  "INSERT INTO `adt_icx_gip` ";
$sql .= "(`id`,`name`,`formMAId`,`formMAName`,`type`,`status`,`dtRA`,`dtMA`,`dtRE`,`dtEND`,`contract`,`san`,`can`,`rne`,`tr_checklist`,`fu_1st_week`,`fu_1st_month`,`fu_plus_45`,`fu_plus_90`,`fu_plus_135`,`fu_plus_180`,`fu_plus_225`,`fu_plus_270`,`fu_plus_315`,`fu_plus_360`,`visita_fechamento`,`clID`,`periodId`,`formId`) ";
$sql .= "SELECT `id`,`name`,`formMAId`,`formMAName`,`type`,`status`,`dtRA`,`dtMA`,`dtRE`,`dtEND`,`contract`,`san`,`can`,`rne`,`tr_checklist`,`fu_1st_week`,`fu_1st_month`,`fu_plus_45`,`fu_plus_90`,`fu_plus_135`,`fu_plus_180`,`fu_plus_225`,`fu_plus_270`,`fu_plus_315`,`fu_plus_360`,`visita_fechamento`,`clID`,$periodId,`formId` ";
$sql .= "FROM adt_icx_gip ";
$sql .= "WHERE periodId=$periodSrc ";
$db->insert($sql); 
//echo $sql;

echo "* GCDPo <br />";

$sql =  "INSERT INTO `adt_ogx_gcdp` ";
$sql .= "(`id`,`name`,`formMAId`,`formMAName`,`type`,`status`,`dtRA`,`dtMA`,`dtRE`,`dtEND`,`contract`,`san`,`can`,`ep_checklist`,`fu_1st`,`fu_3rd`,`clID`,`periodId`,`formId`) ";
$sql .= "SELECT `id`,`name`,`formMAId`,`formMAName`,`type`,`status`,`dtRA`,`dtMA`,`dtRE`,`dtEND`,`contract`,`san`,`can`,`ep_checklist`,`fu_1st`,`fu_3rd`,`clID`,$periodId,`formId` ";
$sql .= "FROM adt_ogx_gcdp  ";
$sql .= "WHERE periodId=$periodSrc ";
$db->insert($sql); 
//echo $sql;

echo "* GIPo <br />";

$sql =  "INSERT INTO `adt_ogx_gip` ";
$sql .= "(`id`,`name`,`formMAId`,`formMAName`,`type`,`status`,`dtRA`,`dtMA`,`dtRE`,`dtEND`,`contract`,`san`,`can`,`ep_checklist`,`fu_1st_week`,`fu_1st_month`,`fu_plus_45`,`fu_plus_90`,`fu_plus_135`,`fu_plus_180`,`fu_plus_225`,`fu_plus_270`,`fu_plus_315`,`fu_plus_360`,`clID`,`periodId`,`formId`) ";
$sql .= "SELECT `id`,`name`,`formMAId`,`formMAName`,`type`,`status`,`dtRA`,`dtMA`,`dtRE`,`dtEND`,`contract`,`san`,`can`,`ep_checklist`,`fu_1st_week`,`fu_1st_month`,`fu_plus_45`,`fu_plus_90`,`fu_plus_135`,`fu_plus_180`,`fu_plus_225`,`fu_plus_270`,`fu_plus_315`,`fu_plus_360`,`clID`,$periodId,`formId` ";
$sql .= "FROM `adt_ogx_gip` ";
$sql .= "WHERE periodId=$periodSrc ";
$db->insert($sql); 
//echo $sql;

$cls = array();
$sql = "SELECT * FROM cl ORDER BY name asc";
$cls = $db->select($sql);

echo "Click one each area to go to my@ and update forms for audit period '$periodId':<br/><br/>";

foreach ($cls as $cl){
	echo "CL $cl[name] (<a target=\"_blank\" href=\"deleteMonthData.php?cl=$cl[clID]&period=$periodId\">clear all</a>): <a target=\"_blank\" href=\"updateGCDPIFormsPerPeriod.php?cl=$cl[clID]&period=$periodId\">GCDPi</a>";
	echo " | <a target=\"_blank\" href=\"updateGIPIFormsPerPeriod.php?cl=$cl[clID]&period=$periodId\">GIPi</a>";
	echo " | <a target=\"_blank\" href=\"updateGCDPOFormsPerPeriod.php?cl=$cl[clID]&period=$periodId\">GCDPo</a>";
	echo " | <a target=\"_blank\" href=\"updateGIPOFormsPerPeriod.php?cl=$cl[clID]&period=$periodId\">GIPo</a><br/>";
	echo "<br/>";
}

?>