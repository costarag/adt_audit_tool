<?php

require_once ("Util.class.php");

class DoRequest {
	private static $userAgent = "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.94 Safari/537.4";
	// private static $acceptType = "*/*";
	private static $acceptEncoding = "gzip,deflate,sdch";
	private static $acceptType = "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8";
	private static $acceptCharset = "ISO-8859-1,utf-8;q=0.7,*;q=0.3";
	//private static $acceptLanguage = "pt-BR,pt;q=0.8,en-US;q=0.6,en;q=0.4";
	private static $acceptLanguage = "en-GB,en;q=0.8";
	private static $cacheControl = "max-age=0";
	private static $origin = "http://www.myaiesec.net";

	private static $proxy = array();

	private $_url = "";
	private $_chHandler = null;

	private $_cookies = "";

	//Get properties
	private $_queryString = "";

	//Post properties
	private $_posts;

	private $_ajax = false;
	private $_gzip = false;

	private $_headerLength;
	private $_headersParsed;
	private $_responseProxyHeaders;
	private $_responseHeaders;
	private $_responseBody;
	private $_strResponse;

	public function __construct($url) {
		$this -> _url = $url;
		$this -> _chHandler = curl_init($this -> _url);
	}

	public function setCookies($cookies) {
		$this -> _cookies = $cookies;
	}

	public static function SetProxyConfs($proxyConfs) {
		self::$proxy = $proxyConfs;
	}

	public function setQueryString($queryString) {
		throw new Exception("Please, put your query strings in URL properties.");
		$this -> _queryString = $queryString;
	}

	public function setPosts($posts) {
		$this -> _posts = $posts;
	}

	public function setUserAgent($userAgent) {
		self::$userAgent = $userAgent;
	}

	public function getResponseHeaders() {
		return $this -> _headersParsed;
	}

	public function getResponseProxyHeaders() {
		return $this -> _responseProxyHeaders;
	}

	public function getResponseBody() {
		return $this -> _responseBody;
	}

	public function getHeaderLength() {
		return $this -> _headerLength;
	}

	public function getCookies() {
		return $this -> _cookies;
	}

	public function setAjax($ajax) {
		$this -> _ajax = $ajax;
	}

	public function setGzip($gzip) {
		$this -> _gzip = $gzip;
	}

	public function parseHeaders() {
		//echo "full HEADER: ".$this -> _responseHeaders."<br/>";
		$lines = explode("\r\n", $this -> _responseHeaders);
		$this -> _headersParsed = array();
		foreach ($lines as $line) {
			//echo "Request header: ".$line ."<br />";
			$exp = explode(":", $line);
			//echo $line."\n";
			//if (isset($exp) && isset($exp[0]) && isset($exp[1]))
				
			//			$item = "";
			//			for ($i = 1; $i <= sizeof($exp); $i++) {
			//		    	if(isset($exp[$i])){
			//		    		echo $exp[$i] ."      \n";
			//		    		$item .= $exp[$i];
			//		    	}
			//			}
				
			$this -> _headersParsed[trim($exp[0])] = isset($exp[1]) ? $exp[1] : "";
		}
		if (array_key_exists("Set-Cookie", $this -> _headersParsed)) {
			$exp = explode(";", $this -> _headersParsed["Set-Cookie"]);
//			echo "Cookie: ";
//			var_dump($exp);
			$item = "";
			for ($i = 1; $i <= sizeof($exp); $i++) {
				if(isset($exp[$i])){
					//echo $exp[$i] ."      \n";
					$item .= $exp[$i];
				}
			}
			$this -> _cookies = $exp[0];
		}
	}

