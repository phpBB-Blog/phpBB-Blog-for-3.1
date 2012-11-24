<?php
/**
 *
 * @package phpBBBlog-tests
 * @copyright (c) 2012 phpBBBlog group
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

class bag_base_test extends blog_test_case
{
	private $bag;

	protected function setUp()
	{
		$this->bag = new phpbb_blog_mock_bag();
		$this->bag->set_object_data(array(
			'key' => 'value',
			'foo' => 'bar',
		));
	}

	//-- Test ArrayAccess implementation
	public function test_offsetExists()
	{
		$this->assertTrue(isset($this->bag['key']));
		$this->assertFalse(isset($this->bag['no-key']));
	}

	public function test_offsetGet()
	{
		$this->assertSame('value', $this->bag['key']);
		$this->assertEmpty($this->bag['no-key']);
	}

	public function test_offsetSet()
	{
		$this->assertFalse(isset($this->bag['new-key']));
		$this->bag['new-key'] = 'foobar';
		$this->assertSame('foobar', $this->bag['new-key']);
	}

	public function test_offsetSet_no_key()
	{
		$this->assertFalse(in_array('no-key', $this->bag->get_object_data()));
		$this->bag[] = 'no-key';
		$this->assertTrue(in_array('no-key', $this->bag->get_object_data()));
	}

	public function test_offsetUnset()
	{
		$this->assertTrue(isset($this->bag['key']));
		unset($this->bag['key']);
		$this->assertFalse(isset($this->bag['key']));
	}
}
