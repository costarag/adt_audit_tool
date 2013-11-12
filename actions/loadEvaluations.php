<?php

require_once "include.php";

$cl=$period = $_GET["cl"];
$period = $_GET["period"];

$tn1 = "SELECT id, `name` AS company FROM tn_form WHERE `tn1`='NE' AND clID=$cl AND periodId=$period";
$tn2 = "SELECT id, `name` AS company FROM tn_form WHERE `tn2`='NE' AND clID=$cl AND periodId=$period";
$tn3 = "SELECT id, `name` AS company FROM tn_form WHERE `tn3`='NE' AND clID=$cl AND periodId=$period";

$tr1 = "SELECT id, `formMAName` AS trainee FROM tn_form WHERE `tr1`='NE' AND clID=$cl AND periodId=$period";
$tr2 = "SELECT id, `formMAName` AS trainee FROM tn_form WHERE `tr2`='NE' AND clID=$cl AND periodId=$period";
$tr3 = "SELECT id, `formMAName` AS trainee FROM tn_form WHERE `tr3`='NE' AND clID=$cl AND periodId=$period";	

$ep1 = "SELECT id, `name` FROM ep_form WHERE `ep1`='NE' AND clID=$cl AND periodId=$period";
$ep2 = "SELECT id, `name` FROM ep_form WHERE `ep2`='NE' AND clID=$cl AND periodId=$period";
$ep3 = "SELECT id, `name` FROM ep_form WHERE `ep3`='NE' AND clID=$cl AND periodId=$period";

$res = array();

$res['tn1'] = $db->select2($tn1);
$res['tn2'] = $db->select2($tn2);
$res['tn3'] = $db->select2($tn3);

$res['tr1'] = $db->select2($tr1);
$res['tr2'] = $db->select2($tr2);
$res['tr3'] = $db->select2($tr3);

$res['ep1'] = $db->select2($ep1);
$res['ep2'] = $db->select2($ep2);
$res['ep3'] = $db->select2($ep3);

print json_encode($res);

