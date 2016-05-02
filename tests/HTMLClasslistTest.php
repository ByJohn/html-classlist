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

	public function removeTestData() {
		return array(
			['test', 'test', ''],
			['test', array('test'), ''],
			['test', '', 'test'],
			['test something', 'test', 'something'],
			['test something', 'something test', ''],
			['test something', 'test something else', ''],
		);
	}

	public function hasTestData() {
		return array(
			['test', 'test', true],
			['', 'test', false],
			['test', '', false],
			['', '', false],
			['something', 'test', false],
			['something else', 'test', false],
			['test something', 'test something', true],
			['test something', 'something test', true],
			['test something', array('something', 'test'), true],
			['test something', 'something else', false]
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
		$this->expectOutputString('test');
		$cl->output();

		return $cl;
	}

	/**
	 * @depends testOutput
	 */
	public function testGetHTML($cl) {
		$this->assertEquals('class="test"', $cl->getHTML());

		return $cl;
	}

	/**
	 * @depends testGetOutput
	 */
	public function testHTML($cl) {
		$this->expectOutputString('class="test"');
		$cl->html();
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

	/**
	 * @dataProvider removeTestData
	 */
	public function testRemove($classesToAdd, $classesToRemove, $expectedOutput) {
		$cl = new HTML_Classlist($classesToAdd);
		$cl->remove($classesToRemove);
		$this->assertEquals($expectedOutput, $cl->getOutput());
	}

	/**
	 * @dataProvider addIfTestData
	 */
	public function testRemoveIf($trueTest, $shouldRemoveClasses) {
		$cl = new HTML_Classlist('test');
		$cl->removeIf($trueTest, 'test');

		if($shouldRemoveClasses)
			$this->assertEquals('', $cl->getOutput());
		else
			$this->assertEquals('test', $cl->getOutput());
	}

	/**
	 * @dataProvider hasTestData
	 */
	public function testHas($add, $has, $expectedOutput) {
		$cl = new HTML_Classlist($add);
		$this->assertEquals($expectedOutput, $cl->has($has));
	}

	//TODO: Change with test to be more flexible. With this test at the moment, all appropriate methods need to accept an empty string as their first argument in order to pass
	//Instead of an ignore list, maybe instead on check the methods that specify a return value of itself in its a docblock
	public function testAllAppropriateMethodsReturnItself() {
		$ignoredMethodNames = array(
			'__construct"',
			'has',
			'getOutput',
			'getHTML'
		);

		$cl = new HTML_Classlist();

		foreach (get_class_methods(HTML_Classlist) as $methodName) {
			if(!in_array($methodName, $ignoredMethodNames))
				$this->assertInstanceOf('HTML_Classlist', call_user_func_array(array($cl, $methodName), array('')));
		}
	}

}
