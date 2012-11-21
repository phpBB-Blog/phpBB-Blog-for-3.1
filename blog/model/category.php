<?php
/**
 *
 * @package phpBBBlog
 * @copyright (c) 2012 phpBBBlog group
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

/**
 * Class representing a given category
 */
class phpbb_ext_phpbbblog_model_category extends phpbb_ext_phpbbblog_model_object_base
{
	private $posts = array();

	/**
	 * Load the category
	 */
	public function load()
	{
		$this->load_object();
	}

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
