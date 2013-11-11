<?php

require_once "base/include.php";

// find match id
$sql = "select * from adt.cl";
$res = $db->select($sql);
var_dump($res);