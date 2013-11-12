<?php

function newID() {
	$check_Forms = mysql_query("SELECT * FROM forms where Type = 0");
	return (mysql_query($check_Forms) + 1);
}

?>