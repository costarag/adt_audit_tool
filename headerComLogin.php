<head>
<meta charset="utf8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>jQuery Dropdown Login Freebie | The Finished Box</title>
<link rel="stylesheet" href="res/css/login.css" />
<script src="res/js/login.js"></script>
<script type="text/javascript">
			$(document).ready(function() {

				$("#submit").click(function(event) {
					var user = $("#username").val();
					var pass = $("#password").val();

					var dataString = 'username=' + user + '&password=' + pass;

					$.ajax({
						type : "POST",
						url : "admin/loginproc.php",
						data : dataString,
						success : function() {
							//$("#authBox").load("login_status.php");
							// window.location.href = 'index.php?page=search';
							alert("bla bla");
						},
						error : function(jqXHR, textStatus, errorThrown) {
							$("#username").val('');
							$("#password").val('');
							$('#message').html(jqXHR.responseText);
						}
					});
				});

			});

		</script>
</head>

<div id="bar">
	<div id="containerlogin">
		<img src="res/img/tna_logo_mini.png" /> ADT Tool - v0.2 (alpha)
		<!-- Login Starts Here -->
		<div id="loginContainer">
			<a href="#" id="loginButton"><span>Login</span><em></em> </a>
			<div style="clear: both"></div>
			<div id="loginBox">
				<div id="loginForm">
					<fieldset id="body">
						<fieldset>
							<label for="email">My@ email</label> <input type="text"
								name="username" id="username" />
						</fieldset>
						<fieldset>
							<label for="password">My@ password</label> <input type="password"
								name="password" id="password" />
						</fieldset>
						<button class="button" type="button" name="submit" id="submit">
							Sign in
						</button>
					</fieldset>
					<span>Use <a href="http://www.myaiesec.net" target="_blank">myAiesec.net</a>
						credentials.
					</span>
				</div>
			</div>
		</div>
		<!-- Login Ends Here -->
	</div>
</div>
