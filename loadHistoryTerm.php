<?php

require_once "include.php";

$type = $_REQUEST['type'];

$clID = $_REQUEST['cl'];
$periodID = $_REQUEST['period'];
$form = $_REQUEST['form'];

// var_dump($clID);
// var_dump($periodID);
// var_dump($type);
// var_dump($form);
// var_dump($doc);
// var_dump($status);
// var_dump($comment);

$sql = "SELECT `datetime`, l.user, `status`, `comment` FROM term_history lh JOIN login l ON lh.userId=l.id WHERE name='$form' AND periodId=$periodID AND lh.clID=$clID ORDER BY DATETIME DESC"; //AND lh.clID=$clID 
//echo $sql;
$res = $db->select($sql);

print json_encode($res);

?>