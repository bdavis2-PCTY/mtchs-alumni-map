<?php 

session_start();

if(!is_writable(session_save_path())){
	echo "<br /><br /><span style='color:red;font-weight:bold;'>Server session path is not writable</span><br /><br />";
}

function checkLogin(){
	if (!isset($_SESSION, $_SESSION['email'])){
		header("Location: AdminLogin.php");
		die();
	}
	
	return true;
}

function setLogin($email){
	if(isset($_SESSION))
		session_destroy();
	
	session_start();
	$_SESSION=array();
	$_SESSION['email'] = $email;
	
	header("Location: index.php");
	
	return true;
}
