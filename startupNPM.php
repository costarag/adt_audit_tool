<?php

require_once "include.php";

$res = array();

$cls = array();
$sql = "SELECT * FROM cl ORDER by name ASC";
$cls = $db->select($sql);

$res["cls"] = $cls;

$periods = array();
$sql = "SELECT * FROM period where id = 1 ORDER by id DESC";
$periods = $db->select($sql);

$res["periods"] = $periods;

$docStatus = array();
$sql = "SELECT * FROM doc_status ORDER by id ASC";
$docStatus = $db->select($sql);

$res["docStatus"] = $docStatus;

$auditStatus = array();
$sql = "SELECT * FROM audit_status_type ORDER by id ASC";
$auditStatus = $db->select($sql);

$res["auditStatus"] = $auditStatus;

$isAuditor = 0; //False

if( isset($_SESSION['user']['type']) && $_SESSION['user']['type'] == 1 ){
	$isAuditor = 1;
}

$res["isAuditor"] = $isAuditor;

//TODO: Get user type and load possible values according to it.
//"data"   : " {'OK':'OK','NE':'NE','NA':'NA','NE2':'NE2','NA2':'NA2','S':'S','-':'-'}",

print json_encode($res);
