<?php 
	
	// Admin landing page
	// Where admin selects what action to take (view, verify, import)
	
	// Make sure they're logged in
    require "requireLogin.php";
    checkLogin();
   
?>

<!DOCTYPE html>
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
            .panel {
				height:100%;
            }
        </style>
    </head>
    <body>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2 text-center">
                        <div class="page-header">
                            <h1>MTCHS Alumni Map<br>
                                <small>Admin panel for controlling the map</small>
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
				<div class="row">
						<div class="col-md-8 col-md-offset-2">
							<div class="panel panel-default">
								<div class="panel-body">
									<h1>View all alumni</h1>
									<p>View and change all existing alumni.</p>
									<a href='viewAll.php'><button type="button" class="btn btn-primary">View</button></a>
								</div>
							</div>
						</div>
						<!--<div class="col-md-4">
							<div class="panel panel-default">
							  <div class="panel-body">
								<h1>Other category</h1>
								<p>I knew what this was for but I forgot</p>
								<button type="button" class="btn btn-info">Remember</button>
							  </div>
							</div>
							</div>-->
					</div>
			
                <div class="row">
                    <div class="col-md-4 col-md-offset-2">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <h1>Upload users</h1>
                                <p>Upload a CSV or TXT file of alumni to be added to the map.</p>
                                <a href="uploader.php"><button type="button" class="btn btn-primary">Upload</button></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <h1>Verify alumni</h1>
                                <p>Verify or deny new alumni or alumni changes.</p>
                                <a href='verify.php'><button type="button" class="btn btn-primary">Verify</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>