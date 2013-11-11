<?php

require_once "include.php";

$cl = $_GET['cl'];
$period = $_GET['period'];

$tns = array();

$sql = "SELECT * from conclusao WHERE clID=$cl AND periodId=$period";
$tns = $db->select($sql);

print json_encode($tns);
