<?php

require_once "include.php";

$type = $_REQUEST['type'];
$period = $_REQUEST['period'];
$form = $_REQUEST['form'];
$doc = $_REQUEST['doc'];
$status = $_REQUEST['status'];
$commentField = '';

switch($type) {
	case "icx_gcdp":
		$commentField = "editStatusGCDPI_comment";
		break;
	case "icx_gip":
		$commentField = "editStatusGIPI_comment";
		break;
	case "ogx_gcdp":
		$commentField = "editStatusGCDPO_comment";
		break;
	case "ogx_gip":
		$commentField = "editStatusGIPO_comment";
		break;
	default:
		$commentField = "editStatus_comment";
		break;
}

$comment = ISSET($_REQUEST[$commentField])? $_REQUEST[$commentField] : '';

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
//var_dump($newStatus);

$sql = "SELECT $doc FROM `adt_".$type."` tf WHERE tf.id='$form' AND periodId=$period";
// $sql;
$res = $db->select($sql);
//var_dump($res);
if (count($res) > 0){
	$current = $res[0][$doc];
}
//var_dump($current);

if ($current <> $newStatus){
	//echo "Current status of $form is '$current' and new value is '$newStatus'. Will update DB.\n";
	$sql = "UPDATE `adt_".$type."` SET $doc='$newStatus',comment_$doc='$comment' WHERE id='$form' AND periodId=$period";
	//echo $sql;
	$db->update($sql);
}else{
	//echo "Equal. Nothing to do.";
}

//header('HTTP/1.1 500 Internal Server');
//header('Content-Type: application/json');
//die("Error while trying to update '$form'. Please try again later.");

//History
$userId = $_SESSION['user']['id'];
$sql = "INSERT INTO form_history(form,userId,doc,status,periodId,comment,datetime) VALUES ('$form',$userId,'$doc','$newStatus',$period,'$comment',NOW())";
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