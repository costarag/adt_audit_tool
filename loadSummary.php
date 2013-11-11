<?php

require_once "include.php";

$multaDoc = 10;
$multaFU  = 5;

$res = array();

$cl=$period = $_GET["cl"];
$period = $_GET["period"];

$sqlNE = "";
$sqlNE .="SELECT \"contract\", SUM(1) AS contract, SUM($multaDoc) as multa FROM adt_icx_gcdp WHERE (contract=\"NE\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNE .="UNION ALL ";
$sqlNE .="SELECT \"san\", SUM(1) AS san, SUM($multaDoc) as multa FROM adt_icx_gcdp WHERE (san=\"NE\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNE .="UNION ALL ";
$sqlNE .="SELECT \"can\", SUM(1) AS can, SUM($multaDoc) as multa FROM adt_icx_gcdp WHERE (can=\"NE\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNE .="UNION ALL ";
$sqlNE .="SELECT \"rne\", SUM(1) AS rne, SUM($multaDoc) as multa FROM adt_icx_gcdp WHERE (rne=\"NE\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNE .="UNION ALL ";
$sqlNE .="SELECT \"tr_checklist\", SUM(1) AS tr_checklist, SUM($multaDoc) as multa FROM adt_icx_gcdp WHERE (tr_checklist=\"NE\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNE .="UNION ALL ";
$sqlNE .="SELECT \"fu_1st\", SUM(1) AS fu_1st, SUM($multaFU) as multa FROM adt_icx_gcdp WHERE (fu_1st=\"NE\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNE .="UNION ALL ";
$sqlNE .="SELECT \"fu_3rd\", SUM(1) AS fu_3rd, SUM($multaFU) as multa FROM adt_icx_gcdp WHERE (fu_3rd=\"NE\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNE .="UNION ALL ";
$sqlNE .="SELECT \"visita_fechamento\", SUM(1) AS visita_fechamento, SUM($multaDoc) as multa FROM adt_icx_gcdp WHERE (visita_fechamento=\"NE\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";

$sqlNE2 = "";
$sqlNE2 .="SELECT \"contract\", SUM(1) AS contract, SUM($multaDoc) as multa FROM adt_icx_gcdp WHERE contract=\"NE2\" AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNE2 .="UNION ALL ";
$sqlNE2 .="SELECT \"san\", SUM(1) AS san, SUM($multaDoc) as multa FROM adt_icx_gcdp WHERE san=\"NE2\" AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNE2 .="UNION ALL ";
$sqlNE2 .="SELECT \"can\", SUM(1) AS can, SUM($multaDoc) as multa FROM adt_icx_gcdp WHERE can=\"NE2\" AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNE2 .="UNION ALL ";
$sqlNE2 .="SELECT \"rne\", SUM(1) AS rne, SUM($multaDoc) as multa FROM adt_icx_gcdp WHERE rne=\"NE2\" AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNE2 .="UNION ALL ";
$sqlNE2 .="SELECT \"tr_checklist\", SUM(1) AS tr_checklist, SUM($multaDoc) as multa FROM adt_icx_gcdp WHERE tr_checklist=\"NE2\"  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNE2 .="UNION ALL ";
$sqlNE2 .="SELECT \"fu_1st\", SUM(1) AS fu_1st, SUM($multaFU) as multa FROM adt_icx_gcdp WHERE fu_1st=\"NE2\" AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNE2 .="UNION ALL ";
$sqlNE2 .="SELECT \"fu_3rd\", SUM(1) AS fu_3rd, SUM($multaFU) as multa FROM adt_icx_gcdp WHERE fu_3rd=\"NE2\" AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNE2 .="UNION ALL ";
$sqlNE2 .="SELECT \"visita_fechamento\", SUM(1) AS visita_fechamento, SUM($multaDoc) as multa FROM adt_icx_gcdp WHERE visita_fechamento=\"NE2\" AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";

$sqlNA = "";
$sqlNA .="SELECT \"contract\", SUM(1) AS contract, SUM($multaDoc) as multa FROM adt_icx_gcdp WHERE (contract=\"NA\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNA .="UNION ALL ";
$sqlNA .="SELECT \"san\", SUM(1) AS san, SUM($multaDoc) as multa FROM adt_icx_gcdp WHERE (san=\"NA\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNA .="UNION ALL ";
$sqlNA .="SELECT \"can\", SUM(1) AS can, SUM($multaDoc) as multa FROM adt_icx_gcdp WHERE (can=\"NA\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNA .="UNION ALL ";
$sqlNA .="SELECT \"rne\", SUM(1) AS rne, SUM($multaDoc) as multa FROM adt_icx_gcdp WHERE (rne=\"NA\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNA .="UNION ALL ";
$sqlNA .="SELECT \"tr_checklist\", SUM(1) AS tr_checklist, SUM($multaDoc) as multa FROM adt_icx_gcdp WHERE (tr_checklist=\"NA\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNA .="UNION ALL ";
$sqlNA .="SELECT \"fu_1st\", SUM(1) AS fu_1st, SUM($multaFU) as multa FROM adt_icx_gcdp WHERE (fu_1st=\"NA\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNA .="UNION ALL ";
$sqlNA .="SELECT \"fu_3rd\", SUM(1) AS fu_3rd, SUM($multaFU) as multa FROM adt_icx_gcdp WHERE (fu_3rd=\"NA\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNA .="UNION ALL ";
$sqlNA .="SELECT \"visita_fechamento\", SUM(1) AS visita_fechamento, SUM($multaDoc) as multa FROM adt_icx_gcdp WHERE (visita_fechamento=\"NA\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";

