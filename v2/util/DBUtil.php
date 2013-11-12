<?php
class DBUtil {
	public static function get ($limit = 1000000000) {
		$rows = array();
		$res = mysql_query('SELECT * FROM articles ORDER BY pub_date DESC LIMIT 0, ' . $limit);

		while ($row = mysql_fetch_assoc($res)) {
			$rows[] = $row;
		}

		return count($rows) ? $rows : false;
	}

	public static function insert ($fields) {
		mysql_query('INSERT INTO articles (title, content) VALUES ("' . $fields['title'] . '", "' . $fields['content'] . '")');

		return mysql_insert_id();
	}

	public static function update ($fields, $id) {
		mysql_query('UPDATE articles SET title = "' . $fields['title'] . '" content = "' . $fields['content'] . '" WHERE articles_id = ' . $id);
	}

	public static function delete ($id) {
		mysql_query('DELETE FROM articles WHERE articles_id = ' . $id);
	}
}
?>

