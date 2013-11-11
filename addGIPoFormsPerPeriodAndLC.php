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

	echo "Period: ".$periodId."<br/>\n";
	echo "From: ".date_format($from, 'Y-m-d')."<br/>\n";
	echo "To: ".date_format($to, 'Y-m-d')."<br/>\n<br/>\n<br/>\n";
}else{
	echo "No period found.";
	die();
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Get forms from period CL.
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

echo "<b>STEP 1 - Getting forms details.. </b>\n<br/>";

$isFirst = true;
foreach ($codes as $ep){

	if(!$isFirst){
		$forms .= ',';
	}
	$forms .= "'$ep'";
	$isFirst = false;

	echo "... $ep ... \n<br/>";
	$newForm = Util::getEPFormMyAiesec($ep);
	$newTNs[] = $newForm;

	if($newForm['type'] == 'GCDP')
		continue;

	//Check it doesnt exist from this period.
	$sql = "SELECT * FROM adt_icx_gcdp WHERE id='$ep' AND periodId=$periodId";
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

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Updating docs according date
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$sql = "SELECT * FROM adt_ogx_gip WHERE clID=$cl AND periodId=$periodId and ID in ($forms)";
echo "SQL: $sql \n<br />";
$res = $db->select($sql);

echo "STEP 2 - Update doc status\n<br/>";

foreach($res as $ep) {
	echo "Updating docs requested according to DATE for formId: $ep[id] \n<br/>";
	$update = false;

	$dtRA = empty($ep['dtRA']) ? null : new DateTime($ep['dtRA']);
	$dtMA = empty($ep['dtMA']) ? null : new DateTime($ep['dtMA']);
	$dtRE = empty($ep['dtRE']) ? null : new DateTime($ep['dtRE']);
	$dtEND = empty($ep['dtEND']) ? null : new DateTime($ep['dtEND']);

	echo "EP-Id: $ep[id]<br/>\n";
	echo "dtRA: ".date_format($dtRA, 'Y-m-d')."<br/>\n";

	if (isset($dtMA))
		echo "dtMA: ".date_format($dtMA, 'Y-m-d')."<br/>\n";
	if (isset($dtRE))
		echo "dtRE: ".date_format($dtRE, 'Y-m-d')."<br/>\n";
	if (isset($dtEND))
		echo "dtEND: ".date_format($dtEND, 'Y-m-d')."<br/>\n";

	$intervalENDRE = 0;

	if (!empty($dtEND) && !empty($dtRE)){
		$dtREP7 = new DateTime($ep['dtRE']);
		$dtREP30 = new DateTime($ep['dtRE']);
		
		$dtREP7->add(new DateInterval('P7D'));
		$dtREP30->add(new DateInterval('P30D'));
		echo "dtREP7: ".date_format($dtREP7, 'Y-m-d')."<br/>\n";
		echo "dtREP30: ".date_format($dtREP30, 'Y-m-d')."<br/>\n";
	}

	//Contract -----> =SE(dtRA="";"";SE(dtRA<=from;"S";SE(dtRA<=to;"NE";SE(dtRA>to;""))))
	$newContract = '';
	if (empty($dtRA)){
		echo "Empty dtRA";
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
		echo "dtTest: ".date_format($dtTest, 'Y-m-d')."<br/>\n";
		
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
		
		echo "AddDays: $addDays | $ep[id] | Old: $ep[$var] | NewFU: $newFU</br>";
	
		if (!( $ep[$var] == 'NE2' || $ep[$var] == 'OK' || $ep[$var] == 'S' || ($ep[$var] == $newFU) )){
			$sql = "UPDATE adt_ogx_gip SET $var='$newFU' WHERE id='$ep[id]' AND periodId=$periodId";
			$db->update($sql);
			echo $sql."<br/>";
		}
	}
	echo "<br/>\n<br/>\n";
}

?>