<?php

require_once dirname(__FILE__) . "\..\include.php";

$type = $_REQUEST['type'];

$clID = $_REQUEST['cl'];
$periodID = $_REQUEST['period'];
$form = $_REQUEST['form'];
$doc = $_REQUEST['doc'];

// var_dump($clID);
// var_dump($periodID);
// var_dump($type);
// var_dump($form);
// var_dump($doc);
// var_dump($status);
// var_dump($comment);

$sql = "SELECT `datetime`, l.user, `status`, `comment`, '$doc' AS doc FROM form_history lh JOIN login l ON lh.userId=l.id WHERE doc='$doc' AND form='$form' AND periodId=$periodID ORDER BY DATETIME DESC"; //AND lh.clID=$clID 
//echo $sql;
$res = $db->select($sql);

print json_encode($res);

?>