<?php
/**
 *
 * @package phpBBBlog
 * @copyright (c) 2012 phpBBBlog group
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

class phpbb_ext_phpbbblog_model_categories extends phpbb_ext_phpbbblog_model_container_base
{
	public function load($ids = array())
	{
		$rowset = $this->loadContainer();

		foreach ($rowset as $row)
		{
			$this[] = new phpbb_ext_phpbbblog_model_category(array_shift($row), $row, $this->db);
		}
	}

	public function get_category($id)
	{
		foreach ($this as $category)
		{
			if ($category->get_id() == $id)
			{
				return $category;
			}
		}

		return null;
	}

	public function get_categories()
	{
		return parent::get_object_data();
	}
}
