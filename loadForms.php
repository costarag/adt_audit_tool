<?php

require_once "include.php";

$res = array();

$cl = $_GET['cl'];
$period = $_GET['period'];

$sql = "SELECT * from period WHERE id=$period";
$per = $db->select($sql);
$res['isMonthly'] = $per[0]['isMonthly'];

if($res['isMonthly'] == 1){
	$sql = "SELECT * from adt_icx_gcdp WHERE clID=$cl AND periodId=$period and status not in ('On Hold','Rejected','Expired','New','') ORDER BY dtRA ASC";
	$gcdpi = $db->select($sql);
	$res['gcdpi'] = $gcdpi;

	$sql = "SELECT * from adt_ogx_gcdp WHERE clID=$cl AND periodId=$period and status not in ('On Hold','Rejected','Expired','New','') ORDER BY dtRA ASC";
	$gcdpo = $db->select($sql);
	$res['gcdpo'] = $gcdpo;

	$sql = "SELECT * from adt_icx_gip WHERE clID=$cl AND periodId=$period and status not in ('On Hold','Rejected','Expired','New','') ORDER BY dtRA ASC";
	$gipi = $db->select($sql);
	$res['gipi'] = $gipi;

	$sql = "SELECT * from adt_ogx_gip WHERE clID=$cl AND periodId=$period and status not in ('On Hold','Rejected','Expired','New','') ORDER BY dtRA ASC";
	$gipo = $db->select($sql);
	$res['gipo'] = $gipo;
}else{
	$sql = "SELECT t.name, t.status, t.id, t.comment from term t WHERE clID=$cl AND periodId=$period AND status IN ('OK','OK2','NE','NE2','NA','NA2') ORDER BY t.name ASC";
	$names = $db->select($sql);
	$res['terms'] = $names;

	$sql = "SELECT li.id, li.name, l.status, l.comment from legal l JOIN legal_item li ON l.legalID=li.id WHERE clID=$cl AND periodId=$period	";;
	$legal = $db->select($sql);
	$res['legal'] = $legal;
}

print json_encode($res);