	public function get() {
		curl_setopt($this -> _chHandler, CURLOPT_CUSTOMREQUEST, "GET");

		$this -> setCommonHeaders();

		$this -> _strResponse = curl_exec($this -> _chHandler);
		$this -> _headerLength = curl_getinfo($this -> _chHandler, CURLINFO_HEADER_SIZE);
//		if (sizeof(self::$proxy) > 0) {
//			list($this -> _responseProxyHeaders, $this -> _responseHeaders, $this -> _responseBody) = explode("\r\n\r\n", $this -> _strResponse, 3);
//		} else {
//			list($this -> _responseHeaders, $this -> _responseBody) = explode("\r\n\r\n", $this -> _strResponse, 2);
//		}
		$this->_responseHeaders = substr($this->_strResponse, 0, $this->_headerLength+1);
		$this->_responseBody = substr($this->_strResponse, $this->_headerLength);
		
		$this -> parseHeaders();
		return $this -> _strResponse;
	}

	public function post() {
		curl_setopt($this -> _chHandler, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($this -> _chHandler, CURLOPT_POST, 1);

		$this -> setCommonHeaders();

		$this -> _strResponse = curl_exec($this -> _chHandler);

		$this -> _headerLength = curl_getinfo($this -> _chHandler, CURLINFO_HEADER_SIZE);
//		if (sizeof(self::$proxy) > 0) {
//			list($this -> _responseProxyHeaders, $this -> _responseHeaders, $this -> _responseBody) = explode("\r\n\r\n", $this -> _strResponse, 3);
//		} else {
//			list($this -> _responseHeaders, $this -> _responseBody) = explode("\r\n\r\n", $this -> _strResponse, 2);
//		}

		$this -> _responseHeaders = substr($this -> _strResponse, 0, $this -> _headerLength + 1);
		$this -> _responseBody = substr($this -> _strResponse, $this -> _headerLength, strlen($this -> _strResponse));

		$this -> parseHeaders();

		return $this -> _strResponse;
	}

	private function setCommonHeaders() {
		if (sizeof(self::$proxy) > 0) {
			curl_setopt($this -> _chHandler, CURLOPT_HTTPPROXYTUNNEL, true);
			curl_setopt_array($this -> _chHandler, self::$proxy);
		}

		curl_setopt($this -> _chHandler, CURLOPT_HEADER, true);
		curl_setopt($this -> _chHandler, CURLOPT_TIMEOUT, 50);
		curl_setopt($this -> _chHandler, CURLOPT_URL, $this -> _url);
		curl_setopt($this -> _chHandler, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($this -> _chHandler, CURLOPT_FAILONERROR, 1);
		curl_setopt($this -> _chHandler, CURLOPT_USERAGENT, self::$userAgent);

		//Extra
		curl_setopt($this -> _chHandler, CURLOPT_FOLLOWLOCATION, 1); // follow redirects

		if ($this -> _cookies != "") {
			//curl_setopt($this -> _chHandler, CURLOPT_COOKIE, "JSESSIONID=3174E64AFE4BDF775E0D1A49DE23B77D");
            curl_setopt($this->_chHandler, CURLOPT_COOKIE, $this->_cookies);
		}

		if ($this -> _posts != "") {
			curl_setopt($this -> _chHandler, CURLOPT_POSTFIELDS, $this -> _posts);
		}

		$httpHeaders = array("Referer: ".$this -> _url,"Connection: keep-alive", "Accept-Language: " . self::$acceptLanguage, "Accept-Charset: " . self::$acceptCharset, "Accept: " . self::$acceptType, "Accept-Encoding: " . self::$acceptEncoding, "Cache-Control: " . self::$cacheControl, "Origin: " . self::$origin);

		curl_setopt($this -> _chHandler, CURLOPT_ENCODING, TRUE);

		if ($this -> _ajax) {
			$httpHeaders[] = "Content-type: application/x-www-form-urlencoded";
			$httpHeaders[] = "Origin: http://www.myaiesec.net";
			$httpHeaders[] = "X-Requested-With: XMLHttpRequest";
			$httpHeaders[] = "X-Prototype-Version: 1.4.0";
		}
		curl_setopt($this -> _chHandler, CURLOPT_HTTPHEADER, $httpHeaders);
	}

	public function __destruct() {
		if ($this -> _chHandler) {
			curl_close($this -> _chHandler);
		}
	}

}
