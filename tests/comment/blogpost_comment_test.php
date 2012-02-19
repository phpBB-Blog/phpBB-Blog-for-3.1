<?php

class blogpost_comment_test extends DBTestCase
{
	protected function getDataSet()
	{
		return $this->createXMLDataSet(__DIR__ . '/fixture.xml');
	}

	public function test_initialise_with_data()
	{
		$db = $this->getDBAL();

		$comment = new phpbb_ext_blog_core_comment($db, 1);

		$this->assertSame('First comment', $comment->parseComment());
	}

	/**
	 * Fetch post comments
	 */
	public function test_get_comments()
	{
		$db = $this->getDBAL();

		// Grep the comments
		$bp = new phpbb_ext_blog_core_post($db, 1);
		$this->assertSame(2, sizeof($bp->getComments()));
	}
}
