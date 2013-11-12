<?php
class TNForm{

	private $_id;
	private $_org;
	private $_type;

	private $_epId;
	private $_epName;

	private $_status;

	private $_dtRA;
	private $_dtMA;
	private $_dtRE;
	private $_dtEND;

	public function __construct($id) {
		$this -> _id = $id;
	}

	public function setOrg($org) {
		$this -> _org = $org;
	}

	public function setType($type) {
		$this -> _type = $type;
	}

	public function setRA($ra) {
		$this -> _dtRA = $ra;
	}

	public function setMA($ma) {
		$this -> _dtMA = $ma;
	}

	public function setRE($re) {
		$this -> _dtRE = $re;
	}

	public function setEND($end) {
		$this -> _dtEND = $end;
	}

	public function setStatus($status) {
		$this -> _status = $status;
	}

	public function setEpId($epId) {
		$this -> _epId = $epId;
	}

	public function setEpName($epName) {
		$this -> _epName = $epName;
	}

	// GETS

	public function getDtRA() {
		return $this -> _dtRA;
	}

}
?>
