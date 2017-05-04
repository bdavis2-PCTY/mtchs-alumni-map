<?php
	
	// Verification page 
	// Admins can approve or deny new alumni requests with this page
	
	// Validate the user has logged in as an admin 
	require "requireLogin.php";
	checkLogin();

	// Required classes
    require "../class/Alumni.php";
    require "../class/Database.php";
    
	// Check if the user is trying to pull someone up
	if(isset($_GET['ID'])){
		if(!$Database->query("SELECT `Name` FROM UpdatedAlumni WHERE ID={$_GET['ID']}")->fetch_array()[0]) {
		  return print_r("This page has been accessed in error");
		}
	}
?>

<!DOCTYPE html>
<html>
    <head>
        <script src="https://code.jquery.com/jquery-3.1.1.min.js" type="text/javascript"></script>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <title>Confirmation</title>
    </head>
    <body>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <h3 class="text-center"><?php
					// Decide what action to take for the user 
                    $a = $_GET['a'];
                    if($a == 'Verify') {
						// Verify the user 
						echo("Verification for new user: ".$Database->query("SELECT `Name` FROM UpdatedAlumni WHERE ID={$_GET['ID']}")->fetch_array()[0]);
                    } else if($a == 'Update') {
						// Update the user 
						echo("Update for user: ".$Database->query("SELECT `Name` FROM UpdatedAlumni WHERE ID={$_GET['ID']}")->fetch_array()[0]);
                    }
                    ?></h3>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">User Information</h3>
                    </div>
                    <div class="panel-body">
                        <?php
                            if($a == 'Verify') {
                            // Display information for verifying them 
                              $query = $Database->query("SELECT * FROM UpdatedAlumni WHERE ID={$_GET['ID']}")->fetch_array();
                              $location = $Database->query("SELECT CONCAT(City, ', ', State) FROM MapLocation WHERE ID=\"".$query["Location"]."\"")->fetch_array()[0];
                            
                            print_r("<strong>Name: </strong>".$query["Name"]);
                              print_r("<br><strong>Graduation Year: </strong>".$query["GradYear"]);
                              print_r("<br><strong>Location: </strong> {$location} (<a href='https://www.google.com/maps/place/{$location}' target=_blank>View on Google Maps</a>)");
                              print_r("<br><strong>Education: </strong>".$query["Education"]);
                              print_r("<br><strong>Job: </strong>".$query["Job"]);
                              print_r("<br><strong>Salary: </strong>".$query["Salary"]."<br>");
                              print_r('<div class="row"><button type="button" class="col-md-offset-3 col-md-2 btn btn-danger" onclick="deny()">Deny</button><button type="button" class="col-md-2 col-md-offset-2 btn btn-success" onclick="approve()">Approve</button></div>');
                            }
                            ?>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <div id="resultBox" class="text-center"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script>
		/* AJAX function for editing the user */
        function deny() {
          <?php if($a == 'Verify') echo('
            $.ajax({
            type: "GET",
            url: "http://coltonh.smtchs.org/alumni/ajaxHandler.php",
            data: {
              a: "Verify",
              Update: "false",
              ID: '.$_GET["ID"].'
            },
            success: function(data) {
              $("#resultBox").text(JSON.parse(data));
            },
            error: function(data) {
              $("#resultBox").text("There was an error with denying this user");
            }
            });
            }'); if($a == 'Update') echo('
            $.ajax({
            type: "GET",
            url: "http://coltonh.smtchs.org/alumni/ajaxHandler.php",
            data: {
            a: "Update",
            Confirm: "false",
            ID: '.$_GET["ID"].'
            },
            success: function(data) {
            $("#resultBox").text(JSON.parse(data));
            },
            error: function(data) {
            $("#resultBox").text("There was an error with denying this user");
            }
            });
            }');?>
        function approve() {
          <?php if($a == 'Verify') echo('
            $.ajax({
            type: "GET",
            url: "http://coltonh.smtchs.org/alumni/ajaxHandler.php",
            data: {
              a: "Verify",
              Update: "true",
              ID: '.$_GET["ID"].'
            },
            success: function(data) {
              $("#resultBox").text(JSON.parse(data));
            },
            error: function(data) {
              $("#resultBox").text("There was an error with denying this user");
            }
            });
            }'); if($a == 'Update') echo('
            $.ajax({
            type: "GET",
            url: "http://coltonh.smtchs.org/alumni/ajaxHandler.php",
            data: {
            a: "Update",
            Confirm: "true",
            ID: '.$_GET["ID"].'
            },
            success: function(data) {
            $("#resultBox").text(JSON.parse(data));
            },
            error: function(data) {
            $("#resultBox").text("There was an error with denying this user");
            }
            });');?>
    </script>
</html>