<?php
/**
 *
 * @package phpBB-Blog
 * @copyright (c) 2012 phpBB-Blog
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

/**
 * Cache object
 *
 * Internal caching object, is responsible for all cached information,
 * this object wraps around the phpBB caching object and gracefully falls
 * back to that if a given method isn't found.
 */
class phpbb_ext_blog_blog_objects_category
{
	private $db;
	private $phpbb_cache_service;

	public function __construct(phpbb_cache_service $service, dbal $db)
	{
		$this->db = $db;
		$this->phpbb_cache_service = $service;
	}

	/**
	 * __call
	 *
	 * The requested method isn't found in this object context,
	 * pass the call through to the phpBB cache service
	 */
	public function __call($method, $arguments)
	{
		return call_user_func_array(array($this->phpbb_cache_service, $method), $arguments);
	}
}
