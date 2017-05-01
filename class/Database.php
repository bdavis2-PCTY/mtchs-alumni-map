<?php

	// Database class
	class Database {
		// Database connection info
		private $host, $user, $pass, $db;

		// Is the database connected?
		private $connected = false;

		// The database connection
		public $connection;

		// Database constructor
		public function __construct ( $host, $user, $pass, $db ) {
			// Set class connection info members
			$this->host = $host;
			$this->user = $user;
			$this->pass = $pass;
			$this->db = $db;

			// Try to connect with the given information
			$this->connection = @new mysqli ( $host, $user, $pass, $db );


			// Check if the connection was a success
			if ( $this->connection && !$this->connection->errno )
				// Connection successful
				$this->connected = true;
			else {
				// Connection errored - notify admins
				mail("braydon.davis@mtchs.org","Alumni Database Connection Error", "Database error: " . mysql_error() ."\n\nFix as soon as possible!");
				die ( "<h1>ERROR ESTABLISHING DATABASE CONNECTION</h1><br/>Please try again later, a developer has been notified!" );
			}

			// Return the connection
			return $this->connection;
		}

		// Execute a database query
		public function query ( $str ) {
			if ( !$this->connected )
				return false;

			return $this->connection->query ( $str );
		}

		// Escape a string for save querying
		public function escape ( $str ) {
			return $this->connection->real_escape_string  ( $str );
		}
	}

	// connect to the database
	$Database = new Database ( "clone.smtchs.org", "clonesmt_map", "spruceS0ruce", "clonesmt_alumnimap" );
	
	//  Ensure the "Alumni" table exists
	$Database->query("CREATE TABLE IF NOT EXISTS `Alumni` (
						  `ID` int(11) NOT NULL AUTO_INCREMENT,
						  `Name` varchar(150) NOT NULL,
						  `GradYear` int(4) NOT NULL,
						  `Location` varchar(50) NOT NULL,
						  `Education` varchar(50) NOT NULL,
						  `Job` varchar(150) DEFAULT NULL,
						  `Salary` int(11) DEFAULT NULL,
						  PRIMARY KEY (`ID`)
					)");
	
	// Development print db data
	/*$data = $Database->query("SELECT * FROM Alumni");
	
	while ( $r = $data->fetch_array()){
		print_r($r);
	}*/
	