<?php
require_once dirname(__FILE__) . "\..\include.php";
Util::requireNonLogin();
?>

<html>
<head>
<title>ADT Tool (alpha) - AIESEC in Brazil</title>

<link rel="stylesheet" type="text/css" href="../res/css/login.css" media="all" />
<link rel="stylesheet" type="text/css" href="../res/css/styles.css" />
<link rel="stylesheet" type="text/css" href="../res/css/smoothness/jquery-ui-1.9.1.custom.css" />

<script src="../res/js/jquery-1.8.2.js"></script>
<script src="../res/js/jquery-ui-1.9.1.custom.js"></script>

</head>
<body>
	<div id="loginBox">
		<div id="loginForm">
			<div align='center' style='background: #ffffff'><img src="../res/img/tna_logo_mini.png" /></div>
			<form action="loginDo.php" method="post">
				<fieldset id="body">
					<fieldset>
						<label for="email">My@ email</label> <input type="text"
							name="user" id="user" />
					</fieldset>
					<fieldset>
						<label for="password">My@ password</label> <input type="password"
							name="pass" id="pass" />
					</fieldset>
					<?php
					if (isset($_GET['m']))
						echo "<span class='msg'>" . $_GET['m'] ."</span>";
					?>
					<button class="button" type="submit" name="submit" id="submit">Sign
						in</button>
				</fieldset>
			</form>
			<span>Use <a href="http://www.myaiesec.net" target="_blank">myAiesec.net</a>
				credentials.
			</span>
		</div>
	</div>
	<br />
	<div class="footer"></div>

</body>
</html>
