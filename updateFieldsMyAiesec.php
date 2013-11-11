<?php

ini_set('MAX_EXECUTION_TIME', -1);

require_once "include.php";

$myAiesec = new MyAiesec("ricardo.costa@aiesec.net", "katito023");

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Update date from My@.
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*
$sql = "SELECT * FROM ep_form";
$res = $db->select($sql);

echo "<b>Updating fields according to my@</b>\n<br/>";

foreach($res as $ep) {

	echo "Checking my@ status: $ep[id] \n<br/>";

	$formId = $ep['id'];
	$form = getFormMyAiesec($formId);

	if($ep['status'] <> $form['status']){
		$sql = "UPDATE ep_form SET status='$form[status]' WHERE id='$ep[id]' ";
		$db->update($sql);
		echo $sql.'<br/>';
	}

	//OLD: 2012-09-25
	//echo "OLD: $ep[dtRA] <br/>\n";
	//NEW: 25/09/2012
	//echo "NEW: $form[dtRA] <br/>\n";

	if($ep['formId'] <> $form['formId']){
		$sql = "UPDATE ep_form SET formId='$form[formId]' WHERE id='$ep[id]' ";
		$db->update($sql);
		echo $sql.'<br/>';
	}

	if($ep['type'] <> $form['type']){
		$sql = "UPDATE ep_form SET type='$form[type]' WHERE id='$ep[id]' ";
		$db->update($sql);
		echo $sql.'<br/>';
	}

	//Update formMAId if empty
	if($ep['formMAId'] <> $form['formMAId']){
		$sql = "UPDATE ep_form SET formMAId='$form[formMAId]' WHERE id='$ep[id]' ";
		$db->update($sql);
		echo $sql.'<br/>';
	}

	//Update formMAName if empty
	if($ep['formMAName'] <> $form['formMAName']){
		$sql = "UPDATE ep_form SET formMAName='$form[formMAName]' WHERE id='$ep[id]' ";
		$db->update($sql);
		echo $sql.'<br/>';
	}
}

echo "\n<br/>";

*/

$sql = "SELECT * FROM tn_form WHERE id ='TN-In-BR-CH-2010-22'";
$res = $db->select($sql);

echo "<b>Updating TNs fields according to my@</b>\n<br/>";

foreach($res as $ep) {

	echo "Checking my@ status: $ep[id] \n<br/>";

	$formId = $ep['id'];
	$form = getFormMyAiesec($formId);

	if($ep['status'] <> $form['status']){
		$sql = "UPDATE tn_form SET status='$form[status]' WHERE id='$ep[id]' ";
		$db->update($sql);
		echo $sql.'<br/>';
	}

	//OLD: 2012-09-25
	//echo "OLD: $ep[dtRA] <br/>\n";
	//NEW: 25/09/2012
	//echo "NEW: $form[dtRA] <br/>\n";

	/*
		if( DateTime::createFromFormat('Y-m-d', $ep['dtRA']) <> DateTime::createFromFormat('d/m/Y', $form['dtRA']) ){
	$sql = "UPDATE tn_form SET dtRA=STR_TO_DATE('$form[dtRA]','%d/%m/%Y') WHERE id='$ep[id]' ";
	$db->update($sql);
	echo $sql.'<br/>';
	}

	if( DateTime::createFromFormat('Y-m-d', $ep['dtMA']) <> DateTime::createFromFormat('d/m/Y', $form['dtMA']) ){
	$sql = "UPDATE tn_form SET dtMA=STR_TO_DATE('$form[dtMA]','%d/%m/%Y') WHERE id='$ep[id]' ";
	$db->update($sql);
	echo $sql.'<br/>';
	}

	if( DateTime::createFromFormat('Y-m-d', $ep['dtRE']) <> DateTime::createFromFormat('d/m/Y', $form['dtRE']) ){
	$sql = "UPDATE tn_form SET dtRE=STR_TO_DATE('$form[dtRE]','%d/%m/%Y') WHERE id='$ep[id]' ";
	$db->update($sql);
	echo $sql.'<br/>';
	}

	if( DateTime::createFromFormat('Y-m-d', $ep['dtEND']) <> DateTime::createFromFormat('d/m/Y', $form['dtEND']) ){
	$sql = "UPDATE tn_form SET dtEND=STR_TO_DATE('$form[dtEND]','%d/%m/%Y') WHERE id='$ep[id]' ";
	$db->update($sql);
	echo $sql.'<br/>';
	}
	*/

	if($ep['formId'] <> $form['formId']){
		$sql = "UPDATE tn_form SET formId='$form[formId]' WHERE id='$ep[id]' ";
		$db->update($sql);
		echo $sql.'<br/>';
	}

	if($ep['type'] <> $form['type']){
		$sql = "UPDATE tn_form SET type='$form[type]' WHERE id='$ep[id]' ";
		$db->update($sql);
		echo $sql.'<br/>';
	}

	//Update formMAId if empty
	if($ep['formMAId'] <> $form['formMAId']){
		$sql = "UPDATE tn_form SET formMAId='$form[formMAId]' WHERE id='$ep[id]' ";
		$db->update($sql);
		echo $sql.'<br/>';
	}

	//Update formMAName if empty
	if($ep['formMAName'] <> $form['formMAName']){
		$sql = "UPDATE tn_form SET formMAName='$form[formMAName]' WHERE id='$ep[id]' ";
		$db->update($sql);
		echo $sql.'<br/>';
	}
}

echo "\n<br/>";

function getFormMyAiesec($code){

	global $myAiesec;

	echo "Checking my@ for form: $code\n<br />";

	$formId = (int)$myAiesec->searchForms($code,$code);

	if ($formId == 0){
		return;
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

	return $obj;
}
