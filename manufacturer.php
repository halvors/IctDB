<?php
class Manufacturer {
	private $id;
	private $name;
	private $url;
	
	public function Manufacturer($id, $name, $url) {
		$this->id = $id;
		$this->name = $name;
		$this->url = $url;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getUrl() {
		return $this->url;
	}
}
?>