$sqlNA2 = "";
$sqlNA2 .="SELECT \"contract\", SUM(1) AS contract, SUM($multaDoc) as multa FROM adt_icx_gcdp WHERE contract=\"NA2\" AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNA2 .="UNION ALL ";
$sqlNA2 .="SELECT \"san\", SUM(1) AS san, SUM($multaDoc) as multa FROM adt_icx_gcdp WHERE san=\"NA2\" AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNA2 .="UNION ALL ";
$sqlNA2 .="SELECT \"can\", SUM(1) AS can, SUM($multaDoc) as multa FROM adt_icx_gcdp WHERE can=\"NA2\" AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNA2 .="UNION ALL ";
$sqlNA2 .="SELECT \"rne\", SUM(1) AS rne, SUM($multaDoc) as multa FROM adt_icx_gcdp WHERE rne=\"NA2\" AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNA2 .="UNION ALL ";
$sqlNA2 .="SELECT \"tr_checklist\", SUM(1) AS tr_checklist, SUM($multaDoc) as multa FROM adt_icx_gcdp WHERE tr_checklist=\"NA2\" AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNA2 .="UNION ALL ";
$sqlNA2 .="SELECT \"fu_1st\", SUM(1) AS fu_1st, SUM($multaFU) as multa FROM adt_icx_gcdp WHERE fu_1st=\"NA2\" AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNA2 .="UNION ALL ";
$sqlNA2 .="SELECT \"fu_3rd\", SUM(1) AS fu_3rd, SUM($multaFU) as multa FROM adt_icx_gcdp WHERE fu_3rd=\"NA2\" AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNA2 .="UNION ALL ";
$sqlNA2 .="SELECT \"visita_fechamento\", SUM(1) AS visita_fechamento, SUM($multaDoc) as multa FROM adt_icx_gcdp WHERE visita_fechamento=\"NA2\" AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";

//echo $sqlNA;

$sqlOK = "";
$sqlOK .="SELECT \"contract\", SUM(1) AS contract, SUM(0) as multa FROM adt_icx_gcdp WHERE (contract=\"OK\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlOK .="UNION ALL ";
$sqlOK .="SELECT \"san\", SUM(1) AS san, SUM(0) as multa FROM adt_icx_gcdp WHERE (san=\"OK\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlOK .="UNION ALL ";
$sqlOK .="SELECT \"can\", SUM(1) AS can, SUM(0) as multa FROM adt_icx_gcdp WHERE (can=\"OK\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlOK .="UNION ALL ";
$sqlOK .="SELECT \"rne\", SUM(1) AS rne, SUM(0) as multa FROM adt_icx_gcdp WHERE (rne=\"OK\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlOK .="UNION ALL ";
$sqlOK .="SELECT \"tr_checklist\", SUM(1) AS tr_checklist, SUM(0) as multa FROM adt_icx_gcdp WHERE tr_checklist=\"OK\" AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlOK .="UNION ALL ";
$sqlOK .="SELECT \"fu_1st\", SUM(1) AS fu_1st, SUM(0) as multa FROM adt_icx_gcdp WHERE (fu_1st=\"OK\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlOK .="UNION ALL ";
$sqlOK .="SELECT \"fu_3rd\", SUM(1) AS fu_3rd, SUM(0) as multa FROM adt_icx_gcdp WHERE (fu_3rd=\"OK\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlOK .="UNION ALL ";
$sqlOK .="SELECT \"visita_fechamento\", SUM(1) AS visita_fechamento, SUM(0) as multa FROM adt_icx_gcdp WHERE (visita_fechamento=\"OK\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";

$sqlOK2 = "";
$sqlOK2 .="SELECT \"contract\", SUM(1) AS contract, SUM(0) as multa FROM adt_icx_gcdp WHERE (contract=\"OK2\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlOK2 .="UNION ALL ";
$sqlOK2 .="SELECT \"san\", SUM(1) AS san, SUM(0) as multa FROM adt_icx_gcdp WHERE (san=\"OK2\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlOK2 .="UNION ALL ";
$sqlOK2 .="SELECT \"can\", SUM(1) AS can, SUM(0) as multa FROM adt_icx_gcdp WHERE (can=\"OK2\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlOK2 .="UNION ALL ";
$sqlOK2 .="SELECT \"rne\", SUM(1) AS rne, SUM(0) as multa FROM adt_icx_gcdp WHERE (rne=\"OK2\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlOK2 .="UNION ALL ";
$sqlOK2 .="SELECT \"tr_checklist\", SUM(1) AS tr_checklist, SUM(0) as multa FROM adt_icx_gcdp WHERE tr_checklist=\"OK2\" AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlOK2 .="UNION ALL ";
$sqlOK2 .="SELECT \"fu_1st\", SUM(1) AS fu_1st, SUM(0) as multa FROM adt_icx_gcdp WHERE (fu_1st=\"OK2\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlOK2 .="UNION ALL ";
$sqlOK2 .="SELECT \"fu_3rd\", SUM(1) AS fu_3rd, SUM(0) as multa FROM adt_icx_gcdp WHERE (fu_3rd=\"OK2\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlOK2 .="UNION ALL ";
$sqlOK2 .="SELECT \"visita_fechamento\", SUM(1) AS visita_fechamento, SUM(0) as multa FROM adt_icx_gcdp WHERE (visita_fechamento=\"OK2\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";

