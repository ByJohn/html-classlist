<?php

class HTML_Classlist {

	private $classes = array();

	function __construct($classes = '') {
		$this->add($classes);	
		return $this;
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

		//TODO: Thrown warning if class starts with invalid character
		foreach ($classes as $class) {
			if(!is_string($class)) continue;
			$class = trim($class);
			$class = preg_replace('/\s+/', '', $class); //Remove all whitespace

			if($class !== '') array_push($classArray, $class);
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
