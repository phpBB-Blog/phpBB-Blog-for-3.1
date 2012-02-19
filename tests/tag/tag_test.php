<?php

class tag_test extends DBTestCase
{
	protected function getDataSet()
	{
		return $this->createXMLDataSet(__DIR__ . '/fixture.xml');
	}

	public function test_load_tag()
	{
		$db = $this->getDBAL();

		$tag = new phpbb_ext_blog_core_tag($db, 1);

		$this->assertSame('Test', $tag->getTag());
	}
}
