<?php
/**
 *
 * @package phpBBBlog
 * @copyright (c) 2012 phpBBBlog group
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

/**
 * @ignore
 */
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
 * @package acp
 */
class phpbb_ext_phpbbblog_acp_blog_module
{
	/** @var string */
	public $u_action;

	/** @var string */
	public $tpl_name;

	/** @var string */
	public $page_title;

	public function main($id, $mode)
	{
		$this->id	= $id;
		$this->mode	= $mode;

		if (method_exists($this, $mode))
		{
			return call_user_func(array($this, $mode));
		}
	}

	private function overview()
	{
		$this->tpl_name		= 'acp_blog_overview';
		$this->page_title	= '';
	}
}
