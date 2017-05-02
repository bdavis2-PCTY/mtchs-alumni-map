<?php
require "../class/Alumni.php";
require "../class/Database.php";
require "../class/MapLocation.php";

$results = $Database->query('SELECT * FROM `Alumni`');
                
				echo '<table id="grid-basic" class="table table-condensed table-hover table-striped">';
				echo "<thead><tr><th data-column-id='ID' data-type='numeric'>ID</th><th data-column-id='Name' data-formatter='name'>Name</th><th data-column-id='Gradyear' data-type='numeric'>Grad year</th><th data-column-id='Location'>Location</th><th data-column-id='Education'>Education</th><th data-column-id='Job'>Job</th><th data-column-id='Salary' data-formatter='Salary' data-type='numeric'>Salary</th><th data-column-id='Verified' data-type='numeric'>Verified</th><th data-column-id='Status'>Status</th><th data-column-id='actions'  data-formatter='actions' data-sortable='false'></th></tr></thead><tbody>";
				while($result = $results->fetch_array()) {
				    $status = "";
				    if($result['Printed'] == 1) {
				        $status = "Printed";
				    } else if($result['Updated'] == 1) {
				        $status = "Updated";
				    } else if ($result['New'] == 1) {
				        $status = "New";
				    }
					echo "<tr>";
						echo ("<td>".$result['ID']."</td>"."<td>".$result['Name']."</td>"."<td>".$result['GradYear']."</td>"."<td>".$result['Location']."</td>"."<td>".$result['Education']."</td>"."<td>".$result['Job']."</td>"."<td>".$result['Salary']."</td>"."<td>".$result['Verified']."</td>"."<td>".$status."</td>");
					echo "</tr>";
				}
				echo "</tbody></table>";
    

?>