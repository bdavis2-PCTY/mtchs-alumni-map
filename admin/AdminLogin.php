<?php 
	
	// Admin login page 
	// Login form for admins to login into the administration system
	
	
	// This checks to see if the user is trying to login
	// When $_GET['ref'] is set, it is set to the email that is trying to login
    if(isset($_GET['ref'])){
    	
    	require "../class/Database.php";	// Gives access to $Database
    	require "requireLogin.php";			// Gives access to checking login & logging in functions 
    	
		// Check if the email exists
    	$q = $Database->query("SELECT * FROM VerifiedEmail WHERE LOWER(Email)='". strtolower($_GET['ref']) ."';");
    	if($q->num_rows == 1 ) {
			// Valid email, log them in
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
			// Gets called when a user clicks 'Login'
            function tryLogin(){
				// Hide current errors 
            	$("#loginError").css("display", "none");
            	
				// Get email input 
            	var email = $("#uiLoginEmail").val().trim().toLowerCase();
            	$("#uiLoginEmail").val("");
            	
				// Validate email input 
            	if ( email.trim() === "")
            		return emailError("Please enter an email address");
            	
            	if(!validateEmail(email))
            		return emailError("Enter a valid email address for the @mtchs.org domain");
            	
				// Check if the email exists in the db 
            	var r = ajaxRequest("SendAdminLogin", {email: email});
            	if ( r === "true" ){
					// Exists, let them know 
            		emailError("Valid email address, please check your email for a login URL");
            		$("#loginError").removeClass("red").addClass("green");
            		return true;
            	} else {
					// Doesnt exist 
            		return emailError("This email does not exist in our database");
            	}
            	
            }
            
			// Displays an error on login page
			// msg: the message to display  
            function emailError(msg){
            	$("#loginError").css("display", "block").text(msg);
            	return false;
            }
            
			// Validates it is a valid email address
            function validateEmail(email) {
            	var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            	if(re.test(email)){
					// Make sure its @mtchs.org domain
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