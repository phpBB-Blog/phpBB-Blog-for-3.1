<?php

class objects_base_test extends blog_test_case
{
	private $class;

	protected function setUp()
	{
		require_once dirname(__FILE__) . '/objects_base_class.php';
		$this->class = new objects_base_class();
	}

	public function test_get()
	{
		$this->assertSame('foobar', $this->class->get);
	}

	public function test_get_non_existent()
	{
		$this->assertNull($this->class->non_existent);
	}

	public function test_get_private()
	{
		$this->class->_private;
	}

	public function test_set_data_magic()
	{
		$expected = 'variable 1';

		$this->class->set_data('var1', $expected);
		$this->assertSame($expected, $this->class->var1);
	}

	public function test_set_data_method()
	{
		$expected = 'foobar';

		$this->class->set_data('var2', 'somethingelse');
		$this->assertSame($expected, $this->class->var2);
	}
}
