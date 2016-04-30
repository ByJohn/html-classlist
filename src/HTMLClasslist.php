<?php

class HTML_Classlist {

	private $classes = array();

	function __construct($classes = '') {
		$this->add($classes);	
		return $this;
	}

	private function sanitise_input($classes = '') {


		return $classArray;
	}

	public function add($classes = '') {
		$classes = $this->sanitise_input($classes);

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
