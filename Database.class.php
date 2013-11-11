<?php

class Database {
	private $conn = null;
	
// 	private $dbhost = "mysql2.000webhost.com";
// 	private $dbname = "a4801646_adt";
// 	private $dbuser = "a4801646_adt";
// 	private $dbpass = "adt123";
	
	private $dbhost = "localhost";
	private $dbuser = "adt";
	private $dbpass = "123456";
	private $dbname = "adt";
	
// 	private $dbhost = "adt.aiesec.org.br";
// 	private $dbuser = "adtaiesec";
// 	private $dbpass = "a##d%*t##%532";
// 	private $dbname = "adtaiesec";
	
	private $dbport = "3306";
	private $opencursor = null;

	public function __construct(){
		$this->connect();
	}

	// TODO: fix (robust++)
	public function connect() {
		$dsn = "mysql:host=" . $this->dbhost . ";dbname=" . $this->dbname . ";port=" . $this->dbport;
		try {
			// $this->conn = new PDO($dsn, $this->dbuser, $this->dbpass);
			$this->conn = new PDO($dsn, $this->dbuser, $this->dbpass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			return $this->conn;
		} catch (Exception $e) {
			echo $e;
			return false;
		}
	}

	public function isAvailable() {
		if($this->conn === null ) {
			$ret = $this->connect();
			if ($ret === false) {
				return false;
			}
		}

		if ($this->opencursor != null) {
			trigger_error("There is another cursor already open on the " . $this->dbname . " database.", E_USER_WARNING);
			return false;
		}

		return true;
	}

	public function select($sql, $parameters=array()) {
		if ($this->isAvailable() === false) {
			return false;
		}

		try {
			$statement = $this->conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
			$statement->execute($parameters);
			$res = $statement->fetchAll(PDO::FETCH_ASSOC);
			$statement->closeCursor();
			#$this->conn = null;
			return $res;
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function select2($sql, $parameters=array()) {
		if ($this->isAvailable() === false) {
			return false;
		}

		try {
			$statement = $this->conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
			$statement->execute($parameters);
			$res = $statement->fetchAll(PDO::FETCH_NUM);
			$statement->closeCursor();
			#$this->conn = null;
			return $res;
		} catch (Exception $e) {
			return false;
		}
	}

	public function insert($sql, $parameters=array()) {
		if ($this->isAvailable() === false) {
			return false;
		}

		try {
			$statement = $this->conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
			$statement->execute($parameters);
			$statement->closeCursor();
			return true; // TODO: return auto increment?
		} catch (Exception $e) {
			return false;
		}
	}

	public function update($sql, $parameters=array()) {
		if ($this->isAvailable() === false) {
			return false;
		}

		try {
			$statement = $this->conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
			$statement->execute($parameters);
			$statement->closeCursor();
			return true; // TODO: change return?
		} catch (Exception $e) {
			return false;
		}
	}

	public function delete($sql, $parameters=array()) {
		if ($this->isAvailable() === false) {
			return false;
		}

		try {
			$statement = $this->conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
			$statement->execute($parameters);
			$statement->closeCursor();
			return true; // TODO: change return?
		} catch (Exception $e) {
			return false;
		}
	}

	public function close_open_cursor() {
		if ($this->opencursor != null) {
			$this->opencursor->closeCursor();
			$this->opencursor = null;
		}
	}

	/**
	 * Executes an unbuffered query and stores the PDOStatement object in an internal variable
	 * The fetch_row method can be used to fetch data from this PDOStatement object
	 *
	 * @param string $sql The query to be executed
	 * @param array $parameters Query parameters
	 * @return true on success, false on failure
	 */
	public function select_unbuffered($sql, $parameters=array()) {
		if ($this->isAvailable() === false) {
			return false;
		}

		try {
			$statement = $this->conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
			$statement->execute($parameters);
			$this->opencursor = $statement;
			return true;
		} catch (Exception $e) {
			return false;
		}
	}

	/**
	 * Fetches a the next row from an open cursor if it exists
	 * Closes the cursor if at the end of the result set
	 *
	 * @return Returns the row on success, false on failure
	 */
	public function fetch_row() {
		if ($this->opencursor === null) {
			return false;
		}

		$row = $this->opencursor->fetch(PDO::FETCH_ASSOC);
		if ($row === false) {
			$this->close_open_cursor();
			return false;
		}
		return $row;
	}

	/**
	 * Escapes MySql data properly, using this DB object's connection handle.
	 *
	 * @return String Escaped data, ready for insertion into the database.
	 */
	public function real_escape_string( $text ) {
		return $this->conn->quote($text);//TODO fix to get handle from PDO
		//return mysql_real_escape_string( $text, $this);

	}

	/**
	 * Escapes MySql data, but checks whether magic quotes are on or off first.
	 *
	 * If magic quotes are ON, first strips slashes, then escapes properly. If magic
	 * quotes are OFF, just go directly for the escape function.
	 *
	 * This method assumes that the data in $text is HTTP Request data (GET, POST,
	 * or COOKIE). If it isn't, use the real_escape_string() method instead.
	 *
	 * @return String Escaped data, ready for insertion into the database.
	 */
	public function escape( $text ) {

		return
		( get_magic_quotes_gpc() ?
		$this->real_escape_string( stripslashes( $text ) ) :
		$this->real_escape_string( $text ) );

	}

	//TODO fix, either remove method or add functionality
	public function &select_assoc( $query ) {
		return $this->select($query);

	}
}
