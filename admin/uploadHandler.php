<?php

header('Access-Control-Allow-Origin: *');

require "../class/Alumni.php";
require "../class/Database.php";
require "../class/MapLocation.php";
class Object {}
$insertNum = 0;
$totalRows = 0;
$target_dir = "../uploads/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if($_SERVER['REQUEST_METHOD'] == "POST") {
    if($_POST['finalUpload'] == 'true') {
        $errored = [];
        $resultObj = new Object();
        $master = [];
         $string = file_get_contents($target_file);
				$string = explode("\n", $string);
				foreach($string as $line) {
				    $data = [];
          $line = preg_split('/,\s*(?=([^"]*"[^"]*")*[^"]*$)/', $line);
          if(count($line) <= 1) continue;
					foreach($line as $value) {
            $value = trim($value);
            if(substr($value, 0, 1) != "\"" && substr($value, strlen($value) - 1, 1) != "\"") {
              $value = substr_replace($value, "\"".$value."\"", 0);
            }
						$value = rtrim(ltrim($value, "\""),"\"");
						$value = str_replace("'", "''",$value);
						array_push($data, $value);
					}
			$city = explode(", ",$data[2])[0];
			$state = explode(", ",$data[2])[1];
			$address = urlencode($data[2]);
			$string = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address={$address}");
			$obj = json_decode($string);
			$lat = ($obj->results[0]->geometry->location->lat);
			$lng = ($obj->results[0]->geometry->location->lng);
			$Location = $Database->query("SELECT ID FROM `MapLocation` WHERE Latitude = '".$lat."' AND Longitude = '".$lng."'")->fetch_array[0];
			if(is_null($Location)) {
				$query = $Database->query("INSERT INTO `MapLocation`(`Latitude`, `Longitude`, `City`, `State`) VALUES('{$lat}', '{$lng}', '{$city}', '{$state}')");
				$Location = $Database->query("SELECT ID from `MapLocation` WHERE Latitude = '{$lat}' AND Longitude = '{$lng}'")->fetch_array()[0];
			}

					if($Database->query("INSERT INTO `UpdatedAlumni`(`Name`, `GradYear`, `Location`, `Education`, `Job`, `Salary`, `Verified`) VALUES('{$data[0]}', '{$data[1]}', '{$Location}', '{$data[3]}', '{$data[4]}', '{$data[5]}', '{$data[6]}')\n"))
					$insertNum++;
					else
					array_push($errored, $totalNum);
					$totalNum++;
					array_push($master, $data);
				}
				
				$resultObj->result = ($insertNum." rows inserted of ".$totalNum." entries.");
				$resultObj->errored = $errored;
				echo json_encode($resultObj);
				 unlink($target_file);
    } else {
if(isset($_POST["file"])) {
	if($imageFileType != "csv" && $imageFileType != "txt") {
	    echo "Sorry, only CSV and TXT files are allowed.";
	    $uploadOk = 0;
	} else {
		echo "File is valid - ".$imageFileType;
		$uploadOk = 1;
	}
}
if(isset($_POST["upload"])) {
  echo "Users have been uploaded";
}
// Check if file already exists
// Check file size
if ($_FILES["file"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        $string = file_get_contents($target_file);
				$string = explode("\n", $string);
				echo '<table id="grid-basic" class="table table-condensed table-hover table-striped">';
				echo "<thead><tr><th data-column-id='Name'>Name</th><th data-column-id='Gradyear' data-type='numeric'>Grad year</th><th data-column-id='Location'>Location</th><th data-column-id='Education'>Education</th><th data-column-id='Job'>Job</th><th data-column-id='Salary' data-type='numeric'>Salary</th><th data-column-id='Verified' data-type='numeric'>Verified</th></tr></thead><tbody>";
				foreach($string as $line) {
          $line = preg_split('/,\s*(?=([^"]*"[^"]*")*[^"]*$)/', $line);
          if(count($line) <= 1) continue;
					echo "<tr>";
					foreach($line as $value) {
            $value = trim($value);
            if(substr($value, 0, 1) == "\"" && substr($value, strlen($value) - 1, 1) == "\"") {
              $value = substr_replace($value, rtrim(ltrim($value, "\""), "\""), 0);
            }
						echo "<td>".$value."</td>";
					}
					echo "</tr>";
				}
				echo "</tbody></table><button type=\"button\" onclick=\"uploadUsers()\" class=\"btn btn-success\">Import</button><div class='row' id='rows'></div><script>$('#grid-basic').bootgrid();</script>";
    } else {
        echo "Sorry, there was an error uploading your file.";
        echo($_FILES["file"]["name"]);
    }
}
}
}
?>