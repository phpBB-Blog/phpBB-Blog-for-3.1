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

		$category = new phpbb_ext_blog_core_category($db, 1);
		$this->assertSame('Test category', $category->getTitle());
	}
}
