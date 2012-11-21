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
 * Class representing a given post
 */
class phpbb_ext_phpbbblog_model_object_post extends phpbb_ext_phpbbblog_model_object_base
{
	/**
	 * Load the post data
	 */
	public function load()
	{
		$this->load_object();
	}
}
