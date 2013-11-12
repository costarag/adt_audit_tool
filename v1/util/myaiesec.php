<?php

class MyAiesec {
	const SESS_NAME = "myAiesecCookie";

	const MYAIESEC_SEARCH_FORMS = 8;

	private $user;
	private $password;

	public $_pageLogin;

	public function __construct($user, $password) {
		$this -> user = $user;
		$this -> password = $password;

		$this -> doAuth();
	}

	public function doAuth() {
		if (!array_key_exists(self::SESS_NAME, $_SESSION) || $_SESSION[self::SESS_NAME] == "") {
			$r = new DoRequest("http://www.myaiesec.net/");
			$r -> get();
			$_SESSION[self::SESS_NAME] = $r -> getCookies();
			$_SESSION[self::SESS_NAME . "Time"] = time();

			$r = new DoRequest("http://www.myaiesec.net/login.do");
			$r -> setPosts("userName=" . urlencode($this -> user) . "&password=" . urlencode($this -> password));
			$r -> setCookies($_SESSION[self::SESS_NAME]);
			$r -> post();
			
			//session_start();
			//session_regenerate_id();
			
			$this -> _pageLogin = array("header" => $r -> getResponseHeaders(), "body" => $r -> getResponseBody());
		} else if (!array_key_exists(self::SESS_NAME . "Time", $_SESSION) || $_SESSION[self::SESS_NAME . "Time"] <= time() - 30 * 60) {
			unset($_SESSION[self::SESS_NAME]);
			$this -> doAuth();
		}
	}

	public function chkLogin() {
		$body = $this -> _pageLogin['body'];
		if (substr_count($body, "Forgot your username?</a>"))
			return TRUE;
		else
			return FALSE;
	}

	/*
	 * Search Types:
	 *  <option value="1">People</option>
	 <option value="2">Conversations</option>
	 <option value="3">News</option>
	 <option value="4">Projects</option>
	 <option value="5">Entity</option>
	 <option value="6">Contact Groups</option>
	 <option value="7">Files</option>
	 <option value="8">Forms</option> (the only one implemented)
	 <option value="9">Wikis</option>
	 <option value="10">Teams</option>
	 <option value="11">Organisations</option>
	 * Search Phrase:
	 *  the frase auiehiae
	 */
	public function search($searchType, $searchPhrase) {
		if ($searchType == self::MYAIESEC_SEARCH_FORMS) {
			$this -> searchForms($searchPhrase);
		}
	}

	/*
	 * @return: Must return the TN ID, or, "blank" for non existent TN form.
	 */
	public function searchForms($searchPhrase, $code) {
		$type = explode("-", $code);
		if ($type[0] == "TN")
			$r = new DoRequest("http://www.myaiesec.net/ajaxsearchform.do?operation=getTNId");
		else
			$r = new DoRequest("http://www.myaiesec.net/ajaxsearchform.do?operation=getEPId");
		$postStr = "email=&" . "support_username=&" . "support_firstname=&" . "support_lastname=&" . "support_country=&" . "support_committee=&" . "support_xp_stage=&" . "support_page_url=&" . "support_userprog=&" . "operation=&" . "searchvalue=&" . "normalSearchTitle=" . urlencode($searchPhrase) . "&" . "category=8&" . "cm=1000000256&" . "_=";
		$r -> setPosts($postStr);
		$r -> setCookies($_SESSION[self::SESS_NAME]);
		$r -> setAjax(true);
		$r -> post();

		return $r -> getResponseBody();
	}

	public function viewTnForm($tnId, $code) {
		$type = explode("-", $code);
		if ($type[0] == "TN")
			$r = new DoRequest("http://www.myaiesec.net/exchange/viewtn.do?operation=executeAction&tnId=" . $tnId);
		else
			$r = new DoRequest("http://www.myaiesec.net/exchange/viewep.do?operation=executeAction&epId=" . $tnId);
		$r -> setCookies($_SESSION[self::SESS_NAME]);
		$r -> get();
		return $r -> getResponseBody();
	}
	
	public function initSearchTNs($cl, $from, $to) {
		$r = new DoRequest("http://www.myaiesec.net/exchange/edittnsearch.do");
		$r -> setCookies($_SESSION[self::SESS_NAME]);
		$r -> get();
		
		$r = new DoRequest("http://www.myaiesec.net/exchange/tnmanagerexchangescope.do?operation=localList&isRoleBased=true&isRightMenu=false&committeeName=committeeId&allRequired=true");
		$r -> setCookies($_SESSION[self::SESS_NAME]);
		$r -> post();
	}
	
	public function searchTNs($cl, $from, $to, $type) {
		$r = new DoRequest("http://www.myaiesec.net/exchange/edittnsearchresult.do?page=1");
		$postStr = "reviewtnid=&" . "tnselectid=&" . "criteria=1&" . "exchangeScope=4&" . "mccommiteecommitteeId=13426721&" . "committeeId=".$cl."&" . "tnid=&" . "statlist=".$type."&" . "orgname=&" . "orglist=0&" . "busilist=0&" . "xlist=0&" . "datefrom=".$from."&" . "dateto=".$to."&" . "ok=Search&". "page=1";
		$r -> setPosts($postStr);
		$r -> setCookies($_SESSION[self::SESS_NAME]);
		$r -> post();

		return $r -> getResponseBody();
	}
	
	public function initSearchEPs($cl, $from, $to) {
		$r = new DoRequest("http://www.myaiesec.net/exchange/edittnsearch.do");
		$r -> setCookies($_SESSION[self::SESS_NAME]);
		$r -> get();
		
		$r = new DoRequest("http://www.myaiesec.net/exchange/editepsearch.do?opern=loadEPSearch");
		$postStr = "reviewtnid=&tnselectid=&criteria=2&tnid=&statlist=0&orgname=&orglist=0&busilist=0&xlist=0&datefrom=".$from."&dateto=".$to."";
		$r -> setPosts($postStr);
		$r -> setCookies($_SESSION[self::SESS_NAME]);
		$r -> post();
		
		$r = new DoRequest("http://www.myaiesec.net/exchange/epmanagerexchangescope.do?operation=localList&isRoleBased=true&isRightMenu=false&committeeName=commId&allRequired=true");
		$r -> setCookies($_SESSION[self::SESS_NAME]);
		$r -> post();
	}
	
	public function searchEPs($cl, $from, $to, $type) {
		

		$r = new DoRequest("http://www.myaiesec.net/exchange/editepsearch.do?opern=epSearchResult");

		//$postStr = "reviewtnid=&" . "tnselectid=&" . "criteria=1&" . "exchangeScope=4&" . "mccommiteecommitteeId=13426721&" . "committeeId=".$cl."&" . "tnid=&" . "statlist=".$type."&" . "orgname=&" . "orglist=0&" . "busilist=0&" . "xlist=0&" . "datefrom=".$from."&" . "dateto=".$to."&" . "ok=Search&". "page=1";
		$postStr = "snId=&epid=&statusCmb=&isepsearch=true&opern=epSearchResult&searchTNResult=true&criteria=2&exchangeScope=4&mccommiteecommId=13426721&commId=".$cl."&snid=&snstatus=".$type."&firstname=&lastname=&xtype=0&datefrom=".$from."&dateto=".$to."&ok=Search";
		$r -> setPosts($postStr);
		$r -> setCookies($_SESSION[self::SESS_NAME]);
		$r -> post();

		return $r -> getResponseBody();
	}

}
