<?php

require_once("include.php");

function getUserId($user) {
	$user = $db->select("SELECT id FROM login WHERE user = '" . $user ."'");

	if(count($user) <> 0)
		return $user[0]['id'];
	else
		return 0;
}

function getUser($username) {
	$user = $db->select("SELECT * FROM login WHERE user = '" . $username ."'");

	if(count($user) <> 0)
		return $user[0];
	else
		return 0;
}

function insertUser($user,$type = 0) {
	$db->insert("INSERT INTO login (user,type) VALUES ('" . $user . "', $type )");
}


function get ($limit = 1000000000) {
	$rows = array();
	$res = mysql_query('SELECT * FROM articles ORDER BY pub_date DESC LIMIT 0, ' . $limit);

	while ($row = mysql_fetch_assoc($res)) {
		$rows[] = $row;
	}

	return count($rows) ? $rows : false;
}

function insert ($fields) {
	mysql_query('INSERT INTO articles (title, content) VALUES ("' . $fields['title'] . '", "' . $fields['content'] . '")');

	return mysql_insert_id();
}

function update ($fields, $id) {
	mysql_query('UPDATE articles SET title = "' . $fields['title'] . '" content = "' . $fields['content'] . '" WHERE articles_id = ' . $id);
}

function delete ($id) {
	mysql_query('DELETE FROM articles WHERE articles_id = ' . $id);
}
