<?php
session_start();

//ob_implicit_flush(true);

require_once("./util/request.php");
require_once("./util/myaiesec.php");

$myAiesec = new MyAiesec("marcos.de.castro.limeira@gmail.com","wireless_flight");

$cl = $_GET['cl'];
$from = $_GET['from'];
$to = $_GET['to'];
$types_aux = $_GET['types'];

//<option value="1">Accepted</option>
//<option value="3">Matched</option>
//<option value="4">New</option>
//<option value="5">On Hold</option>
//<option value="6">Realized</option>
//<option value="7">Rejected</option>
//<option value="9">Available</option>
//<option value="11">Pending</option>
//<option value="12">Incomplete</option>
//$types = array(1,3,4,5,6,7,9,11,12);
$types = explode(',',$types_aux);

$tns = array();

$x = 0;

$myAiesec->initSearchTNs($cl,$from,$to);

foreach ($types as $type){
	$busca = $myAiesec->searchTNs($cl,$from,$to,$type);

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

print json_encode($tns);
