<?php 

require "requireLogin.php";
checkLogin();

?>
<!DOCTYPE html>
<html>
<head>
	<!-- jQuery -->

	<script src="../asset/jquery-3.2.0.js" type="text/javascript">
	</script>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js">
	</script><!-- Bootstrap -->
	<!-- Latest compiled and minified CSS -->
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"><!-- Latest compiled and minified JavaScript -->

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js">
	</script><!-- Materialize -->
	<!--<script src="../asset/materialize/materialize.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="../asset/materialize/materialize.min.css" type="text/css" />-->

	<script src="../asset/bootgrid/jquery.bootgrid.min.js">
	</script>
	<link href="../asset/bootgrid/jquery.bootgrid.min.css" rel="stylesheet">
	<title>MTCHS Graduate Map | Admin</title>
	<style>
	   .bootgrid-table td {
	   overflow: visible;
	   white-space:normal;
	   }
	   body {
	       overflow-x: hidden;
	   }
	   .edit-link:hover {
	       color:black;
	       text-decoration:none;
	       cursor: pointer;
	   }
	</style>
</head>
<body>
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div id="result"></div>
		</div>
	</div>
	<script>
	var errored = [];
	function edit(id) {
	   
	}
	function numberWithCommas(x) {
	   if(x.indexOf("$") > -1)
	   return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	   else
	   return "$" + x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}
	$(function() {
	 $.ajax({
	    method: 'GET',
	    url: "viewAllHandler.php",
	    success: function(data) {
	        $("#result").html(data);
	        $("#grid-basic").bootgrid({
	            caseSensitive: false,
	            formatters: {
	                "name": function(column, row) {
	                   return '<span class="edit-link" onclick="edit('+row.ID+')">'+row.Name+'<\/span>';  
	                },
	                "Salary": function(column, row) {
	                    var string = row.Salary.toString();
	                    return numberWithCommas(string);
	                },
	                "actions": function(column, row) {
	                   return '<button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-pencil"><\/span><\/button>';
	                }
	            }
	        });
	    }
	     
	 });
	   
	});
	   $(".edit-link").hover(function() {
	   $(this).prepend('<span class="glyphicon glyphicon-pencil"><\/span>');
	});
	</script> 
</body>
</html>