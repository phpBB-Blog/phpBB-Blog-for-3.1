<?php
/**
 *
 * @package phpBBBlog-tests
 * @copyright (c) 2012 phpBBBlog group
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

class object_base_test extends blog_test_case
{
	private $object;

	protected function setUp()
	{
		require_once __DIR__ . '/../../../mock/mock_object.php';
		$this->object = new mock_object();
		$this->object->set_data(array(
			'key' => 'value',
			'foo' => 'bar',
		));
	}

	//-- Test ArrayAccess implementation
	public function test_offsetExists()
	{
		$this->assertTrue(isset($this->object['key']));
		$this->assertFalse(isset($this->object['no-key']));
	}

	public function test_offsetGet()
	{
		$this->assertSame('value', $this->object['key']);
		$this->assertEmpty($this->object['no-key']);
	}

	public function test_offsetSet()
	{
		$this->assertFalse(isset($this->object['new-key']));
		$this->object['new-key'] = 'foobar';
		$this->assertSame('foobar', $this->object['new-key']);
	}

	public function test_offsetSet_no_key()
	{
		$this->assertFalse(in_array('no-key', $this->object->get_data()));
		$this->object[] = 'no-key';
		$this->assertTrue(in_array('no-key', $this->object->get_data()));
	}

	public function test_offsetUnset()
	{
		$this->assertTrue(isset($this->object['key']));
		unset($this->object['key']);
		$this->assertFalse(isset($this->object['key']));
	}
}
