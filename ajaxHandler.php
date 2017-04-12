<?php 

header('Access-Control-Allow-Origin: *');

$useGetOverride = false;

if ( $useGetOverride)
	$_POST = $_GET;

if(!ISSET($_POST['a'])){
	echo "'a' not set";
	//return;
}

$a = $_POST['a'];

require "class/Alumni.php";
require "class/MapLocation.php";
require "class/Database.php";


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
} elseif ( $a == "JobsAndSalary"){
	$jobs = array();
	$query = $Database->query("SELECT Job, AVG(Salary) AS Salary FROM Alumni WHERE Salary IS NOT NULL AND Salary <> 0 GROUP BY Job");
	while ( $row = $query->fetch_array())
		$jobs[$row['Job']] = $row['Salary'];
	
	
	responseHandler($jobs);
	
} elseif($a == "StudentFromId" && isset($_POST['Id']) ) {
	
	$query = $Database->query("	SELECT  a.ID		ID, 
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
	
} else {
	echo "Unknown";
}


function responseHandler($data){
	return print_r(json_encode($data));
}