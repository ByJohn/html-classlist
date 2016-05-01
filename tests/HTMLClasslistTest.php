<?php

class HTML_Classlist_Test extends PHPUnit_Framework_TestCase {
	
	public function classesToAddData() {
		return array(
			'blank string' => ['', ''],
			'empty array' => [array(), ''],
			'boolean true' => [true, ''],
			'boolean false' => [false, ''],
			'single string' => ['test', 'test'],
			'string with hyphen' => ['test-two', 'test-two'],
			'multi string' => ['test something', 'test something'],
			'string with duplicate' => ['test test', 'test'],
			'multi string with duplicate' => ['test something test', 'test something'],
			'string with excess whitespace' => ['  test   something ', 'test something'],
			'string with tab' => ["test\tsomething", 'test something'],
			'single item array' => [array('test'), 'test'],
			'single item array with whitespace' => [array(' test  '), 'test'],
			'single item array with duplicate' => [array('test', 'test'), 'test'],
			'array with array item' => [array(array('test')), ''],
			'array with boolean item' => [array(false), ''],
			'multi item array' => [array('test', 'something'), 'test something'],
			'multi item array with valid strings' => [array('-test', '_something', '-_else'), '-test _something -_else'],
			'multi item array with blank' => [array('test', 'something', ''), 'test something'],
			'multi item array with duplicate' => [array('test', 'something', 'test'), 'test something']
		);
	}

	public function invalidClassesToAddData() {
		return array(
			'number start' => ['2test'],
			'star start' => ['*test'],
			'dot start' => ['.test'],
			'hash start' => ['#test'],
			'single character' => ['t'],
			'hyphen and number start' => ['-2test'],
			'double hyphen start' => ['--test'],
			'contains single quote' => ["test'"],
			'contains double quote' => ['test"'],
			'contains greater than' => ['test>ing']
		);
	}

	public function addIfTestData() {
		return array(
			'true' => [true, true],
			'false' => [false, false],
			'truth test' => [2 > 1, true],
			'false test' => [1 == 2, false],
		);
	}

	public function testCreation() {
		$this->assertInstanceOf('HTML_Classlist', new HTML_Classlist);
	}

	public function testGetOutput() {
		$cl = new HTML_Classlist('test');

		$this->assertEquals('test', $cl->getOutput());

		return $cl;
	}

	/**
	 * @depends testGetOutput
	 */
	public function testOutput($cl) {
		ob_start();

		$cl->output();

		$this->assertEquals('test', ob_get_clean());
	}

	/**
	 * @dataProvider classesToAddData
	 */
	public function testAdd($input, $expectedOutput) {
		$cl = new HTML_Classlist();
		$cl->add($input);
		$this->assertEquals($expectedOutput, $cl->getOutput());
	}

	/**
	 * @dataProvider classesToAddData
	 */
	public function testContrsuctorAdd($input, $expectedOutput) {
		$cl = new HTML_Classlist($input);
		$this->assertEquals($expectedOutput, $cl->getOutput());
	}

	/**
	 * @dataProvider invalidClassesToAddData
	 * @expectedException PHPUnit_Framework_Error_Warning
	 */
	public function testInvalidAddTriggerWarning($input) {
		$cl = new HTML_Classlist($input);
	}

	/**
	 * @dataProvider addIfTestData
	 */
	public function testAddIf($trueTest, $shouldAddClasses) {
		$cl = new HTML_Classlist();
		$cl->addIf($trueTest, 'test');

		if($shouldAddClasses)
			$this->assertEquals('test', $cl->getOutput());
		else
			$this->assertEquals('', $cl->getOutput());
	}

}
