<?php

require_once "include.php";

$cl = $_GET['cl'];
$period = $_GET['period'];

$tns = array();

$sql = "SELECT * from ep_form WHERE clID=$cl AND periodId=$period and status not in ('On Hold','Rejected','Expired','')";;
$tns = $db->select($sql);

print json_encode($tns);
