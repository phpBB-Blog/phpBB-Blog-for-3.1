<?php
/**
*
* Blog extension for the phpBB Forum Software package.
*
* @copyright (c) 2014 phpBB Blog Group
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace phpbb_blog\blog\acp;

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
class blog_module
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

		// Modes are listed in docs/blog_acp_modes.md. Please ensure this is updated
		if (method_exists($this, $mode) && $mode != 'main')
		{
			return call_user_func(array($this, $mode));
		}
	}

	private function overview()
	{
		$this->tpl_name		= 'acp_blog_overview';
		$this->page_title	= 'ACP_BLOG_MANAGEMENT';
	}
}
