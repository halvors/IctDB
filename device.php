<?php
require_once 'database.php';
require_once 'phpqrcode/qrlib.php';

class Device {
	private $database;
	
	private $id;
	private $productId;
	private $serialNumber;
	private $registeredDate;
	
	public function Device($id, $productId, $serialNumber, $registeredDate) {
		$this->database = new Database();
		
		$this->id = $id;
		$this->productId = $productId;
		$this->serialNumber = $serialNumber;
		$this->registeredDate = $registeredDate;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getProductId() {
		return $this->productId;
	}
	
	public function getSerialNumber() {
		return $this->serialNumber;
	}
	
	public function getRegisteredDate() {
		return strtotime($this->registeredDate);
	}
	
	public function getProduct() {
		return $this->database->getProduct($this->productId);
	}
	
	public function getQRCode() {
		$tempDir = 'images/qrcodes/';
		 
		// With md5 or with database ID used to obtains $codeContents...
		$fileName = md5($this->getId()) . '.png';
		
		$pngAbsoluteFilePath = $tempDir . $fileName;
		
		if (!file_exists($pngAbsoluteFilePath)) {
			QRcode::png('http://' . $_SERVER['HTTP_HOST'] . '/index.php?viewDevice=' . $this->getId(), $pngAbsoluteFilePath, QR_ECLEVEL_L, 6);
		}
		
		return '<img src="' . $pngAbsoluteFilePath . '" />';
	}
	
	public function display() {
		$product = $this->getProduct();
		
		echo $this->getQRCode();
		
		echo '<table>';
			echo '<tr>';
				echo '<td>Produsent:</td>';
				echo '<td><a href="' . $product->getManufacturer()->getUrl() . '">' . $product->getManufacturer()->getName() . '</a></td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td>Produkt:</td>';
				echo '<td><a href="index.php?viewProduct=' . $product->getId() . '">' . $product->getSeries() . ' ' . $product->getModel() . '</a></td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td>Kategori:</td>';
				echo '<td>';
					echo '<a href="index.php?viewCategory=' . $product->getCategory()->getId() . '">' . $product->getCategory()->getName() . '</a> ';
					echo '(<a href="index.php?viewSubCategory=' . $product->getSubCategory()->getId() . '">' . $product->getSubCategory()->getName() . '</a>)';
				echo '</td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td>Serienummer:</td>';
				echo '<td>' . $this->getSerialNumber() . '</td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td>Registrert den:</td>';
				echo '<td>' . date('d.m.Y', $this->getRegisteredDate()) . '</td>';
			echo '</tr>';
		echo '</table>';
	}
}
?>