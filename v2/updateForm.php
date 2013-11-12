<?php

require_once "base/include.php";

//$row = $_REQUEST['row_id'];
$field = $_REQUEST['field'];
$form = $_REQUEST['form'];
$column = $_REQUEST['column'];
$value = $_REQUEST['value'];

//var_dump($column);
//var_dump($value);
//echo $value;
//echo $form;

// find match id
$sql = "UPDATE tn_form SET $field='$value' WHERE id='$form'";
//echo $sql;
$db->update($sql);

echo $value;



?>