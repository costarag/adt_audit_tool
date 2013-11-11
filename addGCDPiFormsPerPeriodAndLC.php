<?php

ini_set('max_execution_time', 300000000); //3000 seconds = 50 minutes

require_once "include.php";

$myAiesec = new MyAiesec("ricardo.costa@aiesec.net", "katito023");

if (!ISSET($_REQUEST['cl'])) die ("Missing parameters. Inform CL.");
if (!ISSET($_REQUEST['period'])) die ("Missing parameters. Inform period.");
if (!ISSET($_REQUEST['form'])) die ("Missing parameters. Inform form(s).");

$aux = preg_replace('/\s+/', '', $_GET['form']);
$items = str_replace('%20', '', $aux);
$codes = explode(',',$items);

$forms = "";


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
//Get forms from period CL.
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

echo "<b>STEP 1 - Getting forms details.. </b>\n<br/>";

$isFirst = true;
foreach ($codes as $tn){
	
	if(!$isFirst){
		$forms .= ',';
	}
	$forms .= "'$tn'";
	$isFirst = false;
	
	echo "... $tn ... \n<br/>";
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

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Updating docs according date
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$sql = "SELECT * FROM adt_icx_gcdp WHERE clID=$cl AND periodId=$periodId and ID in ($forms)";
//echo "SQL: $sql \n<br />";
$res = $db->select($sql);

echo "STEP 2 - Update doc status\n<br/>";

foreach($res as $tn) {
	echo "Updating docs requested according for formId: $tn[id] \n<br/>";
	$update = false;

	$dtRA = empty($tn['dtRA']) ? null : new DateTime($tn['dtRA']);
	$dtMA = empty($tn['dtMA']) ? null : new DateTime($tn['dtMA']);
	$dtRE = empty($tn['dtRE']) ? null : new DateTime($tn['dtRE']);
	$dtEND = empty($tn['dtEND']) ? null : new DateTime($tn['dtEND']);

	//echo "TN-Id: $tn[id]<br/>\n";
	//echo "dtRA: ".date_format($dtRA, 'Y-m-d')."<br/>\n";

	/* if (isset($dtMA))
		echo "dtMA: ".date_format($dtMA, 'Y-m-d')."<br/>\n";
	if (isset($dtRE))
		echo "dtRE: ".date_format($dtRE, 'Y-m-d')."<br/>\n";
	if (isset($dtEND))
		echo "dtEND: ".date_format($dtEND, 'Y-m-d')."<br/>\n";
	*/

	$intervalENDRE = 0;

	if (!empty($dtEND) && !empty($dtRE)){
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
		//echo "Empty dtRA";
		$newContract = '';
	} else if ($dtRA <= $from){
		$newContract = 'S';
	} else if ($dtRA <= $to) {
		$newContract = 'NE';
	} else if ($dtRA > $to){
		//echo "last dtRA";
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

?>