<?php

class category_test extends DBTestCase
{
	protected function getDataSet()
	{
		return $this->createXMLDataSet(__DIR__ . '/fixture.xml');
	}

	public function test_load_category()
	{
		$db = $this->getDBAL();

		$category = new phpbb_ext_blog_core_category($db, 1);
		$this->assertSame('Test category', $category->getTitle());
	}
}