// echo 'sqlNE: '. $sqlNE;
// echo 'sqlNA: '. $sqlNA;
// echo 'sqlOK: '. $sqlOK;

$res['GCDPi']['ne'] = $db->select2($sqlNE);
$res['GCDPi']['ne2'] = $db->select2($sqlNE2);
$res['GCDPi']['na'] = $db->select2($sqlNA);
$res['GCDPi']['na2'] = $db->select2($sqlNA2);
$res['GCDPi']['ok'] = $db->select2($sqlOK);
$res['GCDPi']['ok2'] = $db->select2($sqlOK2);

$sqlNE = "";
$sqlNE .="SELECT \"contract\", SUM(1) AS contract, SUM($multaDoc) as multa FROM adt_icx_gip WHERE (contract=\"NE\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNE .="UNION ALL ";
$sqlNE .="SELECT \"san\", SUM(1) AS san, SUM($multaDoc) as multa FROM adt_icx_gip WHERE (san=\"NE\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNE .="UNION ALL ";
$sqlNE .="SELECT \"can\", SUM(1) AS can, SUM($multaDoc) as multa FROM adt_icx_gip WHERE (can=\"NE\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNE .="UNION ALL ";
$sqlNE .="SELECT \"rne\", SUM(1) AS rne, SUM($multaDoc) as multa FROM adt_icx_gip WHERE (rne=\"NE\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNE .="UNION ALL ";
$sqlNE .="SELECT \"tr_checklist\", SUM(1) AS tr_checklist, SUM($multaDoc) as multa FROM adt_icx_gip WHERE (tr_checklist=\"NE\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNE .="UNION ALL ";
$sqlNE .="SELECT \"fu_1st_week\", SUM(1) AS fu_1st_week, SUM($multaFU) as multa FROM adt_icx_gip WHERE (fu_1st_week=\"NE\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNE .="UNION ALL ";
$sqlNE .="SELECT \"fu_1st_month\", SUM(1) AS fu_1st_month, SUM($multaFU) as multa FROM adt_icx_gip WHERE (fu_1st_month=\"NE\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
for($i=45;$i<=360;$i+=45){
	$sqlNE .="UNION ALL ";
	$sqlNE .="SELECT \"fu_plus_$i\", SUM(1) AS fu_plus_$i, SUM($multaFU) as multa FROM adt_icx_gip WHERE (fu_plus_$i=\"NE\" OR fu_plus_$i=\"NE2\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
}
$sqlNE .="UNION ALL ";
$sqlNE .="SELECT \"visita_fechamento\", SUM(1) AS visita_fechamento, SUM($multaDoc) as multa FROM adt_icx_gip WHERE (visita_fechamento=\"NE\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";

$sqlNE2 = "";
$sqlNE2 .="SELECT \"contract\", SUM(1) AS contract, SUM($multaDoc) as multa FROM adt_icx_gip WHERE (contract=\"NE2\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNE2 .="UNION ALL ";
$sqlNE2 .="SELECT \"san\", SUM(1) AS san, SUM($multaDoc) as multa FROM adt_icx_gip WHERE (san=\"NE2\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNE2 .="UNION ALL ";
$sqlNE2.="SELECT \"can\", SUM(1) AS can, SUM($multaDoc) as multa FROM adt_icx_gip WHERE (can=\"NE2\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNE2 .="UNION ALL ";
$sqlNE2 .="SELECT \"rne\", SUM(1) AS rne, SUM($multaDoc) as multa FROM adt_icx_gip WHERE (rne=\"NE2\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNE2 .="UNION ALL ";
$sqlNE2 .="SELECT \"tr_checklist\", SUM(1) AS tr_checklist, SUM($multaDoc) as multa FROM adt_icx_gip WHERE (tr_checklist=\"NE2\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNE2 .="UNION ALL ";
$sqlNE2 .="SELECT \"fu_1st_week\", SUM(1) AS fu_1st_week, SUM($multaFU) as multa FROM adt_icx_gip WHERE (fu_1st_week=\"NE2\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNE2 .="UNION ALL ";
$sqlNE2 .="SELECT \"fu_1st_month\", SUM(1) AS fu_1st_month, SUM($multaFU) as multa FROM adt_icx_gip WHERE (fu_1st_month=\"NE2\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
for($i=45;$i<=360;$i+=45){
	$sqlNE2 .="UNION ALL ";
	$sqlNE2 .="SELECT \"fu_plus_$i\", SUM(1) AS fu_plus_$i, SUM($multaFU) as multa FROM adt_icx_gip WHERE (fu_plus_$i=\"NE2\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
}
$sqlNE2 .="UNION ALL ";
$sqlNE2 .="SELECT \"visita_fechamento\", SUM(1) AS visita_fechamento, SUM($multaDoc) as multa FROM adt_icx_gip WHERE (visita_fechamento=\"NE2\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";

