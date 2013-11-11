<?php

ini_set('max_execution_time', 300000000); //3000 seconds = 50 minutes

require_once "include.php";

$myAiesec = new MyAiesec("ricardo.costa@aiesec.net", "katito023");

if (!ISSET($_REQUEST['cl'])) die ("Inform CL.");
if (!ISSET($_REQUEST['period'])) die ("Inform period.");

$cl 		= $_REQUEST['cl'];
$periodId 	= $_REQUEST['period'];
//$cl 		= 1000000313;
//$periodId 	= 1;

$from = '';
$to = '';

$sql = "SELECT `from`, `to` FROM period WHERE id=$periodId";
$res = $db->select($sql);

if (count($res) > 0){
	$fromStr = $res[0]['from'];
	$toStr = $res[0]['to'];
	
	$from = new DateTime($res[0]['from']);
	$to = new DateTime($res[0]['to']);
	
	$interval = $from->diff($to);
	
	$dtThird = new DateTime($res[0]['from']);
	
	//echo "From: ".$res[0]['from']." to ". $res[0]['to'] . "\n<br />";
	//echo $interval->days . "<br />\n";
	//echo $interval->days/2 . "<br />\n";
	//	date_add($dtThird,new DateInterval('P'.intval($interval->days/2).'S'));
	date_add($dtThird,new DateInterval('P'.intval($interval->days/2).'D'));
	
	echo "Period: ".$periodId."<br/>\n";
	echo "From: ".date_format($from, 'Y-m-d')."<br/>\n";
	echo "To: ".date_format($to, 'Y-m-d')."<br/>\n<br/>\n<br/>\n";
	//echo "Third: ".date_format(getThird($from,$to), 'Y-m-d')."<br/>\n";
}else{
	echo "No period found.";
	die();
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Update docs status considering NE -> NE2, OK -> S, NE2 -> -
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$sql = "SELECT * FROM tn_form WHERE clID=$cl AND periodId=$periodId";
$res = $db->select($sql);
//echo "Total: "+count($res);
echo "<b>STEP 1</b>\n<br/>";

foreach($res as $tn) {
	echo "Updating pendencies: $tn[id] \n<br/>";

	$newTN = updateTN($tn);

	if($tn['contract'] <> $newTN['contract']){
		$sql = "UPDATE tn_form SET contract='$newTN[contract]' WHERE id = '$tn[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}
	if($tn['san'] <> $newTN['san']){
		$sql = "UPDATE tn_form SET san='$newTN[san]' WHERE id = '$tn[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}
	if($tn['can'] <> $newTN['can']){
		$sql = "UPDATE tn_form SET can='$newTN[can]' WHERE id = '$tn[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}
	if($tn['rne'] <> $newTN['rne']){
		$sql = "UPDATE tn_form SET rne='$newTN[rne]' WHERE id = '$tn[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}

	//TNS
	if($tn['tn1'] <> $newTN['tn1']){
		$sql = "UPDATE tn_form SET tn1='$newTN[tn1]' WHERE id = '$tn[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}
	if($tn['tn2'] <> $newTN['tn2']){
		$sql = "UPDATE tn_form SET tn2='$newTN[tn2]' WHERE id = '$tn[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}
	if($tn['tn3'] <> $newTN['tn3']){
		$sql = "UPDATE tn_form SET tn3='$newTN[tn3]' WHERE id = '$tn[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}

	//TRs
	if($tn['tr1'] <> $newTN['tr1']){
		$sql = "UPDATE tn_form SET tr1='$newTN[tr1]' WHERE id = '$tn[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}
	if($tn['tr2'] <> $newTN['tr2']){
		$sql = "UPDATE tn_form SET tr2='$newTN[tr2]' WHERE id = '$tn[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}
	if($tn['tr3'] <> $newTN['tr3']){
		$sql = "UPDATE tn_form SET tr3='$newTN[tr3]' WHERE id = '$tn[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}
}

echo "\n<br/>";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Update date from My@.
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$sql = "SELECT * FROM tn_form WHERE clID=$cl AND periodId=$periodId";
$res = $db->select($sql);

echo "<b>STEP 2</b>\n<br/>";

foreach($res as $tn) {

	// 	if ($tn['status'] == "Realized" || $tn['status'] == "realized"){
	// 		//Dont check status on My@. Only docs according to Audit Period.
	// 	}else{
	echo "Checking my@ status: $tn[id] \n<br/>";

	$formId = $tn['id'];
	$form = getFormMyAiesec($formId);

	if($tn['status'] <> $form['status']){
		$sql = "UPDATE tn_form SET status='$form[status]' WHERE id='$tn[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}

	//OLD: 2012-09-25
	//echo "OLD: $tn[dtRA] <br/>\n";
	//NEW: 25/09/2012
	//echo "NEW: $form[dtRA] <br/>\n";

	if( DateTime::createFromFormat('Y-m-d', $tn['dtRA']) <> DateTime::createFromFormat('d/m/Y', $form['dtRA']) ){
		$sql = "UPDATE tn_form SET dtRA=STR_TO_DATE('$form[dtRA]','%d/%m/%Y') WHERE id='$tn[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}

	if( DateTime::createFromFormat('Y-m-d', $tn['dtMA']) <> DateTime::createFromFormat('d/m/Y', $form['dtMA']) ){
		$sql = "UPDATE tn_form SET dtMA=STR_TO_DATE('$form[dtMA]','%d/%m/%Y') WHERE id='$tn[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}

	if( DateTime::createFromFormat('Y-m-d', $tn['dtRE']) <> DateTime::createFromFormat('d/m/Y', $form['dtRE']) ){
		$sql = "UPDATE tn_form SET dtRE=STR_TO_DATE('$form[dtRE]','%d/%m/%Y') WHERE id='$tn[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}

	if( DateTime::createFromFormat('Y-m-d', $tn['dtEND']) <> DateTime::createFromFormat('d/m/Y', $form['dtEND']) ){
		$sql = "UPDATE tn_form SET dtEND=STR_TO_DATE('$form[dtEND]','%d/%m/%Y') WHERE id='$tn[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}

	//Update formId if empty
	if($tn['formId'] <> $form['formId']){
		$sql = "UPDATE tn_form SET formId='$form[formId]' WHERE id='$tn[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}

	if($tn['type'] <> $form['type']){
		$sql = "UPDATE tn_form SET type='$form[type]' WHERE id='$tn[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}

	//Update formMAId if empty
	if($tn['formMAId'] <> $form['formMAId']){
		$sql = "UPDATE tn_form SET formMAId='$form[formMAId]' WHERE id='$tn[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}

	//Update formMAName if empty
	if($tn['formMAName'] <> $form['formMAName']){
		$sql = "UPDATE tn_form SET formMAName='$form[formMAName]' WHERE id='$tn[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}
	// 	}
}

echo "\n<br/>";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//TODO: Get new forms from period.
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
getFormsMyAiesec($cl,$from,$to);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Updating docs according date
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$sql = "SELECT * FROM tn_form WHERE clID=$cl AND periodId=$periodId";
$res = $db->select($sql);
//echo "Total: "+count($res);

echo "<b>STEP 4</b>\n<br/>";

foreach($res as $tn) {
	echo "Updating docs requested according to DATE for formId: $tn[id] \n<br/>";
	$update = false;

	$dtRA = empty($tn['dtRA']) ? null : new DateTime($tn['dtRA']);
	$dtMA = empty($tn['dtMA']) ? null : new DateTime($tn['dtMA']);
	$dtRE = empty($tn['dtRE']) ? null : new DateTime($tn['dtRE']);
	$dtEND = empty($tn['dtEND']) ? null : new DateTime($tn['dtEND']);

	echo "TN-Id: $tn[id]<br/>\n";
	echo "dtRA: ".date_format($dtRA, 'Y-m-d')."<br/>\n";

	if (isset($dtMA))
		echo "dtMA: ".date_format($dtMA, 'Y-m-d')."<br/>\n";
	if (isset($dtRE))
		echo "dtRE: ".date_format($dtRE, 'Y-m-d')."<br/>\n";
	if (isset($dtEND))
		echo "dtEND: ".date_format($dtEND, 'Y-m-d')."<br/>\n";

	$intervalENDRE = 0;

	if (!empty($dtEND) && !empty($dtRE)){
		$dtThird = getThird($dtRE,$dtEND);
		$intervalENDRE = $dtEND->diff($dtRE);
		echo "dtThird: ".date_format($dtThird, 'Y-m-d')."<br/>\n";
		echo "intervalENDRE: ".$intervalENDRE->days."<br/>\n";
	}


	//Contract -----> =SE(dtRA="";"";SE(dtRA<=from;"S";SE(dtRA<=to;"NE";SE(dtRA>to;""))))
	$newContract = '';
	if (empty($dtRA)){
		echo "EMpty dtRA";
		$newContract = '';
	} else if ($dtRA <= $from){
		$newContract = 'S';
	} else if ($dtRA <= $to) {
		$newContract = 'NE';
	} else if ($dtRA > $to){
		echo "last dtRA";
		$newContract = '';
	}

	if (!( $tn['contract'] == 'NE2' || $tn['contract'] == 'OK' || $tn['contract'] == 'S' || ($tn['contract'] == $newContract) )){
		$sql = "UPDATE tn_form SET contract='$newContract' WHERE id='$tn[id]' AND periodId=$periodId";
		echo $sql."<br/>";
		$db->update($sql);
	}

	//SAN -----> =SE(dtMA="";"";SE(dtMA<=from;"S";SE(dtMA<=to;"NE";SE(dtMA>to;""))))
	$newSAN = '';
	if (empty($dtMA)){
		$newSAN = '';
	} else if ($dtMA <= $from){
		$newSAN = 'S';
	} else if ($dtMA <= $to) {
		$newSAN = 'NE';
	} else if ($dtMA > $to){
		$newSAN = '';
	}

	if (!( $tn['san'] == 'NE2' || $tn['san'] == 'OK' || $tn['san'] == 'S' || ($tn['san'] == $newSAN) )){
		$sql = "UPDATE tn_form SET san='$newSAN' WHERE id='$tn[id]' AND periodId=$periodId";
		echo $sql."<br/>";
		$db->update($sql);
	}

	//CAN -----> =SE(dtMA="";"";SE(dtMA<=from;"S";SE(dtMA<=to;"NE";SE(dtMA>to;""))))

	$newCAN = '';
	if (empty($dtMA)){
		$newCAN = '';
	} else if ($dtMA <= $from){
		$newCAN = 'S';
	} else if ($dtMA <= $to) {
		$newCAN = 'NE';
	} else if ($dtMA > $to){
		$newCAN = '';
	}

	if (!( $tn['can'] == 'NE2' || $tn['can'] == 'OK' || $tn['can'] == 'S' || ($tn['can'] == $newCAN) )){
		$sql = "UPDATE tn_form SET can='$newCAN' WHERE id='$tn[id]' AND periodId=$periodId";
		echo $sql."<br/>";
		$db->update($sql);
	}

	//RNE -----> =SE(dtRE="";"";SE(dtRE<=from;"S";SE(dtRE<=to;"NE";SE(dtRE>to;""))))
	$newRNE = '';
	if (empty($dtRE)){
		$newRNE = '';
	} else if ($dtRE <= $from){
		$newRNE = 'S';
	} else if ($dtRE <= $to) {
		$newRNE = 'NE';
	} else if ($dtRE > $to){
		$newRNE = '';
	}

	if (!( $tn['rne'] == 'NE2' || $tn['rne'] == 'OK' || $tn['rne'] == 'S' || ($tn['rne'] == $newRNE) )){
		$sql = "UPDATE tn_form SET rne='$newRNE' WHERE id='$tn[id]' AND periodId=$periodId";
		echo $sql."<br/>";
		$db->update($sql);
	}

	//TN1 -----> =SE(dtRE="";"";SE(dtEND-dtRE<=90;"";SE(dtThird<=from;"S";SE(dtThird<=to;"NE";""))))
	$newTN1 = '';
	if (empty($dtRE)){
		$newTN1 = '';
	} else {
		//echo "interval: $intervalENDRE->days";
		if (intval($intervalENDRE->days) <= 90){
			$newTN1 = '';
		} else if ($dtThird <= $from) {
			$newTN1 = 'S';
		} else if ($dtThird <= $to){
			$newTN1 = 'NE';
		}
	}

	echo "TN1 OLD: $tn[tn1]<br/>";
	echo "TN1 NEW: $newTN1<br/>";
	echo "first: ". ($tn['tn1'] <> 'NE2' || $tn['tn1'] <> 'OK' || $tn['tn1'] <> 'S')."<br/>";
	echo "second:". ($tn['tn1'] <> $newTN1)."<br/>";

	//Updating TN1 and TR1

	if (!( $tn['tn1'] == 'NE2' || $tn['tn1'] == 'OK' || $tn['tn1'] == 'S' || ($tn['tn1'] == $newTN1) )){
		$sql = "UPDATE tn_form SET tn1='$newTN1' WHERE id='$tn[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql."<br/>";
	}

	if (!( $tn['tr1'] == 'NE2' || $tn['tr1'] == 'OK' || $tn['tr1'] == 'S' || ($tn['tr1'] == $newTN1) )){
		$sql = "UPDATE tn_form SET tr1='$newTN1' WHERE id='$tn[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql."<br/>";
	}

	//TN2 -----> =SE(dtRE="";"";SE(dtEND-dtRE<=90;"";SE(dtEND<=from;"S";SE(dtEND<=to;"NE";""))))
	$newTN2 = '';
	if (empty($dtRE)){
		$newTN2 = '';
	} else {
		//echo "interval: $intervalENDRE->days";
		if (intval($intervalENDRE->days) <= 90){
			$newTN2 = '';
		} else if ($dtEND <= $from) {
			$newTN2 = 'S';
		} else if ($dtEND <= $to){
			$newTN2 = 'NE';
		}
	}

	//Updating TN2 and TR2

	if (!( $tn['tn2'] == 'NE2' || $tn['tn2'] == 'OK' || $tn['tn2'] == 'S' || ($tn['tn2'] == $newTN2) )){
		$sql = "UPDATE tn_form SET tn2='$newTN2' WHERE id='$tn[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql."<br/>";
	}

	if (!( $tn['tr2'] == 'NE2' || $tn['tr2'] == 'OK' || $tn['tr2'] == 'S' || ($tn['tr2'] == $newTN2) )){
		$sql = "UPDATE tn_form SET tr2='$newTN2' WHERE id='$tn[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql."<br/>";
	}

	//TN3,TRE should have same value as TN2,TR2

	if (!( $tn['tn3'] == 'NE2' || $tn['tn3'] == 'OK' || $tn['tn3'] == 'S' || ($tn['tn3'] == $newTN2) )){
		$sql = "UPDATE tn_form SET tn3='$newTN2' WHERE id='$tn[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql."<br/>";
	}

	if (!( $tn['tr3'] == 'NE2' || $tn['tr3'] == 'OK' || $tn['tr3'] == 'S' || ($tn['tr3'] == $newTN2) )){
		$sql = "UPDATE tn_form SET tr3='$newTN2' WHERE id='$tn[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql."<br/>";
	}


	echo "<br/>\n<br/>\n";

}

function getThird($date1,$date2){

	if(empty($date1) || empty($date2)){
		return null;
	}

	$dtThird = $date1;
	$interval = $date1->diff($date2);
	date_add($dtThird,new DateInterval('P'.intval($interval->days/2).'D'));

	return $dtThird;
}

function updateTN($tn){
	$newTN = array();
	$newTN['contract'] = updateDocStatus($tn['contract']);
	$newTN['san'] = updateDocStatus($tn['san']);
	$newTN['can'] = updateDocStatus($tn['can']);
	$newTN['rne'] = updateDocStatus($tn['rne']);
	$newTN['tn1'] = updateDocStatus($tn['tn1']);
	$newTN['tn2'] = updateDocStatus($tn['tn2']);
	$newTN['tn3'] = updateDocStatus($tn['tn3']);
	$newTN['tr1'] = updateDocStatus($tn['tr1']);
	$newTN['tr2'] = updateDocStatus($tn['tr2']);
	$newTN['tr3'] = updateDocStatus($tn['tr3']);

	return $newTN;
}

function updateDocStatus($curStatus){
	$newStatus = '';

	//echo "Current status: $curStatus \n<br />";

	switch ($curStatus){
		case 'OK':
			//echo 'New Status is S';
			return 'S';
			break;
		case 'NE2':
		case 'NA2':
			//echo 'New Status is -';
			return '-';
			break;
		case 'NA':
		case 'NE':
			//echo 'New Status is NE2';
			return 'NE2';
			break;
	}

	return $curStatus;
}

function getFormsMyAiesec($cl, $from, $to){
	global $periodId,$db;
	
	$myAiesec = new MyAiesec("ricardo.costa@aiesec.net", "katito023");

	echo "<b>STEP 3</b>\n<br/>";

	echo "Get TNs from my@ for $cl ";
	//2012-10-01 -> 01.10.2012
	echo "from ". $from->format('d.m.Y');
	echo " to:". $to->format('d.m.Y') ."<br/>";

	//Matched,New,Realized,Available
	$types = array(3,4,6,9);

	$myAiesec->initSearchTNs($cl,$from->format('d.m.Y'),$to->format('d.m.Y'));

	$tns = array();

	foreach ($types as $type){
		$busca = $myAiesec->searchTNs($cl,$from->format('d.m.Y'),$to->format('d.m.Y'),$type);

		//TODO: Check if there are more than 1 page.n If yes, iterate over.

		$posTn = stripos($busca, "#Tnpopup");

		if ($posTn){
			//It means that TNs were found.
			while($posTn){

				$start = $posTn + 70;
				$end = stripos($busca,"</a>",$posTn);
				$tn = substr($busca,$start,$end-$start);

				$tns[] = $tn;

				$posTn = stripos($busca, "#Tnpopup", $end);
			}
		}
	}

	sort($tns);
	//var_dump($tns);

	$newTNs = array();

	foreach ($tns as $tn){
		$newForm = getFormMyAiesec($tn);
		$newTNs[] = $newForm;

		//Check it doesnt exist from this period.
		$sql = "SELECT * FROM tn_form WHERE id='$tn' AND periodId=$periodId";
		//echo $sql ."<br />";
		$res = $db->select($sql);

		if(count($res) == 0){
			//If not, inserto for CL and period

			$dtRE = empty($newForm['dtRE']) ? null : DateTime::createFromFormat('d/m/Y', $newForm['dtRE']);
			$dtEND = empty($newForm['dtEND']) ? null : DateTime::createFromFormat('d/m/Y', $newForm['dtEND']);
			$dtThirdStr = null;

			if (!empty($dtEND) && !empty($dtRE)){
				$dtThird = getThird($dtRE,$dtEND);
				$dtThirdStr = $dtThird->format('d/m/Y');
				//echo "dtThird: ".date_format($dtThird, 'Y-m-d')."<br/>\n";
			}

			$insert = "INSERT INTO tn_form (`id`,`name`,`formMAId`,`formMAName`,`type`,`status`,`dtRA`, ";
			if(!(empty($newForm['dtMA']))){
				$insert .= "`dtMA`, ";
			}
			if(!(empty($newForm['dtRE']))){
				$insert .= "`dtRE`, ";
			}
			if(!(empty($dtThirdStr))){
				$insert .= "`dtThird`, ";
			}
			if(!(empty($newForm['dtEND']))){
				$insert .= "`dtEND`, ";
			}
			$insert .= "`clID`,`periodId`,`formId`) ";
			$insert .= "VALUES ('$newForm[id]','$newForm[name]','$newForm[formMAId]','$newForm[formMAName]','$newForm[type]','$newForm[status]',";
			$insert .= "STR_TO_DATE('$newForm[dtRA]','%d/%m/%Y'),";
			if(!(empty($newForm['dtMA']))){
				$insert .= "STR_TO_DATE('$newForm[dtMA]','%d/%m/%Y'),";
			}
			if(!(empty($newForm['dtRE']))){
				$insert .= "STR_TO_DATE('$newForm[dtRE]','%d/%m/%Y'),";
			}
			if(!(empty($dtThirdStr))){
				$insert .= "STR_TO_DATE('$dtThirdStr','%d/%m/%Y'),";
			}
			if(!(empty($newForm['dtEND']))){
				$insert .= "STR_TO_DATE('$newForm[dtEND]','%d/%m/%Y'),";
			}
			$insert .= "$cl,$periodId,$newForm[formId])";

			echo $insert . "<br/>";
			$db->insert($insert);
		}

	}

	//var_dump($newTNs);
	echo "\n<br/>";
}

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

//echo "Total: "+count($res);


// if (count($res) > 0){
// 	$newStatus = $res[0]['status'];
// }
// //var_dump($newStatus);

// //TODO: Fix periodId
// $sql = "SELECT $doc FROM tn_form tf WHERE tf.id='$form' AND periodId=1";
// $res = $db->select($sql);
// if (count($res) > 0){
// 	$current = $res[0][$doc];
// }
// //var_dump($current);

// if ($current <> $newStatus){
// 	//echo "Current status of $form is '$current' and new value is '$newStatus'. Will update DB.\n";
// 	$sql = "UPDATE tn_form SET $doc='$newStatus' WHERE id='$form' AND periodId=1";
// 	$db->update($sql);
// }else{
// 	//echo "Equal. Nothing to do.";
// }

// //header('HTTP/1.1 500 Internal Server');
// //header('Content-Type: application/json');
// //die("Error while trying to update '$form'. Please try again later.");

// //History
// $userId = $_SESSION['user']['id'];
// $sql = "INSERT INTO form_history(form,userId,doc,status,periodId,comment,datetime) VALUES ('$form',$userId,'$doc','$newStatus',1,'$comment',NOW())";
// //echo $sql."<br/>";
// $db->insert($sql);


// //$sql = "UPDATE tn_form SET $field='$value' WHERE id='$form'";
// //echo $sql."<br/>";
// $db->update($sql);

// echo $newStatus;



?>