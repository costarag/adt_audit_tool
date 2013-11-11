<?php
require_once("include.php");

$myAiesec = new MyAiesec("ricardo.costa@aiesec.net", "katito023");

$aux = preg_replace('/\s+/', '', $_GET['form']);
$items = str_replace('%20', '', $aux);

$codes = explode(',',$items);
//print_r($codes);

$forms = array();

foreach ($codes as $code) {
	//echo "Current value of \$codes: $code.\n";

	$formId = (int)$myAiesec->searchForms($code,$code);
	if ($formId == 0){
		continue;
	}
	
	$busca = $myAiesec->viewTnForm($formId,$code);

	$obj["id"] = $code;

	$formType = (strtoupper(substr($code,0,2)) == "TN") ? "TN" : "EP";

	//var_dump($formType);

	//For TN
	if(stripos($busca, "The specified TN Form could not be loaded as it is in Incomplete Status.")){
		continue;
	}

	$posNAME = stripos($busca,"page-mainHeader-class");

	$start = $posNAME + 42;
	$end = stripos($busca,"</font>",$posNAME);

	//$name = str_replace("รก","แ",strip_tags(substr($busca,$start,$end-$start)));
	$name = substr($busca,$start,$end-$start);
	$obj["name"] = $name;
	
	$obj["formId"] = $formId;
	$obj["formType"] = $formType;

	$posEX = strripos($busca, "<b>Exchange Type</b>");
	$EX = str_replace("Exchange Type","",str_replace(".", "/",str_replace("\n", "",str_replace("\r","",strip_tags(substr($busca,$posEX,100))))));
	if (strpos($EX,"Global Internship") <> 0) $EX = "GIP";
	else  $EX = "GCDP";
	$obj["type"] = trim($EX);

	$posStatus = strripos($busca, "<b>Status</b>");
	if ($posStatus){
		$string = str_replace("Status","",str_replace(".", "/",str_replace("\n", "",str_replace("\r","",strip_tags(substr($busca,$posStatus,100))))));
		$obj["status"] = trim($string);

		if($obj["status"] == "Incomplete"){// || $obj["status"] == "Rejected"){
			continue;
		}
	}else{
		$obj["status"] = "";
	}

	$pos = strripos($busca, "<b>Raised Date</b>");
	$RA_Date = substr($busca,$pos,84);
	$RA_Date = str_replace(".","/",substr(strip_tags($RA_Date),-10));
	$obj["dtRA"] = $RA_Date;

	$posMA = strripos($busca, "Matched Date");
	if ($posMA){
		$string = str_replace(".", "/",substr(str_replace("\n", "",str_replace("\r","",strip_tags(substr($busca,$posMA,40)))),-10));
		$obj["dtMA"] = $string;

		//If Matched search for TN/EP matched details
		if ($formType == "TN"){
			//EP Id
			$posMAForm = strripos($busca, "EP Id");
			$start = $posMAForm + 23;
			$end = stripos($busca,"</td>",$start);
			$formMAId = trim(substr($busca,$start,$end-$start));
			//var_dump($formMAId); 
			$obj["formMAId"] = $formMAId;
			
			//EP Name
			$posMAForm = strripos($busca, "EP Name");
			$start = $posMAForm + 25;
			$end = stripos($busca,"</td>",$start);
			$formMAName = trim(substr($busca,$start,$end-$start));
			//var_dump($formMAName); 
			$obj["formMAName"] = $formMAName;
		}else{
			//TN Id
			$posMAForm = strripos($busca, "TN Id");
			$start = $posMAForm + 14;
			$end = stripos($busca,"</td>",$start);
			$formMAId = trim(substr($busca,$start,$end-$start));
			//var_dump($formMAId); 
			$obj["formMAId"] = $formMAId;
			
			//TN Name
			$posMAForm = strripos($busca, "Organisation Name");
			$start = $posMAForm + 26;
			$end = stripos($busca,"</td>",$start);
			$formMAName = trim(substr($busca,$start,$end-$start));
			//var_dump($formMAName); 
			$obj["formMAName"] = $formMAName;
		}
	}else{
		$obj["dtMA"] = "";
		$obj["formMAId"] = "";
		$obj["formMAName"] = "";
	}

	$posRE = strripos($busca, "Realized Date");
	if ($posRE){
		$string = str_replace(".", "/",substr(str_replace("\n", "",str_replace("\r","",strip_tags(substr($busca,$posRE,41)))),-10));
		$obj["dtRE"] = $string;
	}else{
		$obj["dtRE"] = "";
	}

	$posEND = strripos($busca, "Internship End date");
	if ($posEND){
		$string = str_replace(".", "/",substr(str_replace("\n", "",str_replace("\r","",strip_tags(substr($busca,$posEND,48)))),-10));
		$obj["dtEND"] = $string;
	}else{
		$obj["dtEND"] = "";
	}

	$forms[] = $obj;
}

print json_encode($forms);
