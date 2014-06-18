<?php
/**
*
* Blog extension for the phpBB Forum Software package.
*
* @copyright (c) 2014 phpBB Blog Group
* @license GNU General Public License, version 2 (GPL-2.0)
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
		return $this->display->render('moderate_main');
	}

	public function reportsView()
	{
		$reports = $this->reports->getReports(5, false);

		return $this->display->render('moderate_reports');
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
