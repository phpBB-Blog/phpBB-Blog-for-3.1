<?php
/**
 *
 * @package phpBBBlog-tests
 * @copyright (c) 2012 phpBBBlog group
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

class categories_test extends blog_database_test_case
{
	protected function getDataSet()
	{
		return $this->createXMLDataSet(__DIR__ . '/fixture.xml');
	}

	public function test_load_bag()
	{
		$db = $this->new_dbal();
		$category_bag = new phpbb_ext_phpbbblog_model_bag_categories('phpbb_blog_categories', $db);
		$category_bag->load();

		$expected = array(
			'name'			=> 'Test category with posts',
			'description'	=> '',
			'options'		=> '0',
			'bitfield'		=> '',
			'uid'			=> '',
			'total_posts'	=> '2',
			'last_post_id'	=> '0',
		);

		$this->assertSame($expected, $category_bag->get_category(2)->get_data());
	}

	public function test_load_limited_bag()
	{
		$db = $this->new_dbal();
		$category_bag = new phpbb_ext_phpbbblog_model_bag_categories('phpbb_blog_categories', $db);
		$category_bag->load(1);

		$expected = array(
			'name'			=> 'Test category',
			'description'	=> '',
			'options'		=> '0',
			'bitfield'		=> '',
			'uid'			=> '',
			'total_posts'	=> '0',
			'last_post_id'	=> '0',
		);

		$this->assertSame($expected, $category_bag->get_category(1)->get_data());
	}

	public function test_get_nonexisting_category()
	{
		$db = $this->new_dbal();
		$category_bag = new phpbb_ext_phpbbblog_model_bag_categories('phpbb_blog_categories', $db);
		$category_bag->load();

		$this->assertNull($category_bag->get_category(999));
	}

	public function test_get_categories()
	{
		$db = $this->new_dbal();
		$category_bag = new phpbb_ext_phpbbblog_model_bag_categories('phpbb_blog_categories', $db);
		$category_bag->load();

		$this->assertCount(2, $category_bag->get_categories());
	}
}
