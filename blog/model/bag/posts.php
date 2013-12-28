<?php
/**
 *
 * @package phpBB Blog
 * @copyright (c) 2013 phpBB Blog Group
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace phpbb_blog\blog\model\bag;

/**
 * @ignore
 */
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
 * Posts container
 *
 * Class that holds all the posts that are
 * available in a category
 */
class posts extends base
{
	/**
	 * Load posts
	 *
	 * Load the posts, by default all
	 * posts are fetched, but it is also posible
	 * to load only specific categories.
	 *
	 * @param int|array $ids Specific posts to load
	 */
	public function load($ids = array())
	{
		$rowset = $this->load_bag();

		foreach ($rowset as $row)
		{
			$this[] = new \phpbb_blog\blog\model\object\post(array_shift($row), $row, $this->db);
		}
	}
}
