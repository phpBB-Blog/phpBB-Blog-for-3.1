<?php
/**
 *
 * @package phpBBBlog-tests
 * @copyright (c) 2012 phpBBBlog group
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

class blogpost_test extends blog_database_test_case
{
	protected function getDataSet()
	{
		return $this->createXMLDataSet(dirname(__FILE__) . '/fixture.xml');
	}

	/**
	 * Load an blog post from the database
	 */
	public function test_load_blog()
	{
		$db		= $this->new_dbal();
		$post	= new phpbb_blog\blog\model\object\post(1, array(), $db, 'phpbb_blog_posts');
		$post->load();

		// Tests
		$this->assertSame('Test Post w Comments', $post['title']);
	}
}