$sqlNA = "";
$sqlNA .="SELECT \"contract\", SUM(1) AS contract, SUM($multaDoc) as multa FROM adt_icx_gip WHERE (contract=\"NA\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNA .="UNION ALL ";
$sqlNA .="SELECT \"san\", SUM(1) AS san, SUM($multaDoc) as multa FROM adt_icx_gip WHERE (san=\"NA\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNA .="UNION ALL ";
$sqlNA .="SELECT \"can\", SUM(1) AS can, SUM($multaDoc) as multa FROM adt_icx_gip WHERE (can=\"NA\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNA .="UNION ALL ";
$sqlNA .="SELECT \"rne\", SUM(1) AS rne, SUM($multaDoc) as multa FROM adt_icx_gip WHERE (rne=\"NA\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNA .="UNION ALL ";
$sqlNA .="SELECT \"tr_checklist\", SUM(1) AS tr_checklist, SUM($multaDoc) as multa FROM adt_icx_gip WHERE (tr_checklist=\"NA\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNA .="UNION ALL ";
$sqlNA .="SELECT \"fu_1st_week\", SUM(1) AS fu_1st_week, SUM($multaFU) as multa FROM adt_icx_gip WHERE (fu_1st_week=\"NA\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNA .="UNION ALL ";
$sqlNA .="SELECT \"fu_1st_month\", SUM(1) AS fu_1st_month, SUM($multaFU) as multa FROM adt_icx_gip WHERE (fu_1st_month=\"NA\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";

for($i=45;$i<=360;$i+=45){
	$sqlNA .="UNION ALL ";
	$sqlNA .="SELECT \"fu_plus_$i\", SUM(1) AS fu_plus_$i, SUM($multaFU) as multa FROM adt_icx_gip WHERE (fu_plus_$i=\"NA\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
}
$sqlNA .="UNION ALL ";
$sqlNA .="SELECT \"visita_fechamento\", SUM(1) AS visita_fechamento, SUM($multaDoc) as multa FROM adt_icx_gip WHERE (visita_fechamento=\"NA\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";

$sqlNA2 = "";
$sqlNA2 .="SELECT \"contract\", SUM(1) AS contract, SUM($multaDoc) as multa FROM adt_icx_gip WHERE (contract=\"NA2\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNA2 .="UNION ALL ";
$sqlNA2 .="SELECT \"san\", SUM(1) AS san, SUM($multaDoc) as multa FROM adt_icx_gip WHERE (san=\"NA2\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNA2 .="UNION ALL ";
$sqlNA2 .="SELECT \"can\", SUM(1) AS can, SUM($multaDoc) as multa FROM adt_icx_gip WHERE (can=\"NA2\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNA2 .="UNION ALL ";
$sqlNA2 .="SELECT \"rne\", SUM(1) AS rne, SUM($multaDoc) as multa FROM adt_icx_gip WHERE (rne=\"NA2\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNA2 .="UNION ALL ";
$sqlNA2 .="SELECT \"tr_checklist\", SUM(1) AS tr_checklist, SUM($multaDoc) as multa FROM adt_icx_gip WHERE (tr_checklist=\"NA2\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNA2 .="UNION ALL ";
$sqlNA2 .="SELECT \"fu_1st_week\", SUM(1) AS fu_1st_week, SUM($multaFU) as multa FROM adt_icx_gip WHERE (fu_1st_week=\"NA2\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNA2 .="UNION ALL ";
$sqlNA2 .="SELECT \"fu_1st_month\", SUM(1) AS fu_1st_month, SUM($multaFU) as multa FROM adt_icx_gip WHERE (fu_1st_month=\"NA2\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
for($i=45;$i<=360;$i+=45){
	$sqlNA2 .="UNION ALL ";
	$sqlNA2 .="SELECT \"fu_plus_$i\", SUM(1) AS fu_plus_$i, SUM($multaFU) as multa FROM adt_icx_gip WHERE (fu_plus_$i=\"NA2\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
}
$sqlNA2 .="UNION ALL ";
$sqlNA2 .="SELECT \"visita_fechamento\", SUM(1) AS visita_fechamento, SUM($multaDoc) as multa FROM adt_icx_gip WHERE (visita_fechamento=\"NA2\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";


$sqlOK = "";
$sqlOK .="SELECT \"contract\", SUM(1) AS contract, SUM(0) as multa FROM adt_icx_gip WHERE (contract=\"OK\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlOK .="UNION ALL ";
$sqlOK .="SELECT \"san\", SUM(1) AS san, SUM(0) as multa FROM adt_icx_gip WHERE (san=\"OK\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlOK .="UNION ALL ";
$sqlOK .="SELECT \"can\", SUM(1) AS can, SUM(0) as multa FROM adt_icx_gip WHERE (can=\"OK\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlOK .="UNION ALL ";
$sqlOK .="SELECT \"rne\", SUM(1) AS rne, SUM(0) as multa FROM adt_icx_gip WHERE (rne=\"OK\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlOK .="UNION ALL ";
$sqlOK .="SELECT \"tr_checklist\", SUM(1) AS tr_checklist, SUM(0) as multa FROM adt_icx_gip WHERE (tr_checklist=\"OK\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlOK .="UNION ALL ";
$sqlOK .="SELECT \"fu_1st_week\", SUM(1) AS fu_1st_week, SUM(0) as multa FROM adt_icx_gip WHERE (fu_1st_week=\"OK\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlOK .="UNION ALL ";
$sqlOK .="SELECT \"fu_1st_month\", SUM(1) AS fu_1st_month, SUM(0) as multa FROM adt_icx_gip WHERE (fu_1st_month=\"OK\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";

for($i=45;$i<=360;$i+=45){
	$sqlOK .="UNION ALL ";
	$sqlOK .="SELECT \"fu_plus_$i\", SUM(1) AS fu_plus_$i, SUM(0) as multa FROM adt_icx_gip WHERE (fu_plus_$i=\"OK\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
}
$sqlOK .="UNION ALL ";
$sqlOK .="SELECT \"visita_fechamento\", SUM(1) AS visita_fechamento, SUM(0) as multa FROM adt_icx_gip WHERE (visita_fechamento=\"OK\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";

