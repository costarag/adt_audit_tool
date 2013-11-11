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

$sql = "SELECT * FROM ep_form WHERE clID=$cl AND periodId=$periodId";
$res = $db->select($sql);
//echo "Total: "+count($res);
echo "<b>STEP 1</b>\n<br/>";

foreach($res as $ep) {
	echo "Updating pendencies: $ep[id] \n<br/>";

	$newEP = updateEP($ep);

	if($ep['contract'] <> $newEP['contract']){
		$sql = "UPDATE ep_form SET contract='$newEP[contract]' WHERE id = '$ep[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}
	if($ep['san'] <> $newEP['san']){
		$sql = "UPDATE ep_form SET san='$newEP[san]' WHERE id = '$ep[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}
	if($ep['can'] <> $newEP['can']){
		$sql = "UPDATE ep_form SET can='$newEP[can]' WHERE id = '$ep[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}
	//TNS
	if($ep['ep1'] <> $newEP['ep1']){
		$sql = "UPDATE ep_form SET ep1='$newEP[ep1]' WHERE id = '$ep[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}
	if($ep['ep2'] <> $newEP['ep2']){
		$sql = "UPDATE ep_form SET ep2='$newEP[ep2]' WHERE id = '$ep[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}
	if($ep['ep3'] <> $newEP['ep3']){
		$sql = "UPDATE ep_form SET ep3='$newEP[ep3]' WHERE id='$ep[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}
}

echo "\n<br/>";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Update date from My@.
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$sql = "SELECT * FROM ep_form WHERE clID=$cl AND periodId=$periodId";
$res = $db->select($sql);

echo "<b>STEP 2</b>\n<br/>";

foreach($res as $ep) {

	// 	if ($ep['status'] == "Realized" || $ep['status'] == "realized"){
	// 		//Dont check status on My@. Only docs according to Audit Period.
	// 	}else{
	echo "Checking my@ status: $ep[id] \n<br/>";

	$formId = $ep['id'];
	$form = getFormMyAiesec($formId);

	if($ep['status'] <> $form['status']){
		$sql = "UPDATE ep_form SET status='$form[status]' WHERE id='$ep[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}

	//OLD: 2012-09-25
	//echo "OLD: $ep[dtRA] <br/>\n";
	//NEW: 25/09/2012
	//echo "NEW: $form[dtRA] <br/>\n";

	if( DateTime::createFromFormat('Y-m-d', $ep['dtRA']) <> DateTime::createFromFormat('d/m/Y', $form['dtRA']) ){
		$sql = "UPDATE ep_form SET dtRA=STR_TO_DATE('$form[dtRA]','%d/%m/%Y') WHERE id='$ep[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}

	if( DateTime::createFromFormat('Y-m-d', $ep['dtMA']) <> DateTime::createFromFormat('d/m/Y', $form['dtMA']) ){
		$sql = "UPDATE ep_form SET dtMA=STR_TO_DATE('$form[dtMA]','%d/%m/%Y') WHERE id='$ep[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}

	if( DateTime::createFromFormat('Y-m-d', $ep['dtRE']) <> DateTime::createFromFormat('d/m/Y', $form['dtRE']) ){
		$sql = "UPDATE ep_form SET dtRE=STR_TO_DATE('$form[dtRE]','%d/%m/%Y') WHERE id='$ep[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}

	if( DateTime::createFromFormat('Y-m-d', $ep['dtEND']) <> DateTime::createFromFormat('d/m/Y', $form['dtEND']) ){
		$sql = "UPDATE ep_form SET dtEND=STR_TO_DATE('$form[dtEND]','%d/%m/%Y') WHERE id='$ep[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}

	if($ep['formId'] <> $form['formId']){
		$sql = "UPDATE ep_form SET formId='$form[formId]' WHERE id='$ep[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}

	if($ep['type'] <> $form['type']){
		$sql = "UPDATE ep_form SET type='$form[type]' WHERE id='$ep[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}

	//Update formMAId if empty
	if($ep['formMAId'] <> $form['formMAId']){
		$sql = "UPDATE ep_form SET formMAId='$form[formMAId]' WHERE id='$ep[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}

	//Update formMAName if empty
	if($ep['formMAName'] <> $form['formMAName']){
		$sql = "UPDATE ep_form SET formMAName='$form[formMAName]' WHERE id='$ep[id]' AND periodId=$periodId";
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
$sql = "SELECT * FROM ep_form WHERE clID=$cl AND periodId=$periodId";
$res = $db->select($sql);
//echo "Total: "+count($res);

echo "<b>STEP 4</b>\n<br/>";

foreach($res as $ep) {
	echo "Updating docs requested according to DATE for formId: $ep[id] \n<br/>";
	$update = false;

	$dtRA = empty($ep['dtRA']) ? null : new DateTime($ep['dtRA']);
	$dtMA = empty($ep['dtMA']) ? null : new DateTime($ep['dtMA']);
	$dtRE = empty($ep['dtRE']) ? null : new DateTime($ep['dtRE']);
	$dtEND = empty($ep['dtEND']) ? null : new DateTime($ep['dtEND']);

	echo "TN-Id: $ep[id]<br/>\n";
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
		$dtREPlus30 = addDaysDate($dtRE,30);
		$dtENDPlus14 = addDaysDate($dtEND,14);
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

	if (!( $ep['contract'] == 'NE2' || $ep['contract'] == 'OK' || $ep['contract'] == 'S' || ($ep['contract'] == $newContract) )){
		$sql = "UPDATE ep_form SET contract='$newContract' WHERE id='$ep[id]' AND periodId=$periodId";
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

	if (!( $ep['san'] == 'NE2' || $ep['san'] == 'OK' || $ep['san'] == 'S' || ($ep['san'] == $newSAN) )){
		$sql = "UPDATE ep_form SET san='$newSAN' WHERE id='$ep[id]' AND periodId=$periodId";
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

	if (!( $ep['can'] == 'NE2' || $ep['can'] == 'OK' || $ep['can'] == 'S' || ($ep['can'] == $newCAN) )){
		$sql = "UPDATE ep_form SET can='$newCAN' WHERE id='$ep[id]' AND periodId=$periodId";
		echo $sql."<br/>";
		$db->update($sql);
	}

	//EP1 -----> =SE(dtRE="";"";SE(dtEND-dtRE<=90;"";SE(dtRE+30<=from;"S";SE(dtRE+30<=to;"NE";"")))) --> OGX
	//EP1 -----> =SE(dtRE="";"";SE(dtEND-dtRE<=90;"";SE(dtThird<=from;"S";SE(dtThird<=to;"NE";"")))) --> ICX
	$newEP1 = '';
	if (empty($dtRE)){
		$newEP1 = '';
	} else {
		//echo "interval: $intervalENDRE->days";
		if (intval($intervalENDRE->days) <= 90){
			$newEP1 = '';
		} else if ($dtREPlus30 <= $from) {
			$newEP1 = 'S';
		} else if ($dtREPlus30 <= $to){
			$newEP1 = 'NE';
		}
	}

	echo "TN1 OLD: $ep[ep1]<br/>";
	echo "TN1 NEW: $newEP1<br/>";
	echo "first: ". ($ep['ep1'] <> 'NE2' || $ep['ep1'] <> 'OK' || $ep['ep1'] <> 'S')."<br/>";
	echo "second:". ($ep['ep1'] <> $newEP1)."<br/>";

	//Updating EP1

	if (!( $ep['ep1'] == 'NE2' || $ep['ep1'] == 'OK' || $ep['ep1'] == 'S' || ($ep['ep1'] == $newEP1) )){
		$sql = "UPDATE ep_form SET ep1='$newEP1' WHERE id='$ep[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql."<br/>";
	}

	//ep2 -----> =SE(dtEND="";"";SE(dtEND-dtRE<=90;"";SE(dtEND+14<=from;"S";SE(dtEND+14<=to;"NE";""))))
	//ep2 -----> =SE(dtRE="";"";SE(dtEND-dtRE<=90;"";SE(dtEND<=from;"S";SE(dtEND<=to;"NE";"")))) --> ICX
	$newep2 = '';
	if (empty($dtEND)){
		$newep2 = '';
	} else {
		//echo "interval: $intervalENDRE->days";
		if (intval($intervalENDRE->days) <= 90){
			$newep2 = '';
		} else if ($dtENDPlus14 <= $from) {
			$newep2 = 'S';
		} else if ($dtENDPlus14 <= $to){
			$newep2 = 'NE';
		}
	}

	//Updating EP2

	if (!( $ep['ep2'] == 'NE2' || $ep['ep2'] == 'OK' || $ep['ep2'] == 'S' || ($ep['ep2'] == $newep2) )){
		$sql = "UPDATE ep_form SET ep2='$newep2' WHERE id='$ep[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql."<br/>";
	}

	//EP3 -----> =SE(dtEND="";"";SE(dtEND-dtRE>90;"";SE(dtEND+14<=from;"S";SE(dtEND+14<=to;"NE";""))))
	$newep3 = '';
	if (empty($dtEND)){
		$newep3 = '';
	} else {
		//echo "interval: $intervalENDRE->days";
		if (intval($intervalENDRE->days) > 90){
			$newep3 = '';
		} else if ($dtENDPlus14 <= $from) {
			$newep3 = 'S';
		} else if ($dtENDPlus14 <= $to){
			$newep3 = 'NE';
		}
	}

	//Updating EP3

	if (!( $ep['ep3'] == 'NE2' || $ep['ep3'] == 'OK' || $ep['ep3'] == 'S' || ($ep['ep3'] == $newep3) )){
		$sql = "UPDATE ep_form SET ep3='$newep3' WHERE id='$ep[id]' AND periodId=$periodId";
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

function addDaysDate($date,$numDays){

	if(empty($date) || empty($numDays)){
		return null;
	}

	$newDate= $date;
	date_add($newDate,new DateInterval('P'.intval($numDays).'D'));

	return $newDate;
}



function updateEP($ep){
	$newEP = array();
	$newEP['contract'] = updateDocStatus($ep['contract']);
	$newEP['san'] = updateDocStatus($ep['san']);
	$newEP['can'] = updateDocStatus($ep['can']);
	$newEP['ep1'] = updateDocStatus($ep['ep1']);
	$newEP['ep2'] = updateDocStatus($ep['ep2']);
	$newEP['ep3'] = updateDocStatus($ep['ep3']);

	return $newEP;
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
	global $myAiesec,$periodId,$db;

	echo "<b>STEP 3</b>\n<br/>";

	echo "Get EPs from my@ for $cl ";
	//2012-10-01 -> 01.10.2012
	echo "from ". $from->format('d.m.Y');
	echo " to:". $to->format('d.m.Y') ."<br/>";

	//Matched,New,Realized,Available
	$types = array(3,4,6,9);

	$myAiesec->initSearchEPs($cl,$from->format('d.m.Y'),$to->format('d.m.Y'));

	$eps = array();

	foreach ($types as $type){
		$busca = $myAiesec->searchEPs($cl,$from->format('d.m.Y'),$to->format('d.m.Y'),$type);

		//TODO: Check if there are more than 1 page.n If yes, iterate over.

		$posEp = stripos($busca, "#snPopup");

		if ($posEp){
			//It means that EPs were found.
			while($posEp){

				$start = $posEp + 29;
				$end = stripos($busca,"</a>",$posEp);
				$tn = substr($busca,$start,$end-$start);

				$eps[] = $tn;

				$posEp = stripos($busca, "#snPopup", $end);
			}
		}
	}

	sort($eps);
	//var_dump($eps);

	$newEPs = array();

	foreach ($eps as $ep){
		$newForm = getFormMyAiesec($ep);
		$newEPs[] = $newForm;

		//Check it doesnt exist from this period.
		$sql = "SELECT * FROM ep_form WHERE id='$ep' AND periodId=$periodId";
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

			$insert = "INSERT INTO ep_form (`id`,`name`,`formMAId`,`formMAName`,`type`,`status`,`dtRA`, ";
			if(!(empty($newForm['dtMA']))){
				$insert .= "`dtMA`, ";
			}
			if(!(empty($newForm['dtRE']))){
				$insert .= "`dtRE`, ";
			}
			if(!(empty($dtThirdStr))){
				$insert .= "`dtMid`, ";
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

	//var_dump($newEPs);
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
		return;
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
			return;
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
// $sql = "SELECT $doc FROM ep_form tf WHERE tf.id='$form' AND periodId=1";
// $res = $db->select($sql);
// if (count($res) > 0){
// 	$current = $res[0][$doc];
// }
// //var_dump($current);

// if ($current <> $newStatus){
// 	//echo "Current status of $form is '$current' and new value is '$newStatus'. Will update DB.\n";
// 	$sql = "UPDATE ep_form SET $doc='$newStatus' WHERE id='$form' AND periodId=1";
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


// //$sql = "UPDATE ep_form SET $field='$value' WHERE id='$form'";
// //echo $sql."<br/>";
// $db->update($sql);

// echo $newStatus;



?>