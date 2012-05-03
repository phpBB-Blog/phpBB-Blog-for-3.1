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
		$db = $this->new_dbal();
		$bp = new phpbb_ext_blog_blog_objects_post($db, 1);

		// Tests
		$this->assertSame('Test Post w Comments', $bp->title);
	}

	/**
	 * Test submitting new post
	 */
	public function test_submit_post()
	{
		$db = $this->new_dbal();

		// Use a large non-existing post ID here to check whether it
		// gets reset correctly
		$bp = new phpbb_ext_blog_blog_objects_post($db, 500);

		// Verify the blog id
		$this->assertSame(0, $bp->id);

		// Fill the new blog with information
		$data = array(
			'post'				=> 'Test submit post',
			'category'			=> 1,
			'title'				=> 'Submit',
			'poster_id'			=> 2,
		);
		$bp->set_data($data);

		// Submit the blog post
		$bp->submit();

		// Get the new ID
		$new_id = $bp->id;

		// Get the new post and test whether it was set correctly
		$bp_new = new phpbb_ext_blog_blog_objects_post($db, $new_id);
		$this->assertSame($data['post'], $bp_new->post);
	}

	/**
	 * Test updating existing post
	 */
	public function test_update_post()
	{
		$db = $this->new_dbal();
		$bp = new phpbb_ext_blog_blog_objects_post($db, 1);

		// Update the data
		$data = array(
			'post' => 'Test update post',
		);
		$bp->set_data($data);

		// Submit the update
		$bp->submit();

		// Get the new post and test whether it was set correctly
		$bp_new = new phpbb_ext_blog_blog_objects_post($db, 1);
		$this->assertSame($data['post'], $bp_new->post);
	}
}