$sqlOK2 = "";
$sqlOK2 .="SELECT \"contract\", SUM(1) AS contract, SUM(0) as multa FROM adt_icx_gip WHERE (contract=\"OK2\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlOK2 .="UNION ALL ";
$sqlOK2 .="SELECT \"san\", SUM(1) AS san, SUM(0) as multa FROM adt_icx_gip WHERE (san=\"OK2\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlOK2 .="UNION ALL ";
$sqlOK2 .="SELECT \"can\", SUM(1) AS can, SUM(0) as multa FROM adt_icx_gip WHERE (can=\"OK2\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlOK2 .="UNION ALL ";
$sqlOK2 .="SELECT \"rne\", SUM(1) AS rne, SUM(0) as multa FROM adt_icx_gip WHERE (rne=\"OK2\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlOK2 .="UNION ALL ";
$sqlOK2 .="SELECT \"tr_checklist\", SUM(1) AS tr_checklist, SUM(0) as multa FROM adt_icx_gip WHERE (tr_checklist=\"OK2\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlOK2 .="UNION ALL ";
$sqlOK2 .="SELECT \"fu_1st_week\", SUM(1) AS fu_1st_week, SUM(0) as multa FROM adt_icx_gip WHERE (fu_1st_week=\"OK2\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlOK2 .="UNION ALL ";
$sqlOK2 .="SELECT \"fu_1st_month\", SUM(1) AS fu_1st_month, SUM(0) as multa FROM adt_icx_gip WHERE (fu_1st_month=\"OK2\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";

for($i=45;$i<=360;$i+=45){
	$sqlOK2 .="UNION ALL ";
	$sqlOK2 .="SELECT \"fu_plus_$i\", SUM(1) AS fu_plus_$i, SUM(0) as multa FROM adt_icx_gip WHERE (fu_plus_$i=\"OK2\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
}
$sqlOK2 .="UNION ALL ";
$sqlOK2 .="SELECT \"visita_fechamento\", SUM(1) AS visita_fechamento, SUM(0) as multa FROM adt_icx_gip WHERE (visita_fechamento=\"OK2\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";

$res['GIPi']['ne'] = $db->select2($sqlNE);
$res['GIPi']['ne2'] = $db->select2($sqlNE2);
$res['GIPi']['na'] = $db->select2($sqlNA);
$res['GIPi']['na2'] = $db->select2($sqlNA2);
$res['GIPi']['ok'] = $db->select2($sqlOK);
$res['GIPi']['ok2'] = $db->select2($sqlOK2);

$sqlNE = "";
$sqlNE .="SELECT \"contract\", SUM(1) AS contract, SUM($multaDoc) as multa FROM adt_ogx_gcdp WHERE (contract=\"NE\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNE .="UNION ALL ";
$sqlNE .="SELECT \"san\", SUM(1) AS san, SUM($multaDoc) as multa FROM adt_ogx_gcdp WHERE (san=\"NE\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNE .="UNION ALL ";
$sqlNE .="SELECT \"can\", SUM(1) AS can, SUM($multaDoc) as multa FROM adt_ogx_gcdp WHERE (can=\"NE\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNE .="UNION ALL ";
$sqlNE .="SELECT \"ep_checklist\", SUM(1) AS ep_checklist, SUM($multaDoc) as multa FROM adt_ogx_gcdp WHERE (ep_checklist=\"NE\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNE .="UNION ALL ";
$sqlNE .="SELECT \"fu_1st\", SUM(1) AS fu_1st, SUM($multaDoc) as multa FROM adt_ogx_gcdp WHERE (fu_1st=\"NE\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNE .="UNION ALL ";
$sqlNE .="SELECT \"fu_3rd\", SUM(1) AS fu_3rd, SUM($multaDoc) as multa FROM adt_ogx_gcdp WHERE (fu_3rd=\"NE\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";

$sqlNE2 = "";
$sqlNE2 .="SELECT \"contract\", SUM(1) AS contract, SUM($multaDoc) as multa FROM adt_ogx_gcdp WHERE (contract=\"NE2\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNE2 .="UNION ALL ";
$sqlNE2.="SELECT \"san\", SUM(1) AS san, SUM($multaDoc) as multa FROM adt_ogx_gcdp WHERE (san=\"NE2\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNE2 .="UNION ALL ";
$sqlNE2 .="SELECT \"can\", SUM(1) AS can, SUM($multaDoc) as multa FROM adt_ogx_gcdp WHERE (can=\"NE2\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNE2 .="UNION ALL ";
$sqlNE2 .="SELECT \"ep_checklist\", SUM(1) AS ep_checklist, SUM($multaDoc) as multa FROM adt_ogx_gcdp WHERE (ep_checklist=\"NE2\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNE2 .="UNION ALL ";
$sqlNE2 .="SELECT \"fu_1st\", SUM(1) AS fu_1st, SUM($multaFU) as multa FROM adt_ogx_gcdp WHERE (fu_1st=\"NE2\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNE2 .="UNION ALL ";
$sqlNE2 .="SELECT \"fu_3rd\", SUM(1) AS fu_3rd, SUM($multaFU) as multa FROM adt_ogx_gcdp WHERE (fu_3rd=\"NE2\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";

