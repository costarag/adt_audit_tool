<?php

require_once "base/include.php";

$tns = array();

$sql = "SELECT * FROM cl ORDER by name ASC";
$tns = $db->select($sql);

print json_encode($tns);
