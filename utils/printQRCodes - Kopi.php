<?php
require_once 'database.php';

$database = new Database();

$deviceList = $database->getDevices();

foreach ($deviceList as $device) {
	echo '<ul style="list-style-type: none;">';
		echo '<li>';
			echo $device->getQRCode();
			echo 'Device: ' . $device->getId();
		echo '</li>';
	echo '</ul>';
}
?>