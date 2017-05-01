<?php 

require "requireLogin.php";
checkLogin();


include "../class/Database.php";
include "../class/Alumni.php";

$alumni = [];
$_alumni = $Database->query("SELECT * FROM Alumni ORDER BY Name");

while($r = $_alumni->fetch_array())
	$alumni[] = ConvertDbQueryToAlumni($r);

?>

<html>
	<head>
		<title>MTCHS Alumni | Admin Verification</title>
		
		 <!-- jQuery -->
		<script src="../asset/jquery-3.2.0.js" type="text/javascript"></script>

		<script src="../asset/bootgrid/bootstrap.min.js" type="text/javascript"></script>
		<script src="../asset/bootgrid/jquery.bootgrid.min.js" type="text/javascript"></script>
		<script src="../asset/bootbox.min.js" type="text/javascript"></script>
		<link rel="stylesheet" href="../asset/bootgrid/bootstrap.min.css" type="text/css" />
		<link rel="stylesheet" href="../asset/bootgrid/jquery.bootgrid.min.css" type="text/css" />
		
		<!-- Semantic -->
		<script src="../asset/semantic/semantic.js" type="text/javascript"></script>
		<link rel="stylesheet" href="../asset/semantic/semantic.css" type="text/css" />
		
		<!-- Bootstrap -->
		
		<!-- Others -->
		<script src="../asset/ajaxRequest.js" type="text/javascript"></script>
		
		<style type="text/css">
			body button {
				margin-right:10px;
			}
		
			body button span {
				padding-right:5px;
			}
			
			#alumni-grid thead tr th {
				text-align:center;
			}
		</style>
	</head>
	
	<body>
		<div id="tableWrapper">
			<table id="alumni-grid" class="ui selectable basic table">
				<thead>
					<tr>
						<th>ID</th>
						<th>Name</th>
						<th>Grad. Year</th>
						<th>Job Title</th>
						<th>Location</th>
						<th>Salary</th>
						<th>Action</th>
					</tr>
				</thead>
			<tbody>
			</tbody>
			</table> 
		</div>
		
		<br />
		<a href='./'><button class="ui blue button"><i class="undo icon"></i> Return</button></a>
	</body>
	<script type='text/javascript'>
	$(document).ready(function(){
		reloadAlumni();
		// Give bootgrid time to execute
		//setTimeout(reloadAlumni,  10);
	});
	
	function reloadAlumni ( ) {
		var alumni = JSON.parse(ajaxRequest("UnverifiedAlumni"));
			console.log(alumni);
			
			var s = "";
			for ( var i = 0; i < alumni.length; i++) {
				var a = alumni[i];
				var actButtons = "<button class='ui green button' onclick='approveRequest(\"" + a.id + "\")'><i class='checkmark icon'></i> Verify</button>" + 
				"<button class='ui red button' onclick='removeRequest(\"" + a.id + "\")'><i class='remove icon'></i> Delete</button>";
				
				s += "<tr>";
				s += "<td>" + a.id + "</td>";
				s += "<td>" + a.name + "</td>";
				s += "<td>" + a.gradYear + "</td>";
				s += "<td>" + (a.job == "" ? "Unemployed" : a.job) + "</td>";
				s += "<td><a href='https://www.google.com/maps/place/" + a.location + "' target=_blank>" + a.location + "</a></td>";
				s += "<td>" + formatMoney(a.salary) + "</td>";
				s += "<td>" + actButtons + "</td>";
				s += "</tr>";
			}
			
			$("#alumni-grid tbody").html(s);
	}
	
	var msg = "";
	function approveRequest(id){
		bootbox.confirm({
			message: "<span class='glyphicon glyphicon-ok text-success'></span> <strong>Are you sure you want to <span class='text-success'>APPROVE</span> this alumni request?</strong><br /><br />Once this request is verified, they will appear on the MTCHS Alumni Map and everyone will be able to see their provided information. If you don't want to approve this request, click the <strong>'No'</strong> button below then click the <strong>'Delete'</strong> button in the corresponding row of the request. If you do wish to verify this request, click on the <strong>'Yes'</strong> button below.",
			buttons: { 
				confirm:{
					label:"<span class='glyphicon glyphicon-ok'></span> Yes",
					className: "btn-success"
				},
				
				cancel:{
					label: "<span class='glyphicon glyphicon-remove'></span> No",
					className: "btn-danger"
				}
			},
			
			callback: function(r){
				ajaxRequest("VerifyRequest", {id: id});
				reloadAlumni();
			}
		});
	}
	
	function removeRequest(id){
		bootbox.confirm({
			message: "<span class='glyphicon glyphicon-remove text-danger'></span> <strong>Are you sure you want to <span class='text-danger'>DENY</span> this alumni request?</strong><br /><br />Once this request is deleted, it will be removed from our records permanently and require a new submission to be retrieved. If you would like to verify this request, click on the <strong>'No'</strong> button below then click the <strong>'Verify'</strong> button on the corresponding row.  If you do wish to deny this request, click on the <strong>'Yes'</strong> button below.",
			buttons: { 
				confirm:{
					label:"<span class='glyphicon glyphicon-ok'></span> Yes",
					className: "btn-success"
				},
				
				cancel:{
					label: "<span class='glyphicon glyphicon-remove'></span> No",
					className: "btn-danger"
				}
			},
			
			callback: function(r){
				ajaxRequest("DeleteRequest", {id: id});
				reloadAlumni();
			}
		});
	}
	
	
	function formatMoney(money){
		var n = parseInt(money);
		return "$" + n.toFixed(0).replace(/./g, function(c, i, a) {
			return i && c !== "." && ((a.length - i) % 3 === 0) ? ',' + c : c;
		});
	}
	</script>
</html>