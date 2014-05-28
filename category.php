<?php
require_once 'settings.php';
require_once 'database.php';
require_once 'mysql.php';

class Category {
	private $settings;
	private $database;
	private $mysql;
	
	private $id;
	private $name;
	
	public function Category($id, $name) {
		$this->settings = new Settings();
		$this->database = new Database();
		$this->mysql = new MySQL();
		
		$this->id = $id;
		$this->name = $name;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getDevices() {
		$con = $this->mysql->open();
		
		$result = mysqli_query($con, 'SELECT devices.id FROM `devices`
									  JOIN `products` ON devices.productId = products.id
									  WHERE products.categoryId = \'' . $this->getId() . '\'');
		
		$categoryList = array();
		
		while ($row = mysqli_fetch_array($result)) {
			array_push($categoryList, $this->database->getDevice($row['id']));
		}
		
		$this->mysql->close($con);
		
		return $categoryList;
	}
}
?>