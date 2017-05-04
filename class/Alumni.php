<?php 

// Alumni class 
// Used to store selected alumni from the database into a php object
// This is a simple DTO (Database-Transfer-Object)

class Alumni {
	
	// Attributes of alumni
	public $id;
	public $name;
	public $gradYear;
	public $location;
	public $highestEducation;
	public $job;
	public $salary;
	
	public function __construct ($id, $name, $gradYear, $location, $highestEducation, $job=null, $salary=null){
		// Set the alumni attribtes
		$this->id = $id;
		$this->name = $name;
		$this->gradYear = $gradYear;
		$this->location = $location;
		$this->highestEducation = $highestEducation;
		$this->job = $job;
		$this->salary = $salary;
	}
	
}

// Converts a query result from the database into the Alunmi object
function ConvertDbQueryToAlumni($query){
	return new Alumni($query['ID'], $query['Name'], $query['GradYear'], $query['Location'], $query['Education'], $query['Job'], $query['Salary']);
}