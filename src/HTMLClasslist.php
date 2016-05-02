<?php

class HTML_Classlist {

	private $classes = array();

	function __construct($classes = '') {
		$this->add($classes);	
		return $this;
	}

	//Source of valid CSS class name rules: http://stackoverflow.com/a/449000/528423
	private function valid_css_class($class = '') {
		if(strlen($class) < 2) return false; //If the class is less than two characters long

		if(preg_match('/[^A-Za-z0-9-_]/', $class)) return false; //If the class contains any character not in this list

		if(preg_match('/[^A-Za-z-_]/', substr($class, 0, 1))) return false; //If the class does not start with a valid character (no digits)

		if(substr($class, 0, 1) == '-' && preg_match('/[^A-Za-z_]/', substr($class, 1, 1))) return false; //If the class' first character is a hyphen and its second character is not a valid character

		return true;
	}

	private function sanitise_input($classes = '') {
		if(
			(!is_string($classes) && !is_array($classes))
			|| (is_string($classes) && trim($classes) === '')
			|| (is_array($classes) && count($classes) < 1)
		) {
			return array();
		}

		//If $classes is a string, tidy it and convert it into an array
		if(is_string($classes)) {
			$classes = trim($classes);
			$classes = preg_replace('/\s+/', ' ', $classes); //Replace all whitespace with spaces
			$classes = preg_replace('!\s+!', ' ', $classes); //Replace multiple spaces with single spaces
			$classes = explode(' ', $classes); //Split the string into an array
		}

		$classArray = array();

		foreach ($classes as $class) {
			if(!is_string($class)) continue;
			$class = trim($class);
			$class = preg_replace('/\s+/', '', $class); //Remove all whitespace

			if($class !== '') {
				if($this->valid_css_class($class))
					array_push($classArray, $class);
				else
					trigger_error('Invalid css class name "' . $class . '"', E_USER_WARNING);
			}
		}

		return $classArray;
	}

	public function add($classes = '') {
		$classes = $this->sanitise_input($classes);

		foreach ($classes as $class) {
			if(!in_array($class, $this->classes)) array_push($this->classes, $class);
		}

		return $this;
	}

	public function addIf($true, $classes = '') {
		if($true) $this->add($classes);
		return $this;
	}

	public function remove($classes = '') {
		$classes = $this->sanitise_input($classes);

		foreach ($classes as $class) {
			$classLocation = array_search($class, $this->classes); //Get the location of a class in the array
			if($this->classes)
				unset($this->classes[$classLocation]); //If it is found in the array, remove it
		}

		return $this;
	}

	public function removeIf($true, $classes = '') {
		if($true) $this->remove($classes);
		return $this;
	}

	public function getOutput() {
		if(count($this->classes) > 0)
			return implode(' ', $this->classes);
		else
			return '';
	}

	public function output() {
		echo $this->getOutput();
	}

}
