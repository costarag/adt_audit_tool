<?php
session_start();

//ob_implicit_flush(true);

require_once("util/MyAiesec.class.php");

$myAiesec = new MyAiesec("ricardo.costa@aiesec.net", "katito023");

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
$types = array(3,4,6,9);
//$types = explode(',',$types_aux);

$eps = array();

$x = 0;

$myAiesec->initSearchEPs($cl,$from,$to);

foreach ($types as $type){
	$busca = $myAiesec->searchEPs($cl,$from,$to,$type);

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

print json_encode($eps);
