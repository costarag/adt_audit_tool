<?php

require_once "include.php";

$type = $_REQUEST['type'];

$clID = $_REQUEST['cl'];
$periodID = $_REQUEST['period'];
$form = $_REQUEST['form'];
$doc = $_REQUEST['doc'];
$comment = ISSET($_REQUEST['editStatusLegal_comment'])? $_REQUEST['editStatusLegal_comment'] : '';

// var_dump($clID);
// var_dump($periodID);
// var_dump($type);
// var_dump($form);
// var_dump($doc);
// var_dump($status);
// var_dump($comment);

$sql = "SELECT id from legal_item WHERE name='$form'";
//echo $sql;
$res = $db->select($sql);
if (count($res) > 0){
	$legalID = $res[0]['id'];
}


$sql = "SELECT `datetime`, l.user, `status`, lh.comment, '$form' AS doc FROM `legal_history` lh JOIN login l ON lh.userId=l.id WHERE lh.legalId=$legalID AND periodId=$periodID AND lh.clID=$clID ORDER BY datetime DESC";
//echo $sql;
$res = $db->select($sql);

print json_encode($res);

?>