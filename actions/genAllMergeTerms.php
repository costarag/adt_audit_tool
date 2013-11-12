<?php

require_once "include.php";

if (!ISSET($_REQUEST['src'])) die ("Inform period source.");
if (!ISSET($_REQUEST['des'])) die ("Inform period destination.");
$src 		= $_REQUEST['src'];
$des 		= $_REQUEST['des'];

$cls = array();
$sql = "SELECT * FROM cl ORDER BY name asc";
$cls = $db->select($sql);

foreach ($cls as $cl){
	echo "CL $cl[name]: <a target=\"_blank\" href=\"mergeTerms.php?src=$src&des=$des&clId=$cl[clID]\">Merge</a>";
	echo "<br/>";
}

?>