<?php
require_once 'settings.php';

class MySQL {
	private $settings;
	
	public function MySQL() {
        $this->settings = new Settings();
    }
	
	/* Opens a connection, to given database if specified */
	public function open() {
		// Create connection
		$con = mysqli_connect($this->settings->host, $this->settings->username, $this->settings->password, 'ikt-utstyr');
		$con->set_charset("utf8");
		
		// Check connection
		if (mysqli_connect_errno($con)) {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		
		return $con;
	}
	
	/* Closes connection */
	public function close($con) {
		mysqli_close($con);
	}
}
?>