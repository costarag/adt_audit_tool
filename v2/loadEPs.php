<?php

require_once "base/include.php";

$cl = $_GET['cl'];
$from = $_GET['from'];
$to = $_GET['to'];

$types = array(3,4,6,9);
//$types = explode(',',$types_aux);

$tns = array();

// find match id
$sql = "SELECT * from adt.ep_form WHERE clID=$cl";
$tns = $db->select($sql);

print json_encode($tns);
