<?php 

	require "requireLogin.php";
	checkLogin();
	
	require "../settings.php";

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
	   .row {
	   margin:0px;
	   }
	</style>
</head>
<body>
	<div class="row">
		<div class="col-md-8 col-md-offset-1">
			<h3>To Use:</h3>Upload a CSV or TXT (still comma delimitted) file with columsn of Name, Grad year, Location (currently the number), Education, Job, Salary, and Verified state in that order. Do not include column headers. Upload the file and when ready, click import. Any rows that did not insert will be highlighted <span class="text-danger">Red</span>.
		</div>
	</div><br>
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<form enctype="multipart/form-data" id="form" name="form">
				<label for="fileToUpload">Select file to upload:</label> <input id="fileToUpload" name="fileToUpload" style="display:inline" type="file"> <button class="btn btn-primary" id="uploadButton" name="submit" type="submit">Upload</button>
			</form>
			<div id="result"></div>
		</div>
	</div>
	<script>
	var errored = [];
	function updateTablePlain() {
	           $("tr td:nth-child(6)").each(function() {
	                  $(this).text(numberWithCommas($(this).text()));
	              });
	}
	function updateTableImported() {
	    for(var i=0;i<errored.length; i++) {
	              var id = "tr[data-row-id="+errored[i]+"]";
	              $(id).css("background-color", "#f2dede");
	          }
	          $("tbody tr").each(function() {
	              if(errored.indexOf($(this).attr("data-row-id")) == -1) {
	                  $(this).css("background-color", "#dff0d8");
	              }
	          });
	           $("tr td:nth-child(6)").each(function() {
	                  $(this).text(numberWithCommas($(this).text()));
	              });
	}
	function numberWithCommas(x) {
	   if(x.indexOf("$") > -1)
	   return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	   else
	   return "$" + x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}
	$("#form").submit(function(e) {
	   e.preventDefault();
	   var formData = new FormData();
	formData.append('file', $('#fileToUpload')[0].files[0]);

	$.ajax({
	      url : '<?php echo $APP_PATH; ?>/admin/uploadHandler.php',
	      type : 'POST',
	      data : formData,
	      processData: false,  // tell jQuery not to process the data
	      contentType: false,  // tell jQuery not to set contentType
	      success : function(data) {
	          $("#result").html(data);
	          setTimeout(function() {
	              updateTablePlain();
	              $("ul[class=pagination] li").each(function() {
	                  $(this).attr("onclick", "setTimeout(updateTablePlain, 100)");
	              });
	              $("tr th a").each(function() {
	                  $(this).attr("onclick", "setTimeout(updateTablePlain, 100)");
	              });
	          }, 200);
	              
	      }
	});
	});
	   function uploadUsers() {
	        var formData = new FormData();
	formData.append('file', $('#fileToUpload')[0].files[0]);
	formData.append('finalUpload', 'true');

	$.ajax({
	      url : '<?php echo $APP_PATH; ?>/admin/uploadHandler.php',
	      type : 'POST',
	      data : formData,
	      dataType: 'JSON',
	      processData: false,  // tell jQuery not to process the data
	      contentType: false,  // tell jQuery not to set contentType
	      success : function(data) {
	          errored = data.errored;
	          $("#rows").text(data.result);
	          setTimeout(function() {
	              updateTableImported();
	              $("ul[class=pagination] li").each(function() {
	                  $(this).attr("onclick", "setTimeout(updateTableImported, 100)");
	              });
	              $("tr th").each(function() {
	                  $(this).attr("onclick", "setTimeout(updateTableImported, 100)");
	              });
	          }, 200);
	      }
	});
	       
	   }
	   $("#uploadButton").click(function() {
	       
	   });
	   
	</script> 
</body>
</html>