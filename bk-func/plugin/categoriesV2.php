<?php
	class categorie {
		private $id;
		private $name;
		private $defaultPage;
		
		
		// SQL
		private $db;
		
		private $sqlSetId;
		
		
		function __construct() {
			
		}
		
		// Input Functions
		
		public function setID($id) {
			$this->id = $id;
		}
		
		public function setName($name) {
			$this->name = $name;
		}
		
		public function setDefaultPage($id) {
			$this->defaultPage = $id;
		}
		
		// Output Functions
		
		public function getId() {
			return $this->id;
		}
		
		public function getName() {
			return $this->name;
		}
		
		public function getDefaultPage() {
			return $this->defaultPage;
		}
	}