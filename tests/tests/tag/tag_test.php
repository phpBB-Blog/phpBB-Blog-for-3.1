<?php

class tag_test extends blog_database_test_case
{
	protected function getDataSet()
	{
		return $this->createXMLDataSet(dirname(__FILE__) . '/fixture.xml');
	}

	public function test_load_tag()
	{
		$db = $this->new_dbal();
		$tag = new phpbb_ext_blog_blog_objects_tag($db, 1);

		$this->assertSame('Test', $tag->tag);
	}
}
