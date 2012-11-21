<?php

class category_test extends blog_database_test_case
{
	protected function getDataSet()
	{
		return $this->createXMLDataSet(__DIR__ . '/fixture.xml');
	}

	public function test_load_category()
	{
		$db = $this->new_dbal();
		$category = new phpbb_ext_phpbbblog_model_category(1, array(), $db, 'phpbb_blog_categories');
		$category->load();

		$this->assertSame('Test category', $category['name']);
	}
}
