<?php

//require_once "base/include.php";

//TODO: Get user type and load possible values according to it.

//"data"   : " {'OK':'OK','NE':'NE','NA':'NA','NE2':'NE2','NA2':'NA2','S':'S','-':'-'}",

$array['OK'] 	=  'OK';
$array['NE'] 	=  'NE';
$array['NA'] 	=  'NA';
$array['NE2'] 	=  'NE2';
$array['NA2'] 	=  'NA2';
$array['S'] 	=  'S';
$array['-'] 	=  '-';

print json_encode($array);
