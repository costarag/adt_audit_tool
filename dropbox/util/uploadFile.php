<?php

// Require the bootstrap
require_once('bootstrap.php');

//echo $_FILES['value']['tmp_name'];

$file = $_FILES['value']['tmp_name'];
//TODO: GET LC, DOC TYPE and AREA.
//$LC = ...
//$DOC_TYPE = ...
//$AREA = 

// Upload the file
$put = $dropbox->putFile($file, basename( $_FILES['value']['name']), 'TNA/2013/1_NPM',true);

//var_dump($put);

//TODO: Check output before return

//TODO: Save on DB.

echo 'OK';

?>
