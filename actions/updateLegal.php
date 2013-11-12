<?php

require_once "include.php";

$type = $_REQUEST['type'];

$clID = $_REQUEST['cl'];
$periodID = $_REQUEST['period'];
$form = $_REQUEST['form'];
$doc = $_REQUEST['doc'];
$status = $_REQUEST['status'];
$comment = ISSET($_REQUEST['editStatusLegal_comment'])? $_REQUEST['editStatusLegal_comment'] : '';

// var_dump($clID);
// var_dump($periodID);
// var_dump($type);
// var_dump($form);
// var_dump($doc);
// var_dump($status);
// var_dump($comment);

$sql = "SELECT status from doc_status WHERE id=$status";
$res = $db->select($sql);
if (count($res) > 0){
	$newStatus = $res[0]['status'];
}

$sql = "SELECT id from legal_item WHERE name = '$form'";
$res = $db->select($sql);
if (count($res) > 0){
	$legalID = $res[0]['id'];
}

$sql = "SELECT status FROM `legal` l WHERE l.legalID=$legalID AND periodId=$periodID AND clID=$clID";
// echo $sql;
$res = $db->select($sql);
//var_dump($res);
if (count($res) > 0){
	$current = $res[0]['status'];
}
//var_dump($current);

if ($current <> $newStatus){
	//echo "Current status of $form is '$current' and new value is '$newStatus'. Will update DB.\n";
	$sql = "UPDATE legal SET status='$newStatus',comment='$comment' WHERE clID=$clID AND legalID=$legalID AND periodId=$periodID";
	$db->update($sql);
}else{
	//echo "Equal. Nothing to do.";
}

//header('HTTP/1.1 500 Internal Server');
//header('Content-Type: application/json');
//die("Error while trying to update '$form'. Please try again later.");

//History
$userId = $_SESSION['user']['id'];
$sql = "INSERT INTO legal_history(legalID,userId,status,clId,periodId,comment,datetime) VALUES ($legalID,$userId,'$newStatus',$clID,$periodID,'$comment',NOW())";
//echo $sql;
$db->insert($sql);


//$sql = "UPDATE tn_form SET $field='$value' WHERE id='$form'";
//echo $sql;
//$db->update($sql);

$res['status'] = $newStatus;
$res['comment'] = $comment;

print json_encode($res);





?>