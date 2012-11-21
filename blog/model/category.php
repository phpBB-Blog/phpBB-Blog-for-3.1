<?php
/**
 *
 * @package phpBBBlog
 * @copyright (c) 2012 phpBBBlog group
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

class phpbb_ext_phpbbblog_model_category extends phpbb_ext_phpbbblog_model_object_base
{
	private $posts = array();

	private function load_posts()
	{

	}

	public function get_posts()
	{
		if (empty($this->posts))
		{
			$this->load_posts();
		}
	}
}
