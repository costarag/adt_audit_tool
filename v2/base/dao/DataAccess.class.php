<?php
class DataAccess{
	public $db=null;
	function __construct(){
		$this->db = new Database("adt");
		$this->db->connect();
	}
}
