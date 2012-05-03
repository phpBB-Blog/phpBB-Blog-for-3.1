<?php

class blogpost_comment_test extends blog_database_test_case
{
	protected function getDataSet()
	{
		return $this->createXMLDataSet(dirname(__FILE__) . '/fixture.xml');
	}

	public function test_load_post_with_comments()
	{
		$db = $this->new_dbal();
		$post = new phpbb_ext_blog_blog_objects_post($db, 1);

		// Reset the posts
		$post->set_data('comments', array());

		// Load the posts
		$post->get_comments();

		// Test
		$this->assertCount(2, $post->comments);
		
	}

	public function test_initialise_with_data()
	{
		$db = $this->new_dbal();
		$comment = new phpbb_ext_blog_blog_objects_comments($db, 1);

		$this->assertSame('First comment', $comment->comment);
	}
}
