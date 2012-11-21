<?php

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
		$post	= new phpbb_ext_phpbbblog_model_object_post(1, array(), $db, 'phpbb_blog_posts');
		$post->load();

		// Tests
		$this->assertSame('Test Post w Comments', $post['title']);
	}
}
