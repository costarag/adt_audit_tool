<?php

require_once dirname(__FILE__) . "\..\include.php";

$multaDoc = 10;
$multaFU  = 5;

$res = array();

$cl=$period = $_GET["cl"];
$period = $_GET["period"];

$sqlOK = "SELECT COUNT(*) FROM legal l JOIN legal_item li ON l.legalID=li.id WHERE clID=$cl AND periodId=$period AND l.status IN ('OK')";
$sqlOK2 = "SELECT COUNT(*) FROM legal l JOIN legal_item li ON l.legalID=li.id WHERE clID=$cl AND periodId=$period AND l.status IN ('OK2')";
$sqlNE = "SELECT COUNT(*) FROM legal l JOIN legal_item li ON l.legalID=li.id WHERE clID=$cl AND periodId=$period AND l.status IN ('NE')";
$sqlNE2 = "SELECT COUNT(*) FROM legal l JOIN legal_item li ON l.legalID=li.id WHERE clID=$cl AND periodId=$period AND l.status IN ('NE2')";
$sqlNA = "SELECT COUNT(*) FROM legal l JOIN legal_item li ON l.legalID=li.id WHERE clID=$cl AND periodId=$period AND l.status IN ('NA')";
$sqlNA2 = "SELECT COUNT(*) FROM legal l JOIN legal_item li ON l.legalID=li.id WHERE clID=$cl AND periodId=$period AND l.status IN ('NA2')";

$res['legal']['ne'] = $db->select2($sqlNE);
$res['legal']['ne2'] = $db->select2($sqlNE2);
$res['legal']['na'] = $db->select2($sqlNA);
$res['legal']['na2'] = $db->select2($sqlNA2);
$res['legal']['ok'] = $db->select2($sqlOK);
$res['legal']['ok2'] = $db->select2($sqlOK2);

$sqlOK = "SELECT COUNT(*) FROM term t WHERE clID=$cl AND periodId=$period AND STATUS IN ('OK')";
$sqlOK2 = "SELECT COUNT(*) FROM term t WHERE clID=$cl AND periodId=$period AND STATUS IN ('OK2')";
$sqlNE = "SELECT COUNT(*) FROM term t WHERE clID=$cl AND periodId=$period AND STATUS IN ('NE')";
$sqlNE2 = "SELECT COUNT(*) FROM term t WHERE clID=$cl AND periodId=$period AND STATUS IN ('NE2')";
$sqlNA = "SELECT COUNT(*) FROM term t WHERE clID=$cl AND periodId=$period AND STATUS IN ('NA')";
$sqlNA2 = "SELECT COUNT(*) FROM term t WHERE clID=$cl AND periodId=$period AND STATUS IN ('NA2')";

$res['term']['ne'] = $db->select2($sqlNE);
$res['term']['ne2'] = $db->select2($sqlNE2);
$res['term']['na'] = $db->select2($sqlNA);
$res['term']['na2'] = $db->select2($sqlNA2);
$res['term']['ok'] = $db->select2($sqlOK);
$res['term']['ok2'] = $db->select2($sqlOK2);
//echo $res;

print json_encode($res);
