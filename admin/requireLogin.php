<?php 

// Not actually a page, just a helper 
// Offers login functions to the login system 


// Kick of our session 
session_start();

// Validate there is access to create new sessions 
if(!is_writable(session_save_path())){
	echo "<br /><br /><span style='color:red;font-weight:bold;'>Server session path is not writable</span><br /><br />";
}

// Checks a login 
// If the user is not logged in, they are redirected to the login page 
// If the user is logged in, the function returns 'true'
function checkLogin(){
	if (!isset($_SESSION, $_SESSION['email'])){
		header("Location: AdminLogin.php");
		die();
	}
	
	return true;
}

// Sets a login 
// This function will set the session admin login
// Note: this does not validate the login, only sets 
// $email: The email to set for the login 
function setLogin($email){
	// Destroy the current session 
	if(isset($_SESSION))
		session_destroy();
	
	// Begin a new one 
	session_start();
	$_SESSION=array();
	
	// Set session variables 
	$_SESSION['email'] = $email;
	
	// Reload page 
	header("Location: index.php");
	
	return true;
}
