<head>
<meta charset="utf8">
<title>ADT Tool (alpha) - AIESEC in Brazil</title>
<link rel="stylesheet" href="res/css/header.css" />
<script src="res/js/login.js"></script>
</head>

<div id="bar">
	<div id="headerLogo">
		<img src="res/img/tna_logo_mini.png"/> ADT Tool
	</div>
	<div id="headerMenu">
		<h4>&rsaquo;&rsaquo; Select LC and audit period</h4>
		<label>LC: </label> <select id="clId"></select> <span class="light"> <b>by</b>
		</span> <label>period: </label> <select id="periodId"></select>
		<button type="submit" id="bot">Go</button>
	</div>
	<?php 
	if (isset($_SESSION['user']['id'])){
		echo '<div id="headerLogin"><a href="login\logout.php">Log out</a></div>';
	}
	?>

</div>