$sqlNA = "";
$sqlNA .="SELECT \"contract\", SUM(1) AS contract, SUM($multaDoc) as multa FROM adt_ogx_gcdp WHERE (contract=\"NA\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNA .="UNION ALL ";
$sqlNA .="SELECT \"san\", SUM(1) AS san, SUM($multaDoc) as multa FROM adt_ogx_gcdp WHERE (san=\"NA\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNA .="UNION ALL ";
$sqlNA .="SELECT \"can\", SUM(1) AS can, SUM($multaDoc) as multa FROM adt_ogx_gcdp WHERE (can=\"NA\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNA .="UNION ALL ";
$sqlNA .="SELECT \"ep_checklist\", SUM(1) AS ep_checklist, SUM($multaDoc) as multa FROM adt_ogx_gcdp WHERE (ep_checklist=\"NA\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNA .="UNION ALL ";
$sqlNA .="SELECT \"fu_1st\", SUM(1) AS fu_1st, SUM($multaDoc) as multa FROM adt_ogx_gcdp WHERE (fu_1st=\"NA\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNA .="UNION ALL ";
$sqlNA .="SELECT \"fu_3rd\", SUM(1) AS fu_3rd, SUM($multaDoc) as multa FROM adt_ogx_gcdp WHERE (fu_3rd=\"NA\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";

$sqlNA2 = "";
$sqlNA2 .="SELECT \"contract\", SUM(1) AS contract, SUM($multaDoc) as multa FROM adt_ogx_gcdp WHERE (contract=\"NA2\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNA2 .="UNION ALL ";
$sqlNA2 .="SELECT \"san\", SUM(1) AS san, SUM($multaDoc) as multa FROM adt_ogx_gcdp WHERE (san=\"NA2\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNA2 .="UNION ALL ";
$sqlNA2 .="SELECT \"can\", SUM(1) AS can, SUM($multaDoc) as multa FROM adt_ogx_gcdp WHERE (can=\"NA2\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNA2 .="UNION ALL ";
$sqlNA2 .="SELECT \"ep_checklist\", SUM(1) AS ep_checklist, SUM($multaDoc) as multa FROM adt_ogx_gcdp WHERE (ep_checklist=\"NA2\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNA2 .="UNION ALL ";
$sqlNA2 .="SELECT \"fu_1st\", SUM(1) AS fu_1st, SUM($multaFU) as multa FROM adt_ogx_gcdp WHERE (fu_1st=\"NA2\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNA2 .="UNION ALL ";
$sqlNA2 .="SELECT \"fu_3rd\", SUM(1) AS fu_3rd, SUM($multaFU) as multa FROM adt_ogx_gcdp WHERE (fu_3rd=\"NA2\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";

$sqlOK = "";
$sqlOK .="SELECT \"contract\", SUM(1) AS contract, SUM($multaDoc) as multa FROM adt_ogx_gcdp WHERE (contract=\"OK\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlOK .="UNION ALL ";
$sqlOK .="SELECT \"san\", SUM(1) AS san, SUM($multaDoc) as multa FROM adt_ogx_gcdp WHERE (san=\"OK\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlOK .="UNION ALL ";
$sqlOK .="SELECT \"can\", SUM(1) AS can, SUM($multaDoc) as multa FROM adt_ogx_gcdp WHERE (can=\"OK\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlOK .="UNION ALL ";
$sqlOK .="SELECT \"ep_checklist\", SUM(1) AS ep_checklist, SUM($multaDoc) as multa FROM adt_ogx_gcdp WHERE (ep_checklist=\"OK\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlOK .="UNION ALL ";
$sqlOK .="SELECT \"fu_1st\", SUM(1) AS fu_1st, SUM($multaDoc) as multa FROM adt_ogx_gcdp WHERE (fu_1st=\"OK\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlOK .="UNION ALL ";
$sqlOK .="SELECT \"fu_3rd\", SUM(1) AS fu_3rd, SUM($multaDoc) as multa FROM adt_ogx_gcdp WHERE (fu_3rd=\"OK\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";

$sqlOK2 = "";
$sqlOK2 .="SELECT \"contract\", SUM(1) AS contract, SUM($multaDoc) as multa FROM adt_ogx_gcdp WHERE (contract=\"OK2\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlOK2 .="UNION ALL ";
$sqlOK2 .="SELECT \"san\", SUM(1) AS san, SUM($multaDoc) as multa FROM adt_ogx_gcdp WHERE (san=\"OK2\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlOK2 .="UNION ALL ";
$sqlOK2 .="SELECT \"can\", SUM(1) AS can, SUM($multaDoc) as multa FROM adt_ogx_gcdp WHERE (can=\"OK2\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlOK2 .="UNION ALL ";
$sqlOK2 .="SELECT \"ep_checklist\", SUM(1) AS ep_checklist, SUM($multaDoc) as multa FROM adt_ogx_gcdp WHERE (ep_checklist=\"OK2\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlOK2 .="UNION ALL ";
$sqlOK2 .="SELECT \"fu_1st\", SUM(1) AS fu_1st, SUM($multaDoc) as multa FROM adt_ogx_gcdp WHERE (fu_1st=\"OK2\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlOK2 .="UNION ALL ";
$sqlOK2 .="SELECT \"fu_3rd\", SUM(1) AS fu_3rd, SUM($multaDoc) as multa FROM adt_ogx_gcdp WHERE (fu_3rd=\"OK2\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";

$res['GCDPo']['ne'] = $db->select2($sqlNE);
$res['GCDPo']['ne2'] = $db->select2($sqlNE2);
$res['GCDPo']['na'] = $db->select2($sqlNA);
$res['GCDPo']['na2'] = $db->select2($sqlNA2);
$res['GCDPo']['ok'] = $db->select2($sqlOK);
$res['GCDPo']['ok2'] = $db->select2($sqlOK2);


