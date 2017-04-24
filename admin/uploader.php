<html>
<head>
<!-- jQuery -->
<script src="../asset/jquery-3.2.0.js" type="text/javascript"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>

<!-- Bootstrap -->
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-	BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<!-- Materialize -->
<!--<script src="../asset/materialize/materialize.min.js" type="text/javascript"></script>
	<link rel="stylesheet" href="../asset/materialize/materialize.min.css" type="text/css" />-->

<title>MTCHS Graduate Map | Admin</title>
<style>
	.row {
	margin:0px;
	}
}
	</style>
</head>
<body>
<div class="row">
<div class="col-md-8 col-md-offset-2">
<form action="uploader.php" method="post" enctype="multipart/form-data">
    <span style="color:red">*</span>This will be split into an ajax call and php handler later<br><label for="fileToUpload">Select image to upload:</label>
    <input type="file" style="display:inline" name="fileToUpload" id="fileToUpload">
    <button type="submit" class="btn btn-primary" name="submit">Upload</button>
</form>
</div>
</div>

</body>
</html>
<?php

require "../class/Alumni.php";
require "../class/Database.php";
require "../class/MapLocation.php";

$target_dir = "../uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if($_SERVER['REQUEST_METHOD'] == "POST") {
if(isset($_POST["submit"])) {
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
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $string = file_get_contents($target_file);
				$string = explode("\n", $string);
				echo "<div class=\"row\"><div class=\"col-md-10 col-md-offset-1\"<table>";
				foreach($string as $line) {
          $line = preg_split('/,\s*(?=([^"]*"[^"]*")*[^"]*$)/', $line);
          if(count($line) <= 1) continue;
					echo "<tr>";
					foreach($line as $value) {
            $value = trim($value);
            if(substr($value, 0, 1) != "\"" && substr($value, strlen($value) - 1, 1) != "\"") {
              $value = substr_replace($value, "\"".$value."\"", 0);
            }
						echo "<td>".$value."</td>";
					}
					echo "</tr>";
				}
				echo "</table></div></div>";
				unlink($target_file);
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
}
?>
