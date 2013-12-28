<?php
/**
 *
 * @package phpBB Blog
 * @copyright (c) 2013 phpBB Blog Group
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace phpbb_blog\blog\controller;

class moderate
{
	protected $request;
	protected $display;

	/**
	* Constructor
	*
	* @param \phpbb\request\request 		$request  	Request Object
	* @param \phpbb_blog\blog\display 	$display 	Display Helper Object
	*/
	public function __construct(\phpbb\request\request $request, \phpbb_blog\blog\display $display)
	{
		$this->request = $request;
		$this->display = $display;
	}

	public function main()
	{
		return $this->display->render('blog_moderate_main');
	}

	public function reportsView()
	{
		return $this->display->render('blog_moderate_reports');
	}

	public function report($id)
	{
		return $this->display->render('');
	}

	public function action($entity, $id, $action)
	{
		return $this->display->render('');
	}
}
