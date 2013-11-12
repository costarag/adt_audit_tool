<?php

require_once "include.php";

$type = $_REQUEST['type'];

$clID = $_REQUEST['cl'];
$periodID = $_REQUEST['period'];
//$form = $_REQUEST['form'];
//$form = iconv('UTF-8', 'ISO-8859-1', $_REQUEST['form']);
$form = $_REQUEST['form'];
$doc = $_REQUEST['doc'];
$status = $_REQUEST['status'];
$comment = ISSET($_REQUEST['editStatusTerm_comment'])? $_REQUEST['editStatusTerm_comment'] : '';

//var_dump($clID);
//var_dump($periodID);
// //var_dump($type);
//var_dump($form);
//var_dump($doc);
//var_dump($status);
//var_dump($comment);

//string(20) "Declaração de RAIS"
//string(6) "status"
//string(1) "3"
//string(0) ""

$sql = "SELECT status from doc_status WHERE id=$status";
$res = $db->select($sql);
if (count($res) > 0){
	$newStatus = $res[0]['status'];
}

//var_dump("New: ".$newStatus);

$sql = "SELECT id from term WHERE name like '%$form%' AND periodId=$periodID AND clID=$clID";
//echo $sql;
$res = $db->select($sql);
if (count($res) > 0){
	$termID = $res[0]['id'];
}

//var_dump($legalID);

$sql = "SELECT status FROM `term` t WHERE t.id=$termID AND periodId=$periodID AND clID=$clID";
// echo $sql;
$res = $db->select($sql);
//var_dump($res);
if (count($res) > 0){
	$current = $res[0]['status'];
}
//var_dump($current);

if ($current <> $newStatus){
	//echo "Current status of $form is '$current' and new value is '$newStatus'. Will update DB.\n";
	$sql = "UPDATE term SET status='$newStatus',comment='$comment' WHERE clID=$clID AND id=$termID AND periodId=$periodID";
	$db->update($sql);
}else{
	//echo "Equal. Nothing to do.";
}

//header('HTTP/1.1 500 Internal Server');
//header('Content-Type: application/json');
//die("Error while trying to update '$form'. Please try again later.");

//History
$userId = $_SESSION['user']['id'];
$sql = "INSERT INTO term_history(name,userId,status,clId,periodId,comment,datetime) VALUES ('$form',$userId,'$newStatus',$clID,$periodID,'$comment',NOW())";
//echo $sql;
$db->insert($sql);


//$sql = "UPDATE tn_form SET $field='$value' WHERE id='$form'";
//echo $sql;
//$db->update($sql);

$res = array();

$res['status'] = $newStatus;
$res['comment'] = $comment;

print json_encode($res);




?>