$sqlNE = "";
$sqlNE .="SELECT \"contract\", SUM(1) AS contract, SUM($multaDoc) as multa FROM adt_ogx_gip WHERE (contract=\"NE\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNE .="UNION ALL ";
$sqlNE .="SELECT \"san\", SUM(1) AS san, SUM($multaDoc) as multa FROM adt_ogx_gip WHERE (san=\"NE\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNE .="UNION ALL ";
$sqlNE .="SELECT \"can\", SUM(1) AS can, SUM($multaDoc) as multa FROM adt_ogx_gip WHERE (can=\"NE\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNE .="UNION ALL ";
$sqlNE .="SELECT \"ep_checklist\", SUM(1) AS ep_checklist, SUM($multaDoc) as multa FROM adt_ogx_gip WHERE (ep_checklist=\"NE\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNE .="UNION ALL ";
$sqlNE .="SELECT \"fu_1st_week\", SUM(1) AS fu_1st_week, SUM($multaDoc) as multa FROM adt_ogx_gip WHERE (fu_1st_week=\"NE\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNE .="UNION ALL ";
$sqlNE .="SELECT \"fu_1st_month\", SUM(1) AS fu_1st_month, SUM($multaDoc) as multa FROM adt_ogx_gip WHERE (fu_1st_month=\"NE\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";

for($i=45;$i<=360;$i+=45){
	$sqlNE .="UNION ALL ";
	$sqlNE .="SELECT \"fu_plus_$i\", SUM(1) AS fu_plus_$i, SUM($multaDoc) as multa FROM adt_ogx_gip WHERE (fu_plus_$i=\"NE\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
}

$sqlNE2 = "";
$sqlNE2 .="SELECT \"contract\", SUM(1) AS contract, SUM($multaDoc) as multa FROM adt_ogx_gip WHERE (contract=\"NE2\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNE2 .="UNION ALL ";
$sqlNE2 .="SELECT \"san\", SUM(1) AS san, SUM($multaDoc) as multa FROM adt_ogx_gip WHERE (san=\"NE2\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNE2 .="UNION ALL ";
$sqlNE2 .="SELECT \"can\", SUM(1) AS can, SUM($multaDoc) as multa FROM adt_ogx_gip WHERE (can=\"NE2\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNE2 .="UNION ALL ";
$sqlNE2 .="SELECT \"ep_checklist\", SUM(1) AS ep_checklist, SUM($multaDoc) as multa FROM adt_ogx_gip WHERE (ep_checklist=\"NE2\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNE2 .="UNION ALL ";
$sqlNE2 .="SELECT \"fu_1st_week\", SUM(1) AS fu_1st_week, SUM($multaFU) as multa FROM adt_ogx_gip WHERE (fu_1st_week=\"NE2\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNE2 .="UNION ALL ";
$sqlNE2 .="SELECT \"fu_1st_month\", SUM(1) AS fu_1st_month, SUM($multaFU) as multa FROM adt_ogx_gip WHERE (fu_1st_month=\"NE2\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";

for($i=45;$i<=360;$i+=45){
	$sqlNE2 .="UNION ALL ";
	$sqlNE2 .="SELECT \"fu_plus_$i\", SUM(1) AS fu_plus_$i, SUM($multaFU) as multa FROM adt_ogx_gip WHERE (fu_plus_$i=\"NE2\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
}

$sqlNA = "";
$sqlNA .="SELECT \"contract\", SUM(1) AS contract, SUM($multaDoc) as multa FROM adt_ogx_gip WHERE (contract=\"NA\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNA .="UNION ALL ";
$sqlNA .="SELECT \"san\", SUM(1) AS san, SUM($multaDoc) as multa FROM adt_ogx_gip WHERE (san=\"NA\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNA .="UNION ALL ";
$sqlNA .="SELECT \"can\", SUM(1) AS can, SUM($multaDoc) as multa FROM adt_ogx_gip WHERE (can=\"NA\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNA .="UNION ALL ";
$sqlNA .="SELECT \"ep_checklist\", SUM(1) AS ep_checklist, SUM($multaDoc) as multa FROM adt_ogx_gip WHERE (ep_checklist=\"NA\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNA .="UNION ALL ";
$sqlNA .="SELECT \"fu_1st_week\", SUM(1) AS fu_1st_week, SUM($multaDoc) as multa FROM adt_ogx_gip WHERE (fu_1st_week=\"NA\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNA .="UNION ALL ";
$sqlNA .="SELECT \"fu_1st_month\", SUM(1) AS fu_1st_month, SUM($multaDoc) as multa FROM adt_ogx_gip WHERE (fu_1st_month=\"NA\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";

for($i=45;$i<=360;$i+=45){
	$sqlNA .="UNION ALL ";
	$sqlNA .="SELECT \"fu_plus_$i\", SUM(1) AS fu_plus_$i, SUM($multaDoc) as multa FROM adt_ogx_gip WHERE (fu_plus_$i=\"NA\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
}


