<?php 


class Alumni {
	
	public $id, $name, $gradYear, $location, $highestEducation, $job, $salary;
	
	public function __construct ($id, $name, $gradYear, $location, $highestEducation, $job=null, $salary=null){
		$this->id = $id;
		$this->name = $name;
		$this->gradYear = $gradYear;
		$this->location = $location;
		$this->highestEducation = $highestEducation;
		$this->job = $job;
		$this->salary = $salary;
	}
	
}


function ConvertDbQueryToAlumni($query){
	return new Alumni($query['ID'], $query['Name'], $query['GradYear'], $query['Location'], $query['Education'], $query['Job'], $query['Salary']);
}