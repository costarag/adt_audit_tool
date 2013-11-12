<?php

ini_set('max_execution_time', 300000000); //3000 seconds = 50 minutes

require_once "include.php";

$myAiesec = new MyAiesec("ricardo.costa@aiesec.net", "katito023");

if (!ISSET($_REQUEST['cl'])) die ("Inform CL.");
if (!ISSET($_REQUEST['period'])) die ("Inform period.");

$cl 		= $_REQUEST['cl'];
$periodId 	= $_REQUEST['period'];

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
	
	date_add($dtThird,new DateInterval('P'.intval($interval->days/2).'D'));
	
	echo "Period: ".$periodId."<br/>\n";
	echo "From: ".date_format($from, 'Y-m-d')."<br/>\n";
	echo "To: ".date_format($to, 'Y-m-d')."<br/>\n<br/>\n<br/>\n";
	//echo "Third: ".date_format(getThird($from,$to), 'Y-m-d')."<br/>\n";
}else{
	die("No period found.");
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Update docs status considering NE -> NE2, OK -> S, NE2 -> -
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$sql = "SELECT * FROM adt_icx_gcdp WHERE clID=$cl AND periodId=$periodId";
$res = $db->select($sql);
echo "<b>STEP 1</b> - Update docs status considering NE -> NE2, OK -> S, NE2 -> - <br/>";

foreach($res as $tn) {
	//echo "Updating pendencies: $tn[id] \n<br/>";

	$newTN = updateTN($tn);

	if($tn['contract'] <> $newTN['contract']){
		$sql = "UPDATE adt_icx_gcdp SET contract='$newTN[contract]' WHERE id = '$tn[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}
	if($tn['san'] <> $newTN['san']){
		$sql = "UPDATE adt_icx_gcdp SET san='$newTN[san]' WHERE id = '$tn[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}
	if($tn['can'] <> $newTN['can']){
		$sql = "UPDATE adt_icx_gcdp SET can='$newTN[can]' WHERE id = '$tn[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}
	if($tn['rne'] <> $newTN['rne']){
		$sql = "UPDATE adt_icx_gcdp SET rne='$newTN[rne]' WHERE id = '$tn[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}

	//tr_checklist
	if($tn['tr_checklist'] <> $newTN['tr_checklist']){
		$sql = "UPDATE adt_icx_gcdp SET tr_checklist='$newTN[tr_checklist]' WHERE id = '$tn[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}
	
	//fu_1st
	if($tn['fu_1st'] <> $newTN['fu_1st']){
		$sql = "UPDATE adt_icx_gcdp SET fu_1st='$newTN[fu_1st]' WHERE id = '$tn[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}
	
	//fu_3rd
	if($tn['fu_3rd'] <> $newTN['fu_3rd']){
		$sql = "UPDATE adt_icx_gcdp SET fu_3rd='$newTN[fu_3rd]' WHERE id = '$tn[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}

	//visita_fechamento
	if($tn['visita_fechamento'] <> $newTN['visita_fechamento']){
		$sql = "UPDATE adt_icx_gcdp SET visita_fechamento='$newTN[visita_fechamento]' WHERE id = '$tn[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}
}

echo "\n<br/>";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Update date from My@.
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$sql = "SELECT * FROM adt_icx_gcdp WHERE clID=$cl AND periodId=$periodId";
$res = $db->select($sql);

echo "<b>STEP 2</b> - Update existing forms extracting data from My@.\n<br/>";

foreach($res as $tn) {

	// 	if ($tn['status'] == "Realized" || $tn['status'] == "realized"){
	// 		//Dont check status on My@. Only docs according to Audit Period.
	// 	}else{
	//echo "Checking my@ status: $tn[id] \n<br/>";

	$formId = $tn['id'];
	$form = Util::getTNFormMyAiesec($formId);

	if($tn['status'] <> $form['status']){
		$sql = "UPDATE adt_icx_gcdp SET status='$form[status]' WHERE id='$tn[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}

	//OLD: 2012-09-25
	//echo "OLD: $tn[dtRA] <br/>\n";
	//NEW: 25/09/2012
	//echo "NEW: $form[dtRA] <br/>\n";

	if( DateTime::createFromFormat('Y-m-d', $tn['dtRA']) <> DateTime::createFromFormat('d/m/Y', $form['dtRA']) ){
		$sql = "UPDATE adt_icx_gcdp SET dtRA=STR_TO_DATE('$form[dtRA]','%d/%m/%Y') WHERE id='$tn[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}

	if( DateTime::createFromFormat('Y-m-d', $tn['dtMA']) <> DateTime::createFromFormat('d/m/Y', $form['dtMA']) ){
		$sql = "UPDATE adt_icx_gcdp SET dtMA=STR_TO_DATE('$form[dtMA]','%d/%m/%Y') WHERE id='$tn[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}

	if( DateTime::createFromFormat('Y-m-d', $tn['dtRE']) <> DateTime::createFromFormat('d/m/Y', $form['dtRE']) ){
		$sql = "UPDATE adt_icx_gcdp SET dtRE=STR_TO_DATE('$form[dtRE]','%d/%m/%Y') WHERE id='$tn[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}

	if( DateTime::createFromFormat('Y-m-d', $tn['dtEND']) <> DateTime::createFromFormat('d/m/Y', $form['dtEND']) ){
		$sql = "UPDATE adt_icx_gcdp SET dtEND=STR_TO_DATE('$form[dtEND]','%d/%m/%Y') WHERE id='$tn[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}

	//Update formId if empty
	if($tn['formId'] <> $form['formId']){
		$sql = "UPDATE adt_icx_gcdp SET formId='$form[formId]' WHERE id='$tn[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}

	if($tn['type'] <> $form['type']){
		$sql = "UPDATE adt_icx_gcdp SET type='$form[type]' WHERE id='$tn[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}

	//Update formMAId if empty
	if($tn['formMAId'] <> $form['formMAId']){
		$sql = "UPDATE adt_icx_gcdp SET formMAId='$form[formMAId]' WHERE id='$tn[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}

	//Update formMAName if empty
	if($tn['formMAName'] <> $form['formMAName']){
		$sql = "UPDATE adt_icx_gcdp SET formMAName='$form[formMAName]' WHERE id='$tn[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}
	// 	}
}

echo "\n<br/>";

//STEP 3
echo "<b>STEP 2</b> - Extracting new forms from My@.\n<br/>";
getFormsMyAiesec($cl,$from,$to);

//STEP 4
echo "<b>STEP 4</b> - Update status for new forms.\n<br/>";

$sql = "SELECT * FROM adt_icx_gcdp WHERE clID=$cl AND periodId=$periodId";
$res = $db->select($sql);
//echo "Total: "+count($res);
foreach($res as $tn) {
	//echo "Updating docs requested according to DATE for formId: $tn[id] \n<br/>";
	$update = false;

	$dtRA = empty($tn['dtRA']) ? null : new DateTime($tn['dtRA']);
	$dtMA = empty($tn['dtMA']) ? null : new DateTime($tn['dtMA']);
	$dtRE = empty($tn['dtRE']) ? null : new DateTime($tn['dtRE']);
	$dtEND = empty($tn['dtEND']) ? null : new DateTime($tn['dtEND']);

	//echo "TN-Id: $tn[id]<br/>\n";
	//echo "dtRA: ".date_format($dtRA, 'Y-m-d')."<br/>\n";
	
	/*
	if (isset($dtMA))
		echo "dtMA: ".date_format($dtMA, 'Y-m-d')."<br/>\n";
	if (isset($dtRE))
		echo "dtRE: ".date_format($dtRE, 'Y-m-d')."<br/>\n";
	if (isset($dtEND))
		echo "dtEND: ".date_format($dtEND, 'Y-m-d')."<br/>\n";
	*/

	$intervalENDRE = 0;

	if (!empty($dtEND) && !empty($dtRE)){
		//$dtThird = getThird($dtRE,$dtEND);
		//$intervalENDRE = $dtEND->diff($dtRE);
		//echo "dtThird: ".date_format($dtThird, 'Y-m-d')."<br/>\n";
		//echo "intervalENDRE: ".$intervalENDRE->days."<br/>\n";
		
		$dtREP7 = new DateTime($tn['dtRE']);
		$dtREP21 = new DateTime($tn['dtRE']);
		
		$dtREP7->add(new DateInterval('P7D'));
		$dtREP21->add(new DateInterval('P21D'));
		
		//echo "dtREP7: ".date_format($dtREP7, 'Y-m-d')."<br/>\n";
		//echo "dtREP21: ".date_format($dtREP21, 'Y-m-d')."<br/>\n";
	}


	//Contract -----> =SE(dtRA="";"";SE(dtRA<=from;"S";SE(dtRA<=to;"NE";SE(dtRA>to;""))))
	$newContract = '';
	if (empty($dtRA)){
		$newContract = '';
	} else if ($dtRA <= $from){
		$newContract = 'S';
	} else if ($dtRA <= $to) {
		$newContract = 'NE';
	} else if ($dtRA > $to){
		$newContract = '';
	}

	if (!( $tn['contract'] == 'NE2' || $tn['contract'] == 'OK' || $tn['contract'] == 'S' || ($tn['contract'] == $newContract) )){
		$sql = "UPDATE adt_icx_gcdp SET contract='$newContract' WHERE id='$tn[id]' AND periodId=$periodId";
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
		$sql = "UPDATE adt_icx_gcdp SET san='$newSAN' WHERE id='$tn[id]' AND periodId=$periodId";
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
		$sql = "UPDATE adt_icx_gcdp SET can='$newCAN' WHERE id='$tn[id]' AND periodId=$periodId";
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
		$sql = "UPDATE adt_icx_gcdp SET rne='$newRNE' WHERE id='$tn[id]' AND periodId=$periodId";
		echo $sql."<br/>";
		$db->update($sql);
	}
	
	//TR_CHECKLIST =SE(dtRE="";"";SE(dtRE+7<=from;"S";SE(dtRE+7<=to;"NE";"")))
	
	$newTRCHECKLIST = '';
	if (empty($dtRE)){
		$newTRCHECKLIST = '';
	} else {
		//echo "interval: $intervalENDRE->days";
		if ($dtREP7 <= $from) {
			$newTRCHECKLIST = 'S';
		} else if ($dtREP7 <= $to){
			$newTRCHECKLIST = 'NE';
		}
	}

	//Updating TRCHECKLIST

	if (!( $tn['tr_checklist'] == 'NE2' || $tn['tr_checklist'] == 'OK' || $tn['tr_checklist'] == 'S' || ($tn['tr_checklist'] == $newTRCHECKLIST) )){
		$sql = "UPDATE adt_icx_gcdp SET tr_checklist='$newTRCHECKLIST' WHERE id='$tn[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql."<br/>";
	}
	
	if (!( $tn['fu_1st'] == 'NE2' || $tn['fu_1st'] == 'OK' || $tn['fu_1st'] == 'S' || ($tn['fu_1st'] == $newTRCHECKLIST) )){
		$sql = "UPDATE adt_icx_gcdp SET fu_1st='$newTRCHECKLIST' WHERE id='$tn[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql."<br/>";
	}
	
	//=SE(dtRE="";"";SE(dtRE+21<=from;"S";SE(dtRE+21<=to;"NE";"")))
	
	$newFU3RD = '';
	if (empty($dtRE)){
		$newFU3RD = '';
	} else {
		//echo "interval: $intervalENDRE->days";
		if ($dtREP21 <= $from) {
			$newFU3RD = 'S';
		} else if ($dtREP21 <= $to){
			$newFU3RD = 'NE';
		}
	}

	if (!( $tn['fu_3rd'] == 'NE2' || $tn['fu_3rd'] == 'OK' || $tn['fu_3rd'] == 'S' || ($tn['fu_3rd'] == $newFU3RD) )){
		$sql = "UPDATE adt_icx_gcdp SET fu_3rd='$newFU3RD' WHERE id='$tn[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql."<br/>";
	}

	
	//=SE(dtEND="";"";SE(dtEND<=from;"S";SE(dtEND<=to;"NE";SE(dtEND>to;""))))
	
	$newFECHA = '';
	if (empty($dtEND)){
		$newFECHA = '';
	} else {
		if ($dtEND <= $from) {
			$newFECHA = 'S';
		} else if ($dtEND <= $to){
			$newFECHA = 'NE';
		}else if ($dtEND > $to){
			$newFECHA = '';
		}
	}
	
	if (!( $tn['visita_fechamento'] == 'NE2' || $tn['visita_fechamento'] == 'OK' || $tn['visita_fechamento'] == 'S' || ($tn['visita_fechamento'] == $newFECHA) )){
		$sql = "UPDATE adt_icx_gcdp SET visita_fechamento='$newFECHA' WHERE id='$tn[id]' AND periodId=$periodId";
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
	$newTN['tr_checklist'] = updateDocStatus($tn['tr_checklist']);
	$newTN['visita_fechamento'] = updateDocStatus($tn['visita_fechamento']);
	
	$newTN['fu_1st'] = updateFUDocStatus($tn['fu_1st']);
	$newTN['fu_3rd'] = updateFUDocStatus($tn['fu_3rd']);

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
function updateFUDocStatus($curStatus){
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
			//echo 'New Status is -';
			return '-';
			break;
	}

	return $curStatus;
}

function getFormsMyAiesec($cl, $from, $to){
	global $periodId,$db;
	
	$myAiesec = new MyAiesec("ricardo.costa@aiesec.net", "katito023");

	//echo "Get TNs from my@ for $cl ";
	//echo "from ". $from->format('d.m.Y');
	//echo " to:". $to->format('d.m.Y') ."<br/>";

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
		$newForm = Util::getTNFormMyAiesec($tn);
		$newTNs[] = $newForm;
		
		if($newForm['type'] == 'GIP')
			continue;

		//Check it doesnt exist from this period.
		$sql = "SELECT * FROM adt_icx_gcdp WHERE id='$tn' AND periodId=$periodId";
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

			$insert = "INSERT INTO adt_icx_gcdp (`id`,`name`,`formMAId`,`formMAName`,`type`,`status`,`dtRA`, ";
			if(!(empty($newForm['dtMA']))){
				$insert .= "`dtMA`, ";
			}
			if(!(empty($newForm['dtRE']))){
				$insert .= "`dtRE`, ";
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

?>