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

class update
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

	public function create($entity)
	{
		return $this->display->render('');
	}

	public function edit($entity, $id)
	{
		return $this->display->render('');
	}

	public function delete($entity, $id)
	{
		return $this->display->render('');
	}

	public function report($entity, $id)
	{
		return $this->display->render('');
	}
}
