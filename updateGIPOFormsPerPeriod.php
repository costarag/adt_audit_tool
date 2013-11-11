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
	
	echo "Period: ".$periodId."<br/>\n";
	echo "From: ".date_format($from, 'Y-m-d')."<br/>\n";
	echo "To: ".date_format($to, 'Y-m-d')."<br/>\n<br/>\n<br/>\n";
}else{
	die("No period found.");
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Update docs status considering NE -> NE2, OK -> S, NE2 -> -
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$sql = "SELECT * FROM adt_ogx_gip WHERE clID=$cl AND periodId=$periodId";
$res = $db->select($sql);

echo "<b>STEP 1</b> - Update docs status considering NE -> NE2, OK -> S, NE2 -> - <br/>";

foreach($res as $ep) {
	//echo "Updating pendencies: $ep[id] \n<br/>";

	$newEP = updateEP($ep);

	if($ep['contract'] <> $newEP['contract']){
		$sql = "UPDATE adt_ogx_gip SET contract='$newEP[contract]' WHERE id = '$ep[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}
	if($ep['san'] <> $newEP['san']){
		$sql = "UPDATE adt_ogx_gip SET san='$newEP[san]' WHERE id = '$ep[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}
	if($ep['can'] <> $newEP['can']){
		$sql = "UPDATE adt_ogx_gip SET can='$newEP[can]' WHERE id = '$ep[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}

	//ep_checklist
	if($ep['ep_checklist'] <> $newEP['ep_checklist']){
		$sql = "UPDATE adt_ogx_gip SET ep_checklist='$newEP[ep_checklist]' WHERE id = '$ep[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}
	
	//fu_1st_week
	if($ep['fu_1st_week'] <> $newEP['fu_1st_week']){
		$sql = "UPDATE adt_ogx_gip SET fu_1st_week='$newEP[fu_1st_week]' WHERE id = '$ep[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}

	//fu_1st_week
	if($ep['fu_1st_month'] <> $newEP['fu_1st_month']){
		$sql = "UPDATE adt_ogx_gip SET fu_1st_month='$newEP[fu_1st_month]' WHERE id = '$ep[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}
	
	for ($i=45;$i<=360;$i = $i+45){
		$var = "fu_plus_$i";
		if($ep[$var] <> $newEP[$var]){
			$sql = "UPDATE adt_ogx_gip SET $var='$newEP[$var]' WHERE id = '$ep[id]' AND periodId=$periodId";
			$db->update($sql);
			echo $sql.'<br/>';
		}
	}
}

echo "\n<br/>";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Update date from My@.
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$sql = "SELECT * FROM adt_ogx_gip WHERE clID=$cl AND periodId=$periodId";
$res = $db->select($sql);

echo "<b>STEP 2</b> - Update existing forms extracting data from My@.\n<br/>";

foreach($res as $ep) {

	// 	if ($ep['status'] == "Realized" || $ep['status'] == "realized"){
	// 		//Dont check status on My@. Only docs according to Audit Period.
	// 	}else{
	//echo "Checking my@ status: $ep[id] \n<br/>";

	$formId = $ep['id'];
	$form = Util::getEPFormMyAiesec($formId);

	if($ep['status'] <> $form['status']){
		$sql = "UPDATE adt_ogx_gip SET status='$form[status]' WHERE id='$ep[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}

	//OLD: 2012-09-25
	//echo "OLD: $ep[dtRA] <br/>\n";
	//NEW: 25/09/2012
	//echo "NEW: $form[dtRA] <br/>\n";

	if( DateTime::createFromFormat('Y-m-d', $ep['dtRA']) <> DateTime::createFromFormat('d/m/Y', $form['dtRA']) ){
		$sql = "UPDATE adt_ogx_gip SET dtRA=STR_TO_DATE('$form[dtRA]','%d/%m/%Y') WHERE id='$ep[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}

	if( DateTime::createFromFormat('Y-m-d', $ep['dtMA']) <> DateTime::createFromFormat('d/m/Y', $form['dtMA']) ){
		$sql = "UPDATE adt_ogx_gip SET dtMA=STR_TO_DATE('$form[dtMA]','%d/%m/%Y') WHERE id='$ep[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}

	if( DateTime::createFromFormat('Y-m-d', $ep['dtRE']) <> DateTime::createFromFormat('d/m/Y', $form['dtRE']) ){
		$sql = "UPDATE adt_ogx_gip SET dtRE=STR_TO_DATE('$form[dtRE]','%d/%m/%Y') WHERE id='$ep[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}

	if( DateTime::createFromFormat('Y-m-d', $ep['dtEND']) <> DateTime::createFromFormat('d/m/Y', $form['dtEND']) ){
		$sql = "UPDATE adt_ogx_gip SET dtEND=STR_TO_DATE('$form[dtEND]','%d/%m/%Y') WHERE id='$ep[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}

	//Update formId if empty
	if($ep['formId'] <> $form['formId']){
		$sql = "UPDATE adt_ogx_gip SET formId='$form[formId]' WHERE id='$ep[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}

	if($ep['type'] <> $form['type']){
		$sql = "UPDATE adt_ogx_gip SET type='$form[type]' WHERE id='$ep[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}

	//Update formMAId if empty
	if($ep['formMAId'] <> $form['formMAId']){
		$sql = "UPDATE adt_ogx_gip SET formMAId='$form[formMAId]' WHERE id='$ep[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql.'<br/>';
	}

	//Update formMAName if empty
	if($ep['formMAName'] <> $form['formMAName']){
		$sql = "UPDATE adt_ogx_gip SET formMAName='$form[formMAName]' WHERE id='$ep[id]' AND periodId=$periodId";
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
$sql = "SELECT * FROM adt_ogx_gip WHERE clID=$cl AND periodId=$periodId";
$res = $db->select($sql);

foreach($res as $ep) {
	//echo "Updating docs requested according to DATE for formId: $ep[id] \n<br/>";
	$update = false;

	$dtRA = empty($ep['dtRA']) ? null : new DateTime($ep['dtRA']);
	$dtMA = empty($ep['dtMA']) ? null : new DateTime($ep['dtMA']);
	$dtRE = empty($ep['dtRE']) ? null : new DateTime($ep['dtRE']);
	$dtEND = empty($ep['dtEND']) ? null : new DateTime($ep['dtEND']);

	//echo "EP-Id: $ep[id]<br/>\n";
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
		$dtREP7 = new DateTime($ep['dtRE']);
		$dtREP30 = new DateTime($ep['dtRE']);
		
		$dtREP7->add(new DateInterval('P7D'));
		$dtREP30->add(new DateInterval('P30D'));
		//echo "dtREP7: ".date_format($dtREP7, 'Y-m-d')."<br/>\n";
		//echo "dtREP30: ".date_format($dtREP30, 'Y-m-d')."<br/>\n";
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

	if (!( $ep['contract'] == 'NE2' || $ep['contract'] == 'OK' || $ep['contract'] == 'S' || ($ep['contract'] == $newContract) )){
		$sql = "UPDATE adt_ogx_gip SET contract='$newContract' WHERE id='$ep[id]' AND periodId=$periodId";
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
		$sql = "UPDATE adt_ogx_gip SET san='$newSAN' WHERE id='$ep[id]' AND periodId=$periodId";
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
		$sql = "UPDATE adt_ogx_gip SET can='$newCAN' WHERE id='$ep[id]' AND periodId=$periodId";
		echo $sql."<br/>";
		$db->update($sql);
	}

	//ep_checklist =SE(dtRE="";"";SE(dtRE+7<=from;"S";SE(dtRE+7<=to;"NE";"")))
	
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

	if (!( $ep['ep_checklist'] == 'NE2' || $ep['ep_checklist'] == 'OK' || $ep['ep_checklist'] == 'S' || ($ep['ep_checklist'] == $newTRCHECKLIST) )){
		$sql = "UPDATE adt_ogx_gip SET ep_checklist='$newTRCHECKLIST' WHERE id='$ep[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql."<br/>";
	}
	
	if (!( $ep['fu_1st_week'] == 'NE2' || $ep['fu_1st_week'] == 'OK' || $ep['fu_1st_week'] == 'S' || ($ep['fu_1st_week'] == $newTRCHECKLIST) )){
		$sql = "UPDATE adt_ogx_gip SET fu_1st_week='$newTRCHECKLIST' WHERE id='$ep[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql."<br/>";
	}
	
	$newFU1stMON = '';
	if (empty($dtRE)){
		$newFU1stMON = '';
	} else {
		if ($dtREP30 <= $from) {
			$newFU1stMON = 'S';
		} else if ($dtREP30 <= $to){
			$newFU1stMON = 'NE';
		}
	}

	if (!( $ep['fu_1st_month'] == 'NE2' || $ep['fu_1st_month'] == 'OK' || $ep['fu_1st_month'] == 'S' || ($ep['fu_1st_month'] == $newFU1stMON) )){
		$sql = "UPDATE adt_ogx_gip SET fu_1st_month='$newFU1stMON' WHERE id='$ep[id]' AND periodId=$periodId";
		$db->update($sql);
		echo $sql."<br/>";
	}
	
	//=SE(dtRE="";"";SE($dtREP30+45<=from;"S";SE(dt1Mon+45>dtEND;"X";SE(dt1Mon+45<=to;"NE";""))))
	//=SE(dtRE="";"";SE($dtREP30+90<=from;"S";SE(dt1Mon+90>dtEND;"X";SE(dt1Mon+90<=to;"NE";""))))
	//=SE(dtRE="";"";SE($dtREP30+135<=from;"S";SE(dt1Mon+135>dtEND;"X";SE(dt1Mon+135<=to;"NE";""))))
	//=SE(dtRE="";"";SE($dtREP30+180<=from;"S";SE(dt1Mon+180>dtEND;"X";SE(dt1Mon+180<=to;"NE";""))))
	for ($i=45;$i<=360;$i = $i+45){
		$var = "fu_plus_$i";
		$addDays = 'P'.($i+30).'D';
		
		$dtTest = new DateTime($ep['dtRE']);
		
		//echo "dtREP30: ".date_format($dtREP30, 'Y-m-d')."<br/>\n";
		//echo "dtTest BEFORE: ".date_format($dtTest, 'Y-m-d')."<br/>\n";
		$dtTest->add(new DateInterval($addDays));
		//echo "dtTest: ".date_format($dtTest, 'Y-m-d')."<br/>\n";
		
		//=SE(dtRE="";"";SE(dt30+225<=from;"S";SE(dt30+225>dtEND;"X";SE(dt30+225<=to;"NE";""))))
		
		$newFU = '';
		if (empty($dtRE)){
			$newFU = '';
		} else {
			if ($dtTest <= $from) {
				$newFU = 'S';
			} else if ($dtTest > $dtEND){
				$newFU = 'X';
			}else if ($dtTest <= $to){
				$newFU = 'NE';
			}
		}
		
		//echo "AddDays: $addDays | $ep[id] | Old: $ep[$var] | NewFU: $newFU</br>";
	
		if (!( $ep[$var] == 'NE2' || $ep[$var] == 'OK' || $ep[$var] == 'S' || ($ep[$var] == $newFU) )){
			$sql = "UPDATE adt_ogx_gip SET $var='$newFU' WHERE id='$ep[id]' AND periodId=$periodId";
			$db->update($sql);
			echo $sql."<br/>";
		}
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

function updateEP($ep){
	$newEP = array();
	$newEP['contract'] = updateDocStatus($ep['contract']);
	$newEP['san'] = updateDocStatus($ep['san']);
	$newEP['can'] = updateDocStatus($ep['can']);
	$newEP['ep_checklist'] = updateDocStatus($ep['ep_checklist']);
	
	$newEP['fu_1st_week'] = updateFUDocStatus($ep['fu_1st_week']);
	$newEP['fu_1st_month'] = updateFUDocStatus($ep['fu_1st_month']);
	$newEP['fu_plus_45'] = updateFUDocStatus($ep['fu_plus_45']);
	$newEP['fu_plus_90'] = updateFUDocStatus($ep['fu_plus_90']);
	$newEP['fu_plus_135'] = updateFUDocStatus($ep['fu_plus_135']);
	$newEP['fu_plus_180'] = updateFUDocStatus($ep['fu_plus_180']);
	$newEP['fu_plus_225'] = updateFUDocStatus($ep['fu_plus_225']);
	$newEP['fu_plus_270'] = updateFUDocStatus($ep['fu_plus_270']);
	$newEP['fu_plus_315'] = updateFUDocStatus($ep['fu_plus_315']);
	$newEP['fu_plus_360'] = updateFUDocStatus($ep['fu_plus_360']);

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
	global $myAiesec,$periodId,$db;

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
		$newForm = Util::getEPFormMyAiesec($ep);
		$newEPs[] = $newForm;
		
		if($newForm['type'] == "GCDP")
			continue;

		//Check it doesnt exist from this period.
		$sql = "SELECT * FROM adt_ogx_gip WHERE id='$ep' AND periodId=$periodId";
		//echo $sql ."<br />";
		$res = $db->select($sql);

		if(count($res) == 0){
			//If not, inserto for CL and period

			$dtRE = empty($newForm['dtRE']) ? null : DateTime::createFromFormat('d/m/Y', $newForm['dtRE']);
			$dtEND = empty($newForm['dtEND']) ? null : DateTime::createFromFormat('d/m/Y', $newForm['dtEND']);

			$insert = "INSERT INTO adt_ogx_gip (`id`,`name`,`formMAId`,`formMAName`,`type`,`status`,`dtRA`, ";
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


?>