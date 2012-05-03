<?php

class category_test extends blog_database_test_case
{
	protected function getDataSet()
	{
		return $this->createXMLDataSet(dirname(__FILE__) . '/fixture.xml');
	}

	public function test_load_category()
	{
		$db = $this->new_dbal();
		$category = new phpbb_ext_blog_blog_objects_category($db, 1);

		$this->assertSame('Test category', $category->title);
	}

	public function test_load_category_with_posts()
	{
		$db = $this->new_dbal();
		$category = new phpbb_ext_blog_blog_objects_category($db, 2);

		// Reset the posts
		$category->set_data('posts', array());

		// Load the posts
		$category->get_posts();

		// Test
		$this->assertCount(2, $category->posts);
	}
}
