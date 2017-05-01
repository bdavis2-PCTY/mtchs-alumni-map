<?php 


if(isset($_GET['ref'])){
	
	require "../class/Database.php";
	require "requireLogin.php";
	
	$q = $Database->query("SELECT * FROM VerifiedEmail WHERE LOWER(Email)='". strtolower($_GET['ref']) ."';");
	if($q->num_rows == 1 ) {
		
		setLogin($_GET['ref']);
		
		die();
	}
}


?>

<html>
	<head>
		<title>MTCHS Alumni Admin Login</title>
	
		<!-- jQuery -->
		<script src="../asset/jquery-3.2.0.js" type="text/javascript"></script>

		<!-- Semantic -->
		<script src="../asset/semantic/semantic.js" type="text/javascript"></script>
		<link rel="stylesheet" href="../asset/semantic/semantic.css" type="text/css" />
		
		<!-- Others -->
		<script src="../asset/ajaxRequest.js" type="text/javascript"></script>
		
		<style type="text/css">
			#wrapper{
				width:700px;
				margin:20px auto;
			}
			
			body{
				overflow:hidden;
			}
			
			#loginForm{
				padding:20px;
			}
			
			#loginForm .input input {
				width:540px;
			}
			
			#loginError {
				margin-bottom:10px;
				display:none;
			}
		</style>
		
		<script type='text/javascript'>
			function tryLogin(){
				$("#loginError").css("display", "none");
				
				var email = $("#uiLoginEmail").val().trim().toLowerCase();
				$("#uiLoginEmail").val("");
				
				if ( email.trim() === "")
					return emailError("Please enter an email address");
				
				if(!validateEmail(email))
					return emailError("Enter a valid email address that ends in @mtchs.org");
				
				var r = ajaxRequest("SendAdminLogin", {email: email});
				if ( r === "true" ){
					emailError("Valid email - check your email for a login link.");
					$("#loginError").removeClass("red").addClass("green");
					return true;
				} else {
					return emailError("Invalid email address - must be verified in our database");
				}
				
			}
			
			function emailError(msg){
				$("#loginError").css("display", "block").text(msg);
				return false;
			}
			
			function validateEmail(email) {
				var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
				if(re.test(email)){
					var split = email.split("@");
					if (split.length === 2 && split[1].toLowerCase() === "mtchs.org"){
						return true;
					}
				}
				return false;
			}
		</script>
	</head>
	
	<body>
		<div id='wrapper' class='ui center aligned segment'>
			<h1 class='ui header center'>MTCHS Alumni Admin</h1>
			<h3 class='ui grey header'>Administrator Login</h3>
			<hr />
			<div id='loginForm'>
				<h5 class='ui header'>Please enter your email address to login.<br />If it is a valid email address, a link will be emailed to you to login with.</h5>
			
				<div id='loginError' class='ui red label'>
					Test
				</div>

				<div class='ui large red input'>
					<input type="email" id='uiLoginEmail' placeholder='Email Address' class="ui red" />
				</div>
				
				<button class="ui blue large button" onclick='tryLogin();'>Login <i class='arrow right icon'></i></button>
			</div>
		</div>
	</body>
</html>