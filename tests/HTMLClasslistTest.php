<?php

class HTML_Classlist_Test extends PHPUnit_Framework_TestCase {
	
	public function testCreation() {
		$this->assertInstanceOf('HTML_Classlist', new HTML_Classlist);
	}

}
