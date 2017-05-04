<?php

// Allows for AJAX to be called 
header('Access-Control-Allow-Origin: *');

// Validate that there is something to actually call 
if(!ISSET($_POST['a']) && !ISSET($_GET['a'])){
	echo "'a' not set";
	return;
}

// $a: The ajax function that we need to call 
// Eg. 'CityLocations', 'StudentsInCity', etc...
$a = $_POST['a'];

// All required files 
require "settings.php";
require "class/Alumni.php";
require "class/Database.php";
require "class/MapLocation.php";


try{
if ($a == "CityLocations"){
	// CityLocations: For loading locations on the map
	$locations = array();
	// query all locations from db
	// Note: the join enforces alumni actually belong to the location 
	
	$req = $Database->query("SELECT * FROM MapLocation m
							JOIN Alumni a ON m.ID = a.Location
							WHERE a.ID IS NOT NULL");
	
	// Convert all to DTO objects and send back 
	while ($a = $req->fetch_array())
		$locations[] = new MapLocation($a['City'], $a['State'], $a['Longitude'], $a['Latitude']);
	responseHandler($locations);





} elseif ( $a == "StudentsInCity" && isset($_POST["City"])){
	// StudentsInCity: For loading the students in a city
	$lowerCity = strtolower($_POST['City']);
	
	// Get all the students with their locations 
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

	// Convert all to DTO objects & send back
	$students = array();
	while ( $alumni = $studentQuery->fetch_array() )
		$students[] = ConvertDbQueryToAlumni($alumni);
	
	responseHandler($students);



} else if ( $a == "JobsAndSalary") {
	if(isset($_POST['sort'])) {
		$sort = $_POST['sort'];
		$cont = false;
		if($sort == "salaryDesc") {
			$jobs = array();
			$query = $Database->query("SELECT Job, AVG(Salary) AS Salary FROM Alumni WHERE Salary IS NOT NULL AND Salary <> 0 GROUP BY Job ORDER BY Salary DESC");
			while ( $row = $query->fetch_array())
				$jobs[$row['Job']] = $row['Salary'];
			responseHandler($jobs);
		} else if($sort == "salaryAsc") {
			$jobs = array();
			$query = $Database->query("SELECT Job, AVG(Salary) AS Salary FROM Alumni WHERE Salary IS NOT NULL AND Salary <> 0 GROUP BY Job ORDER BY Salary ASC");
			while ( $row = $query->fetch_array())
				$jobs[$row['Job']] = $row['Salary'];
			responseHandler($jobs);
		} else if($sort == "jobDesc") {
			$jobs = array();
			$query = $Database->query("SELECT Job, AVG(Salary) AS Salary FROM Alumni WHERE Salary IS NOT NULL AND Salary <> 0 GROUP BY Job ORDER BY Job DESC");
			while ( $row = $query->fetch_array())
				$jobs[$row['Job']] = $row['Salary'];
			responseHandler($jobs);
		} else if($sort == "jobAsc") {
			$jobs = array();
			$query = $Database->query("SELECT Job, AVG(Salary) AS Salary FROM Alumni WHERE Salary IS NOT NULL AND Salary <> 0 GROUP BY Job ORDER BY Job ASC");
			while ( $row = $query->fetch_array())
				$jobs[$row['Job']] = $row['Salary'];
			responseHandler($jobs);
		} else {
			$cont = true;
		}
		
		if(!$cont)
			return;
	}
	//To get the data for the jobs & salary page on the main MTCHS site
	$jobs = array();
	$query = $Database->query("SELECT Job, AVG(Salary) AS Salary FROM Alumni WHERE Salary IS NOT NULL AND Salary <> 0 GROUP BY Job");
	while ( $row = $query->fetch_array())
		$jobs[$row['Job']] = $row['Salary'];
	responseHandler($jobs);




} else if($a == "StudentFromId" && isset($_POST['Id']) ) {
	// StudentFromId: Gets a new alumni object from an existing ID
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
	// SendAdminLogin: Sends a login URL to the provided email, as long as its validated 
	// If not, simply returns false
	
	// Check if the exist
	$email = strtolower($_POST['email']);
	$q = $Database->query("SELECT 1 FROM VerifiedEmail WHERE Email='{$email}'");
	if ( $q->num_rows > 0 ){
		// Send them an email
		mail($email, "MTCHS Alumni Admin Login", "Click the following link to login to the MTCHS Alumni Administrator site:\n{$APP_PATH}/admin/AdminLogin.php?ref={$email} \n\nIf you did not request this login, just ignore this message.");

		responseHandler(true);
	}else
		responseHandler(false);



} else if ($a=="UnverifiedAlumni"){
	// UnverifiedAlumni: Gets a list of all unverified alumni
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


	
	
} else if($a == 'New' && isset($_POST['Name'],$_POST['GradYear'],$_POST['Education'],$_POST['Job'],$_POST['Salary'],$_POST['City'],$_POST['State'])) {
	// New: Adds an new alumni request (Still requires validation)

	$Name = $_POST['Name'];
	$GradYear = $_POST['GradYear'];
	$Education = $_POST['Education'];
	$Job = $_POST['Job'];
	$Salary = $_POST['Salary'];
	$Location = getLocationId($_POST['City'], $_POST['State']);
	
	// Inserts them into the unverified table 
	$query = $Database->query("INSERT INTO `UpdatedAlumni`(`Name`, `GradYear`, `Location`, `Education`, `Job`, `Salary`, `Verified`) VALUES('{$Name}', '{$GradYear}', '{$Location}', '{$Education}', '{$Job}', '{$Salary}', '0')");
	
	// Retrieve their ID and alert an admin of the new submittal
	$ID = $Database->query("SELECT LAST_INSERT_ID()")->fetch_array()[0];
	$subject = "New alumni verification";
	$message = "A new user has been requested in the database.\n\nUse the following link to confirm or deny this addition: {$APP_PATH}/admin/confirmation.php?a=Verify&ID={$ID}";
	mail($SMTP_OVERRIDE_EMAIL, $subject, $message);
	responseHandler($message);




} else if($a == 'Update') {
	// Update: Updates an existing alumni in the database 
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
	$message = "A user has requested update in the database. Use the link below to confirm    {$APP_PATH}/admin/confirmation.php?a=Update&Confirm=true&ID=".$ID."    or use the following link to decline     {$APP_PATH}/admin/confirmation.php?a=Update&Confirm=false&ID=".$ID;
	mail($SMTP_OVERRIDE_EMAIL, $subject, $message);
	responseHandler($message);




} else if($a == "VerifyRequest" && isset($_POST['id'])) {
	// Verifies a pending request and makes it into an Alumni
	$ID = @(int)$_POST['id'];

	$existingAlumni = $Database->query("SELECT * FROM UpdatedAlumni WHERE ID='{$ID}'");
	if ($existingAlumni->num_rows == 0 )
		return responseHandler("No pending request with the ID '{$ID}' found");

	$existingAlumni = ConvertDbQueryToAlumni($existingAlumni->fetch_array());

		
	$city = explode(', ', $address)[0];
	$state = explode(', ', $address)[1];
	$locationId = getLocationId($city, $state);

	$Database->query("DELETE FROM `UpdatedAlumni` WHERE ID='{$ID}'");
	$query = $Database->query("INSERT INTO `Alumni`(`Name`, `GradYear`, `Location`, `Education`, `Job`, `Salary`, `Verified`) VALUES('{$existingAlumni->name}', '{$existingAlumni->gradYear}', '{$existingAlumni->location}', '{$existingAlumni->highestEducation}', '{$existingAlumni->job}', '{$existingAlumni->salary}', '1')");
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


// Used to send a reply back to the client 
// Simply prints the variable as a json string 
// $data: any data type  - the message/object to send back to the client 
function responseHandler($data){
	return print_r(json_encode($data));
}

// getLocationId
// Checks if a location exists in the database 
// If it does, sends back its ID
// If not, then it creates it using google maps API and sends the ID of that 
// $city: the location city to check 
// $state: the location state to check 
function getLocationId($city, $state){
	// Get access to the DB
	global $Database;
	
	// Read googles API for location coordinates
	$loc = urlencode($city . ', ' . $state);
	$data = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address={$loc}"));
	if (count($data->results) == 0)
		return null;
	
	// Get actual coordinates of the reply 
	$lat = ($data->results[0]->geometry->location->lat);
	$lng = ($data->results[0]->geometry->location->lng);
	
	// Check if the coordinates are in the database
	$existingQuery = $Database->query("SELECT ID FROM MapLocation WHERE Latitude='{$lat}' AND Longitude='{$lng}'");
	if (!$existingQuery || $existingQuery->num_rows == 0){
		// They're not, we need to add and send back
		$Database->query("INSERT INTO `MapLocation`(`Latitude`, `Longitude`, `City`, `State`) VALUES('{$lat}', '{$lng}', '{$city}', '{$state}')");
		$existingQuery = $Database->query("SELECT ID from `MapLocation` WHERE Latitude = '{$lat}' AND Longitude = '{$lng}'");
	}
	
	// Makes sure there was an actual result
	if(is_null($existingQuery) || $existingQuery->num_rows == 0)
		return null;

	$loc = $existingQuery->fetch_array()[0];
	return $loc;
}
