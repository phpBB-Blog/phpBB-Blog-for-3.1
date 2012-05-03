<?php
/**
 *
 * @package phpBB-Blog
 * @copyright (c) 2012 phpBB-Blog
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

/**
 * Object interface
 *
 * Blog object interface. Each "blog object" must implement this interface
 */
interface phpbb_ext_blog_blog_objects_interface
{
	public function load();
	public function parse();
	public function submit();
}
