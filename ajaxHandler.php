<?php

header('Access-Control-Allow-Origin: *');

// $_POST=$_GET;

if(!ISSET($_POST['a']) && !ISSET($_GET['a'])){
	echo "'a' not set";
	return;
}

$a = $_POST['a'];

require "settings.php";
require "class/Alumni.php";
require "class/Database.php";
require "class/MapLocation.php";

try{
if ($a == "CityLocations"){
	// For loading locations on the map
	$locations = array();
	$req = $Database->query("SELECT * FROM MapLocation m
							JOIN Alumni a ON m.ID = a.Location 
							WHERE a.ID IS NOT NULL");
							
	while ($a = $req->fetch_array())
		$locations[] = new MapLocation($a['City'], $a['State'], $a['Longitude'], $a['Latitude']);
	responseHandler($locations);

	
	
	
	
} elseif ( $a == "StudentsInCity" && isset($_POST["City"])){
	// For loading the students in a city
	$lowerCity = strtolower($_POST['City']);
	$studentQuery = $Database->query("	SELECT
											a.ID 		ID,
											a.Name 		Name,
											a.GradYear 	GradYear,
											m.City 		City,
											m.State 	State,
											a.Education Education,
											a.Job 		Job,
											a.Salary 	Salary,
											CONCAT(m.City, ', ', m.State) Location
										FROM Alumni a
										JOIN MapLocation m ON a.Location = m.ID
										WHERE LOWER(m.City)='{$lowerCity}' OR LOWER(m.State)='{$lowerCity}'");

	$students = array();
	while ( $alumni = $studentQuery->fetch_array() ){
		$students[] = ConvertDbQueryToAlumni($alumni);
	}
	responseHandler($students);

	
	
	

} else if ( $a == "JobsAndSalary"){
	// To get the data for the jobs & salary page on the main MTCHS site
	$jobs = array();
	$query = $Database->query("SELECT Job, AVG(Salary) AS Salary FROM Alumni WHERE Salary IS NOT NULL AND Salary <> 0 GROUP BY Job");
	while ( $row = $query->fetch_array())
		$jobs[$row['Job']] = $row['Salary']; 
	responseHandler($jobs);
	
	
	
	
} else if($a == "StudentFromId" && isset($_POST['Id']) ) {
	// Gets a new alumni object from an existing ID
	$query = $Database->query("	SELECT
									a.ID 		ID,
									a.Name 		Name,
									a.GradYear 	GradYear,
									m.City 		City,
									m.State 	State,
									a.Education Education,
									a.Job 		Job,
									a.Salary 	Salary,
									CONCAT(m.City, ', ', m.State) Location
								FROM Alumni a
								JOIN MapLocation m ON a.Location = m.ID
								WHERE a.ID={$_POST['Id']}")->fetch_array();
	$alumni = ConvertDbQueryToAlumni($query);
	responseHandler($alumni);
	
	
} else if ($a == "SendAdminLogin" && isset($_POST['email'])){
	// Checks if an admin login is valid
	$email = strtolower($_POST['email']);
	$q = $Database->query("SELECT 1 FROM VerifiedEmail WHERE Email='{$email}'");
	if ( $q->num_rows > 0 ){
		mail($email, "MTCHS Alumni Admin Login", "Click the following link to login to the MTCHS Alumni Administrator site:\n{$APP_PATH}/admin/AdminLogin.php?ref={$email} \n\nIf you did not request this login, just ignore this message.");
		
		responseHandler(true);
	}else 
		responseHandler(false);
	
	
	
} else if ($a=="UnverifiedAlumni"){
	// Gets a list of all unverified alumni
	$aq = $Database->query("SELECT
									a.ID 		ID,
									a.Name 		Name,
									a.GradYear 	GradYear,
									m.City 		City,
									m.State 	State,
									a.Education Education,
									a.Job 		Job,
									a.Salary 	Salary,
									CONCAT(m.City, ', ', m.State) Location
								FROM UpdatedAlumni a
								JOIN MapLocation m ON a.Location = m.ID
								ORDER BY a.ID");
	
	$alumni = [];
	while($r = $aq->fetch_array())
		$alumni[] = ConvertDbQueryToAlumni($r);
	
	responseHandler($alumni);
	
	
	
} else if($a == 'New') {
	// Adds a new pending request
	$Name = $_POST['Name'];
	$GradYear = $_POST['GradYear'];
	$Location = getLocationId($_POST['City'], $_POST['State']);
	$Education = $_POST['Education'];
	$Job = $_POST['Job'];
	$Salary = $_POST['Salary'];
	
	$query = $Database->query("INSERT INTO `UpdatedAlumni`(`Name`, `GradYear`, `Location`, `Education`, `Job`, `Salary`, `Verified`) VALUES('{$Name}', '{$GradYear}', '{$Location}', '{$Education}', '{$Job}', '{$Salary}', '0')");
	$ID = $Database->query("SELECT LAST_INSERT_ID()")->fetch_array()[0];
	$subject = "New alumni verification";
	$message = "A new user has been requested in the database.\n\nUse the following link to confirm or deny this addition: http://".($_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']))."/confirmation.php?a=Verify&ID={$ID}";
	mail($SMTP_OVERRIDE_EMAIL, $subject, $message);
	responseHandler($message);
		
		
		
		
} else if($a == 'Update') {
	// Updates an existing record
	$Name = $_POST['Name'];
	$GradYear = $_POST['GradYear'];
	$Location = $_POST['Location'];
	$Education = $_POST['Education'];
	$Job = $_POST['Job'];
	$Salary = $_POST['Salary'];
	$Verified = 0;
	$query = $Database->query("INSERT INTO `UpdatedAlumni`(`Name`, `GradYear`, `Location`, `Education`, `Job`, `Salary`, `Verified`) VALUES('{$Name}', '{$GradYear}', '{$Location}', '{$Education}', '{$Job}', '{$Salary}', '{$Verified}')");
	$ID = $Database->query("SELECT ID FROM UpdatedAlumni WHERE Name ='{$Name}' AND GradYear='{$GradYear}' AND Location='{$Location}'")->fetch_array()[0];
	$subject = "Alumni update verification";
	$message = "A user has requested update in the database. Use the link below to confirm    http://coltonh.smtchs.org/alumni/confirmation.php?a=Update&Confirm=true&ID=".$ID."    or use the following link to decline     http://coltonh.smtchs.org/alumni/confirmation.php?a=Update&Confirm=false&ID=".$ID;
	mail($SMTP_OVERRIDE_EMAIL, $subject, $message);
	responseHandler($message);
	
	
	
	
} else if($a == "VerifyRequest" && isset($_POST['id'])) {
	// Verifies a pending request and makes it into an Alumni
	$ID = $_POST['id'];
	$existingAlumni = $Database->query("SELECT * FROM `UpdatedAlumni` WHERE ID = '".$ID."'")->fetch_array()[0];
	if ($existingAlumni->num_rows == 0 )
		return responseHandler("No pending request with the ID '{$ID}' found");
		
	$city = explode(', ', $address)[0];
	$state = explode(', ', $address)[1];
	$locationId = getLocationId($city, $state);

	$Database->query("DELETE FROM `UpdatedAlumni` WHERE ID='{$ID}'");
	$query = $Database->query("INSERT INTO `Alumni`(`Name`, `GradYear`, `Location`, `Education`, `Job`, `Salary`, `Verified`) VALUES('{$Name}', '{$GradYear}', '{$Location}', '{$Education}', '{$Job}', '{$Salary}', '{$Verified}')");
	$message = "Added user: ".$Name;
	responseHandler($message);
		
		
		
		
} else if($a == "DeleteRequest" && isset($_POST['id'])) {
	// Deletes a pending request
	$ID = $_POST['id'];
	$Name = $Database->query("SELECT Name FROM `UpdatedAlumni` WHERE ID = '".$ID."'")->fetch_array()[0];
	$query = $Database->query("DELETE FROM `UpdatedAlumni` WHERE ID='{$ID}'");
	$message = "Approval denied for user: ".$Name;
	responseHandler($message);
	
	
	
	
} else if($a == 'ApproveUpdateRequest' && isset($_POST['id'])) {
	// Approves a request to update an existing alumni
	$ID = $_POST['ID'];
	$Name = $Database->query("SELECT Name FROM `UpdatedAlumni` WHERE ID = '".$ID."'")->fetch_array()[0];
	$GradYear = $Database->query("SELECT GradYear FROM `UpdatedAlumni` WHERE ID = '".$ID."'")->fetch_array()[0];
	$address = $Database->query("SELECT Location FROM `UpdatedAlumni` WHERE ID = '".$ID."'")->fetch_array()[0];
	$city = explode(', ', $address)[0];
	$state = explode(', ', $address)[1];
			
	$location = getLocationId($city, $state);
			
	$Education = $Database->query("SELECT Education FROM `UpdatedAlumni` WHERE ID = '".$ID."'")->fetch_array()[0];
	$Job = $Database->query("SELECT Job FROM `UpdatedAlumni` WHERE ID = '".$ID."'")->fetch_array()[0];
	$Salary = $Database->query("SELECT Salary FROM `UpdatedAlumni` WHERE ID = '".$ID."'")->fetch_array()[0];
	$Verified = 1;
	$query = $Database->query("UPDATE `Alumni` SET `Name` = '{$Name}', `GradYear` = '{$GradYear}', `Location` = '{$location}', `Education` = '{$Education}', `Job` = '{$Job}', `Salary` = '{$Salary}', `Verified` = '{$Verified}' WHERE `Name` = '{$Name}'");
	$query = $Database->query("DELETE FROM `UpdatedAlumni` WHERE ID='{$ID}'");
	$message = "Updated user: ".$Name;
	responseHandler($message);
	
	
	
	
} else if($a == 'DeleteUpdateRequest') {
	// Deletes a request to update an existing alumni
	$Name = $Database->query("SELECT Name FROM `UpdatedAlumni` WHERE ID = '".$ID."'")->fetch_array()[0];
	$query = $Database->query("DELETE FROM `UpdatedAlumni` WHERE ID='{$ID}'");
	$message = "Update denied for user: ".$Name;
	responseHandler($message);
	
	
	
	
} else {
	// Unknown action??
	responseHandler("Unknown action: {$a}");
}


}catch(Exception $e){
	responseHandler("There was an error: {$e}");
}


function responseHandler($data){
	return print_r(json_encode($data));
}

function getLocationId($city, $state){
	global $Database;
	
	$loc = urlencode($city . ', ' . $state);
	$data = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address={$loc}"));
	if (count($data->results) == 0)
		return null;
	
	$lat = ($data->results[0]->geometry->location->lat);
	$lng = ($data->results[0]->geometry->location->lng);
	
	$existingQuery = $Database->query("SELECT ID FROM MapLocation WHERE Latitude='{$lat}' AND Longitude='{$lng}'");
	if (!$existingQuery || $existingQuery->num_rows == 0){
		$Database->query("INSERT INTO `MapLocation`(`Latitude`, `Longitude`, `City`, `State`) VALUES('{$lat}', '{$lng}', '{$city}', '{$state}')");
		$existingQuery = $Database->query("SELECT ID from `MapLocation` WHERE Latitude = '{$lat}' AND Longitude = '{$lng}'");
	}
	
	if(is_null($existingQuery) || $existingQuery->num_rows == 0)
		return null;
	
	$loc = $existingQuery->fetch_array()[0];
	return $loc;
}