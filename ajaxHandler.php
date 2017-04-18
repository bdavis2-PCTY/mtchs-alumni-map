<?php
header('Access-Control-Allow-Origin: *');

if(!ISSET($_POST['a']) && !ISSET($_GET['a'])){
	echo "'a' not set";
	return;
}

$a = $_POST['a'];

require "class/Alumni.php";
require "class/Database.php";
require "class/MapLocation.php";

if ($a == "CityLocations"){
	// For loading locations on the map
	$locations = array();
	$req = $Database->query("SELECT * FROM MapLocation");
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
		$students[] = new Alumni($alumni['ID'], $alumni['Name'], $alumni['GradYear'], $alumni['Location'], $alumni['Education'], $alumni['Job'], $alumni['Salary']);
	}
	responseHandler($students);
} else if ( $a == "JobsAndSalary"){
	$jobs = array();
	$query = $Database->query("SELECT Job, AVG(Salary) AS Salary FROM Alumni WHERE Salary IS NOT NULL AND Salary <> 0 GROUP BY Job");
	while ( $row = $query->fetch_array())
		$jobs[$row['Job']] = $row['Salary'];
	responseHandler($jobs);
} else if($a == "StudentFromId" && isset($_POST['Id']) ) {
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
	$alumni = new Alumni($query['ID'], $query['Name'], $query['GradYear'], $query['Location'], $query['Education'], $query['Job'], $query['Salary']);
	responseHandler($alumni);
	
} else if($_POST['a'] == 'New') {
	$Name = $_POST['Name'];
	$GradYear = $_POST['GradYear'];
	$Location = $_POST['Location'];
	$Education = $_POST['Education'];
	$Job = $_POST['Job'];
	$Salary = $_POST['Salary'];
	$Verified = 0;
	$query = $Database->query("INSERT INTO `UpdatedAlumni`(`Name`, `GradYear`, `Location`, `Education`, `Job`, `Salary`, `Verified`) VALUES('{$Name}', '{$GradYear}', '{$Location}', '{$Education}', '{$Job}', '{$Salary}', '{$Verified}')");
	$ID = $Database->query("SELECT ID FROM UpdatedAlumni WHERE Name ='{$Name}'")->fetch_array()[0];
	$to = "colton.hix@mtchs.org";
	$subject = "New alumni verification";
	$message = "A new user has been requested in the database. Use the link below to confirm    http://coltonh.smtchs.org/alumni/confirmation.php?a=Verify&Update=true&ID=".$ID."    or use the following link to decline     http://coltonh.smtchs.org/alumni/confirmation.php?a=Verify&Update=false&ID=".$ID;
		mail($to, $subject, $message);
		responseHandler($message);
	} else if($_POST['a'] == 'Update') {
		$Name = $_POST['Name'];
		$GradYear = $_POST['GradYear'];
		$Location = $_POST['Location'];
		$Education = $_POST['Education'];
		$Job = $_POST['Job'];
		$Salary = $_POST['Salary'];
		$Verified = 0;
		$query = $Database->query("INSERT INTO `UpdatedAlumni`(`Name`, `GradYear`, `Location`, `Education`, `Job`, `Salary`, `Verified`) VALUES('{$Name}', '{$GradYear}', '{$Location}', '{$Education}', '{$Job}', '{$Salary}', '{$Verified}')");
		$ID = $Database->query("SELECT ID FROM UpdatedAlumni WHERE Name ='{$Name}'")->fetch_array()[0];
		$to = "colton.hix@mtchs.org";
		$subject = "Alumni update verification";
		$message = "A user has requested update in the database. Use the link below to confirm    http://coltonh.smtchs.org/alumni/confirmation.php?a=Update&Confirm=true&ID=".$ID."    or use the following link to decline     http://coltonh.smtchs.org/alumni/confirmation.php?a=Update&Confirm=false&ID=".$ID;
		mail($to, $subject, $message);
		responseHandler($message);
	} else if(ISSET($_GET['a'])) {
	if($_GET['a'] == 'Verify') {
		$verify = $_GET['Update'];
		$ID = $_GET['ID'];
		if($verify == 'true') {
			$Name = $Database->query("SELECT Name FROM `UpdatedAlumni` WHERE ID = '".$ID."'")->fetch_array()[0];
			$GradYear = $Database->query("SELECT GradYear FROM `UpdatedAlumni` WHERE ID = '".$ID."'")->fetch_array()[0];
			$address = $Database->query("SELECT Location FROM `UpdatedAlumni` WHERE ID = '".$ID."'")->fetch_array()[0];
			$city = explode(', ', $address)[0];
			$state = explode(', ', $address)[1];
			$string = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address={$address}");
			$obj = json_decode($string);
			$lat = ($obj->results[0]->geometry->location->lat);
			$lng = ($obj->results[0]->geometry->location->lng);
			$Location = $Database->query("SELECT ID FROM `MapLocation` WHERE Latitude = '".$lat."' AND Longitude = '".$lng."'")->fetch_array[0];
			if(is_null($Location)) {
				$query = $Database->query("INSERT INTO `MapLocation`(`Latitude`, `Longitude`, `City`, `State`) VALUES('{$lat}', '{$lng}', '{$city}', '{$state}')");
				$Location = $Database->query("SELECT ID from `MapLocation` WHERE Latitude = '{$lat}' AND Longitude = '{$lng}'");
			}
			// $Location = $Database->query("SELECT Location FROM `UpdatedAlumni` WHERE ID = '".$ID."'")->fetch_array()[0];
			$Education = $Database->query("SELECT Education FROM `UpdatedAlumni` WHERE ID = '".$ID."'")->fetch_array()[0];
			$Job = $Database->query("SELECT Job FROM `UpdatedAlumni` WHERE ID = '".$ID."'")->fetch_array()[0];
			$Salary = $Database->query("SELECT Salary FROM `UpdatedAlumni` WHERE ID = '".$ID."'")->fetch_array()[0];
			$Verified = 1;
			$query = $Database->query("DELETE FROM `UpdatedAlumni` WHERE ID='{$ID}'");
			$query = $Database->query("INSERT INTO `Alumni`(`Name`, `GradYear`, `Location`, `Education`, `Job`, `Salary`, `Verified`) VALUES('{$Name}', '{$GradYear}', '{$Location}', '{$Education}', '{$Job}', '{$Salary}', '{$Verified}')");
			$message = "Added user: ".$Name;
			responseHandler($message);
		} else if($verify == 'false') {
			$Name = $Database->query("SELECT Name FROM `UpdatedAlumni` WHERE ID = '".$ID."'")->fetch_array()[0];
			$query = $Database->query("DELETE FROM `UpdatedAlumni` WHERE ID='{$ID}'");
			$message = "Approval denied for user: ".$Name;
			responseHandler($message);
		}
	} 
	if($_GET['a'] == 'Update') {
		$confirm = $_GET['Confirm'];
		$ID = $_GET['ID'];
		if($confirm == 'true') {
			$Name = $Database->query("SELECT Name FROM `UpdatedAlumni` WHERE ID = '".$ID."'")->fetch_array()[0];
			$GradYear = $Database->query("SELECT GradYear FROM `UpdatedAlumni` WHERE ID = '".$ID."'")->fetch_array()[0];
			$address = $Database->query("SELECT Location FROM `UpdatedAlumni` WHERE ID = '".$ID."'")->fetch_array()[0];
			$city = explode(', ', $address)[0];
			$state = explode(', ', $address)[1];
			$string = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address={$address}");
			$obj = json_decode($string);
			$lat = ($obj->results[0]->geometry->location->lat);
			$lng = ($obj->results[0]->geometry->location->lng);
			$Location = $Database->query("SELECT ID FROM `MapLocation` WHERE Latitude = '".$lat."' AND Longitude = '".$lng."'")->fetch_array[0];
			if(is_null($Location)) {
				$query = $Database->query("INSERT INTO `MapLocation`(`Latitude`, `Longitude`, `City`, `State`) VALUES('{$lat}', '{$lng}', '{$city}', '{$state}')");
				$Location = $Database->query("SELECT ID from `MapLocation` WHERE Latitude = '{$lat}' AND Longitude = '{$lng}'");
			}
			$Education = $Database->query("SELECT Education FROM `UpdatedAlumni` WHERE ID = '".$ID."'")->fetch_array()[0];
			$Job = $Database->query("SELECT Job FROM `UpdatedAlumni` WHERE ID = '".$ID."'")->fetch_array()[0];
			$Salary = $Database->query("SELECT Salary FROM `UpdatedAlumni` WHERE ID = '".$ID."'")->fetch_array()[0];
			$Verified = 1;
			$query = $Database->query("UPDATE `Alumni` SET `Name` = '{$Name}', `GradYear` = '{$GradYear}', `Location` = '{$Location}', `Education` = '{$Education}', `Job` = '{$Job}', `Salary` = '{$Salary}', `Verified` = '{$Verified}' WHERE `Name` = '{$Name}'");
			$query = $Database->query("DELETE FROM `UpdatedAlumni` WHERE ID='{$ID}'");
			$message = "Updated user: ".$Name;
			responseHandler($message);
		} else if($confirm == 'false') {
			$Name = $Database->query("SELECT Name FROM `UpdatedAlumni` WHERE ID = '".$ID."'")->fetch_array()[0];
			$query = $Database->query("DELETE FROM `UpdatedAlumni` WHERE ID='{$ID}'");
			$message = "Update denied for user: ".$Name;
			responseHandler($message);
		}
	}
} else {
	echo "Unknown";
}
function responseHandler($data){
	return print_r(json_encode($data));
}