<?php 


class MapLocation {
	
	public $city, $state, $longitude, $latitude;
	
	public function __construct ($city, $state, $longitude, $latitude){
		$this->city = $city;
		$this->state = $state;
		$this->longitude = $longitude;
		$this->latitude = $latitude;
	}
	
}
 