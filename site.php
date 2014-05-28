<?php
require_once 'database.php';

class Site {
	private $database;
	
	private $deviceId;
	private $productId;
	private $manufacturerId;
	private $categoryId;
	
	public function Site() {
		$this->database = new Database();
		
		$this->deviceId = isset($_GET['viewDevice']) ? $_GET['viewDevice'] : 0;
		$this->productId = isset($_GET['viewProduct']) ? $_GET['viewProduct'] : 0;
		$this->manufacturerId = isset($_GET['viewManufacturer']) ? $_GET['viewManufacturer'] : 0;
		$this->categoryId = isset($_GET['viewCategory']) ? $_GET['viewCategory'] : 0;
	}
	
	public function execute() {
		if (isset($_GET['viewDevice'])) {
			$device = $this->database->getDevice($this->deviceId);
			
			if ($device != null) {
				$device->display();
			} else {
				echo '<p>Denne enheten finnes ikke.</p>';
			}
		} else if (isset($_GET['viewProduct'])) {
			$product = $this->database->getProduct($this->productId);
			
			if ($product != null) {
				$deviceList = $product->getDevices();
				
				if (!empty($deviceList)) {
					$this->listDevices($deviceList);
				} else {
					echo '<p>Det finnes ingen enhter av denne typen produkt.</p>';
				}
			} else {
				echo '<p>Dette produktet finnes ikke.</p>';
			}
		} else if (isset($_GET['viewManufacturer'])) {
			$manufacturer = $this->database->getManufacturer($this->manufacturerId);
			
			if ($manufacturer != null) {
				$manufacturer->display();
			} else {
				echo '<p>Dette produsenten finnes ikke.</p>';
			}
		} else if (isset($_GET['viewCategory'])) {
			$category = $this->database->getCategory($this->categoryId);
			
			if ($category != null) {
				$deviceList = $category->getDevices();
				
				if (!empty($deviceList)) {
					$this->listDevices($deviceList);
				} else {
					echo '<p>Det finnes ingen enheter i denne kategorien.</p>';
				}
			} else {
				echo 'Denne kategorien finnes ikke!';
			}
		} else {
			echo '<h1>Bleiker IKT</h1>';
			echo '<p>Her vil du finne en liste med hvor mange produkter vi har innenfor hver kategori.</p>';
			
			$categoryList = $this->database->getCategories();
			
			if (!empty($categoryList)) {
				echo '<table>';
					echo '<tr>';
						echo '<th>Kategori</th>';
						echo '<th>Enheter</th>';
					echo '</tr>';
					
					foreach ($categoryList as $category) {
						echo '<tr>';
							echo '<td><a href="index.php?viewCategory=' . $category->getId() . '">' . $category->getName() . '</a></td>';
							echo '<td>' . count($category->getDevices()) . '</td>';
						echo '</tr>';
					}
				echo '</table>';
			} else {
				echo '<p>Det er ikke lagt til noen kategorier enda.</p>';
			}
		}
	}
	
	private function listDevices($list) {
		echo '<table>';
			echo '<tr>';
				echo '<th>Navn</th>';
				echo '<th>Model</th>';
				echo '<th>Serienummer</th>';
				echo '<th>Registrert</th>';
			echo '</tr>';
			
			foreach ($list as $device) {
				$product = $device->getProduct();
				
				echo '<tr>';
					echo '<td><a href="index.php?viewDevice=' . $device->getId() . '">' . $product->getSeries() . '</a></td>';
					echo '<td>' . $product->getModel() . '</td>';
					echo '<td>' . $device->getSerialNumber() . '</td>';
					echo '<td>' . date('d.m.Y', $device->getRegisteredDate()) . '</td>';
				echo '</tr>';
			}
		echo '</table>';
	}
}
?>