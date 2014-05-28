<?php
require_once 'settings.php';
require_once 'database.php';
require_once 'mysql.php';

class Product {
	private $settings;
	private $database;
	private $mysql;
	
	private $id;
	private $series;
	private $model;
	private $manufacturerId;
	private $categoryId;
	private $subCategoryId;
	
	public function Product($id, $series, $model, $manufacturerId, $categoryId, $subCategoryId) {
		$this->settings = new Settings();
		$this->database = new Database();
		$this->mysql = new MySQL();
		
		$this->id = $id;
		$this->series = $series;
		$this->model = $model;
		$this->manufacturerId = $manufacturerId;
		$this->categoryId = $categoryId;
		$this->subCategoryId = $subCategoryId;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getSeries() {
		return $this->series;
	}
	
	public function getModel() {
		return $this->model;
	}
	
	public function getManufacturer() {
		return $this->database->getManufacturer($this->manufacturerId);
	}
	
	public function getCategory() {
		return $this->database->getCategory($this->categoryId);
	}
	
	public function getSubCategory() {
		return $this->database->getSubCategory($this->subCategoryId);
	}
	
	public function getDevices() {
		$con = $this->mysql->open();
		
		$result = mysqli_query($con, 'SELECT id FROM `devices`
									  WHERE productId = \'' . $this->getId() . '\'');
		
		$categoryList = array();
		
		while ($row = mysqli_fetch_array($result)) {
			array_push($categoryList, $this->database->getDevice($row['id']));
		}
		
		$this->mysql->close($con);
		
		return $categoryList;
	}
}
?>