<?php
require_once 'settings.php';
require_once 'mysql.php';

require_once 'device.php';
require_once 'product.php';
require_once 'manufacturer.php';
require_once 'category.php';
require_once 'subCategory.php';

class Database {
	private $settings;
	private $mysql;
	
	public function Database() {
		$this->settings = new Settings();
		$this->mysql = new MySQL();
    }
	
	/*
	 *	Devices
	 */
	
	/* Get a device by id */
	public function getDevice($id) {
		$con = $this->mysql->open();
		
		$result = mysqli_query($con, 'SELECT * FROM ' . $this->settings->tableList[1] . ' 
									  WHERE id = \'' . $id . '\'');
		
		$row = mysqli_fetch_array($result);
		
		if ($row) {
			return new Device($row['id'], $row['productId'], $row['serialNumber'], $row['registeredDate']);
		}
		
		$this->mysql->close($con);
	}
	
	/* Get a list of all devices */
	public function getDevices() {
		$con = $this->mysql->open();
		
		$result = mysqli_query($con, 'SELECT id FROM devices');
		
		$deviceList = array();
		
		while ($row = mysqli_fetch_array($result)) {
			array_push($deviceList, $this->getDevice($row['id']));
		}
		
		$this->mysql->close($con);
		
		return $deviceList;
	}
	
	/* Get a product by id */
	public function getProduct($id) {
		$con = $this->mysql->open();
		
		$result = mysqli_query($con, 'SELECT * FROM `products`
									  WHERE id = \'' . $id . '\'');
		
		$row = mysqli_fetch_array($result);
		
		if ($row) {
			return new Product($row['id'], $row['series'], $row['model'], $row['manufacturerId'], $row['categoryId'], $row['subCategoryId']);
		}
		
		$this->mysql->close($con);
	}
	
	/* Get a list of all products */
	public function getProducts() {
		$con = $this->mysql->open();
		
		$result = mysqli_query($con, 'SELECT id FROM `products`');
		
		$productList = array();
		
		while ($row = mysqli_fetch_array($result)) {
			array_push($productList, $this->getProduct($row['id']));
		}
		
		$this->mysql->close($con);
		
		return $productList;
	}
	
	/* Get a product by id */
	public function getManufacturer($id) {
		$con = $this->mysql->open();
		
		$result = mysqli_query($con, 'SELECT * FROM `manufacturers`
									  WHERE id = \'' . $id . '\'');
		
		$row = mysqli_fetch_array($result);
		
		if ($row) {
			return new Manufacturer($row['id'], $row['name'], $row['url']);
		}
		
		$this->mysql->close($con);
	}
	
	/* Get a list of all products */
	public function getManufacturers() {
		$con = $this->mysql->open();
		
		$result = mysqli_query($con, 'SELECT id FROM `manufacturers`');
		
		$manufacturerList = array();
		
		while ($row = mysqli_fetch_array($result)) {
			array_push($manufacturerList, $this->getManufacturer($row['id']));
		}
		
		$this->mysql->close($con);
		
		return $manufacturerList;
	}
	
	/* Get a category by id */
	public function getCategory($id) {
		$con = $this->mysql->open();
		
		$result = mysqli_query($con, 'SELECT * FROM ' . $this->settings->tableList[0] . ' 
									  WHERE id = \'' . $id . '\'');
		
		$row = mysqli_fetch_array($result);
		
		if ($row) {
			return new Category($row['id'], $row['name']);
		}
		
		$this->mysql->close($con);
	}
	
	/* Get a list of all devices */
	public function getCategories() {
		$con = $this->mysql->open();
		
		$result = mysqli_query($con, 'SELECT id FROM ' . $this->settings->tableList[0]);
		
		$categoryList = array();
		
		while ($row = mysqli_fetch_array($result)) {
			array_push($categoryList, $this->getCategory($row['id']));
		}
		
		$this->mysql->close($con);
		
		return $categoryList;
	}
	
	/* Get a category by id */
	public function getSubCategory($id) {
		$con = $this->mysql->open();
		
		$result = mysqli_query($con, 'SELECT * FROM `subcategories`
									  WHERE id = \'' . $id . '\'');
		
		$row = mysqli_fetch_array($result);
		
		if ($row) {
			return new SubCategory($row['id'], $row['name']);
		}
		
		$this->mysql->close($con);
	}
	
	/* Get a list of all devices */
	public function getSubCategories() {
		$con = $this->mysql->open();
		
		$result = mysqli_query($con, 'SELECT id FROM `subcategories`');
		
		$subCategoryList = array();
		
		while ($row = mysqli_fetch_array($result)) {
			array_push($subCategoryList, $this->getSubCategory($row['id']));
		}
		
		$this->mysql->close($con);
		
		return $subCategoryList;
	}
}
?>