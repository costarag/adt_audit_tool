<?php

require_once("include.php");

$myAiesec = new MyAiesec($_POST['user'], $_POST['pass']);

if ($myAiesec->chkLogin()) {

	$_SESSION['user']['email'] = $_POST['user'];

	$user = $db->select("SELECT * FROM login WHERE user = '" . $_POST['user'] ."'");
	
	if(count($user) == 0) {
		$db->insert("INSERT INTO login (user,type) VALUES ('" . $_POST['user'] . "', 0 )");
	}
	
	$user = $db->select("SELECT * FROM login WHERE user = '" . $_POST['user'] ."'");
	
	$_SESSION['user']['id'] = $user[0]['id'];
	$_SESSION['user']['type'] = $user[0]['type'];
	
	$db->insert("INSERT INTO login_history (loginId,datetime) VALUES (" . $user[0]['id'] . ", NOW() )");

	header("location: index.php");

}
else {
	header("location: login.php?m=Ops. Login or password invalid.");
}

?>