<?php
/**
 *
 * @package phpBB Blog
 * @copyright (c) 2013 phpBB Blog Group
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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