$sqlNA2 = "";
$sqlNA2 .="SELECT \"contract\", SUM(1) AS contract, SUM($multaDoc) as multa FROM adt_ogx_gip WHERE (contract=\"NA2\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNA2 .="UNION ALL ";
$sqlNA2 .="SELECT \"san\", SUM(1) AS san, SUM($multaDoc) as multa FROM adt_ogx_gip WHERE (san=\"NA2\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNA2 .="UNION ALL ";
$sqlNA2 .="SELECT \"can\", SUM(1) AS can, SUM($multaDoc) as multa FROM adt_ogx_gip WHERE (can=\"NA2\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNA2 .="UNION ALL ";
$sqlNA2 .="SELECT \"ep_checklist\", SUM(1) AS ep_checklist, SUM($multaDoc) as multa FROM adt_ogx_gip WHERE (ep_checklist=\"NA2\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNA2 .="UNION ALL ";
$sqlNA2 .="SELECT \"fu_1st_week\", SUM(1) AS fu_1st_week, SUM($multaFU) as multa FROM adt_ogx_gip WHERE (fu_1st_week=\"NA2\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlNA2 .="UNION ALL ";
$sqlNA2 .="SELECT \"fu_1st_month\", SUM(1) AS fu_1st_month, SUM($multaFU) as multa FROM adt_ogx_gip WHERE (fu_1st_month=\"NA2\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";

for($i=45;$i<=360;$i+=45){
	$sqlNA2 .="UNION ALL ";
	$sqlNA2 .="SELECT \"fu_plus_$i\", SUM(1) AS fu_plus_$i, SUM($multaFU) as multa FROM adt_ogx_gip WHERE (fu_plus_$i=\"NA2\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
}

$sqlOK = "";
$sqlOK .="SELECT \"contract\", SUM(1) AS contract, SUM($multaDoc) as multa FROM adt_ogx_gip WHERE (contract=\"OK\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlOK .="UNION ALL ";
$sqlOK .="SELECT \"san\", SUM(1) AS san, SUM($multaDoc) as multa FROM adt_ogx_gip WHERE (san=\"OK\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlOK .="UNION ALL ";
$sqlOK .="SELECT \"can\", SUM(1) AS can, SUM($multaDoc) as multa FROM adt_ogx_gip WHERE (can=\"OK\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlOK .="UNION ALL ";
$sqlOK .="SELECT \"ep_checklist\", SUM(1) AS ep_checklist, SUM($multaDoc) as multa FROM adt_ogx_gip WHERE (ep_checklist=\"OK\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlOK .="UNION ALL ";
$sqlOK .="SELECT \"fu_1st_week\", SUM(1) AS fu_1st_week, SUM($multaDoc) as multa FROM adt_ogx_gip WHERE (fu_1st_week=\"OK\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlOK .="UNION ALL ";
$sqlOK .="SELECT \"fu_1st_month\", SUM(1) AS fu_1st_month, SUM($multaDoc) as multa FROM adt_ogx_gip WHERE (fu_1st_month=\"OK\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";

for($i=45;$i<=360;$i+=45){
	$sqlOK .="UNION ALL ";
	$sqlOK .="SELECT \"fu_plus_$i\", SUM(1) AS fu_plus_$i, SUM($multaDoc) as multa FROM adt_ogx_gip WHERE (fu_plus_$i=\"OK\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
}

$sqlOK2 = "";
$sqlOK2 .="SELECT \"contract\", SUM(1) AS contract, SUM($multaDoc) as multa FROM adt_ogx_gip WHERE (contract=\"OK2\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlOK2 .="UNION ALL ";
$sqlOK2 .="SELECT \"san\", SUM(1) AS san, SUM($multaDoc) as multa FROM adt_ogx_gip WHERE (san=\"OK2\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlOK2 .="UNION ALL ";
$sqlOK2 .="SELECT \"can\", SUM(1) AS can, SUM($multaDoc) as multa FROM adt_ogx_gip WHERE (can=\"OK2\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlOK2 .="UNION ALL ";
$sqlOK2 .="SELECT \"ep_checklist\", SUM(1) AS ep_checklist, SUM($multaDoc) as multa FROM adt_ogx_gip WHERE (ep_checklist=\"OK2\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlOK2 .="UNION ALL ";
$sqlOK2 .="SELECT \"fu_1st_week\", SUM(1) AS fu_1st_week, SUM($multaDoc) as multa FROM adt_ogx_gip WHERE (fu_1st_week=\"OK2\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
$sqlOK2 .="UNION ALL ";
$sqlOK2 .="SELECT \"fu_1st_month\", SUM(1) AS fu_1st_month, SUM($multaDoc) as multa FROM adt_ogx_gip WHERE (fu_1st_month=\"OK2\")  AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";

for($i=45;$i<=360;$i+=45){
	$sqlOK2 .="UNION ALL ";
	$sqlOK2 .="SELECT \"fu_plus_$i\", SUM(1) AS fu_plus_$i, SUM($multaDoc) as multa FROM adt_ogx_gip WHERE (fu_plus_$i=\"OK2\") AND clID=$cl AND periodId=$period AND status not in ('On Hold','Rejected','Expired','New','')";
}

// echo $sqlNE ."<br /><br />"; 
// echo $sqlNA ."<br /><br />"; 
// echo $sqlOK ."<br /><br />"; 
// echo $sqlOK2 ."<br /><br />"; 

$res['GIPo']['ne'] = $db->select2($sqlNE);
$res['GIPo']['ne2'] = $db->select2($sqlNE2);
$res['GIPo']['na'] = $db->select2($sqlNA);
$res['GIPo']['na2'] = $db->select2($sqlNA2);
$res['GIPo']['ok'] = $db->select2($sqlOK);
$res['GIPo']['ok2'] = $db->select2($sqlOK2);

print json_encode($res);
