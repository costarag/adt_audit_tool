<?php

require_once "include.php";


$clID = $_REQUEST['cl'];
$periodID = $_REQUEST['period'];

$conclusao = $_REQUEST['conclusao'];
$melhoria = $_REQUEST['melhoria'];
$atencao = $_REQUEST['atencao'];

// var_dump($clID);
// var_dump($periodID);
 var_dump($conclusao);
// var_dump($form);
// var_dump($doc);
// var_dump($status);
// var_dump($comment);

//string(20) "Declaraчуo de RAIS"
//string(6) "status"
//string(1) "3"
//string(0) ""

 $sql = "SELECT id from conclusao WHERE periodId=$periodID AND clID=$clID";
 
 $res = $db->select($sql);
 if (count($res) > 0){
 	$conclusaoID = $res[0]['id'];
	$sql = "UPDATE conclusao SET conclusao='$conclusao',melhoria='$melhoria',atencao='$atencao' WHERE clID=$clID AND periodId=$periodID";
	$db->update($sql);
 }else{
	$sql = "INSERT INTO conclusao(conclusao,melhoria,atencao,clId,periodId) values ('$conclusao','$melhoria','$atencao',$clID,$periodID)";
	$db->insert($sql);
 }


//header('HTTP/1.1 500 Internal Server');
//header('Content-Type: application/json');
//die("Error while trying to update '$form'. Please try again later.");

/*
//History
$userId = $_SESSION['user']['id'];
$sql = "INSERT INTO term_history(name,userId,status,clId,periodId,comment,datetime) VALUES ('$form',$userId,'$newStatus',$clID,$periodID,'$comment',NOW())";
//echo $sql;
$db->insert($sql);
*/


//$sql = "UPDATE tn_form SET $field='$value' WHERE id='$form'";
//echo $sql;
//$db->update($sql);

/*
$res = array();

$res['status'] = $newStatus;
$res['comment'] = $comment;

print json_encode($res);
*/



?>