<?php

/**
* Blog object
*/

class phpbb_ext_blog_includes_blog
{
	private $db;
	private $template;
	private $user;
	private $request;
	private $config;
	private $phpbb_root_path;
	private $phpEx;
	
	private $id;
	public $data;

	public function __construct($id = 0)
	{
		global $db, $template, $user, $config, $request;
		global $phpbb_root_path, $phpEx;
		$this->db = $db;
		$this->template = $template;
		$this->user = $user;
		$this->config = $config;
		$this->request = $request;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->phpEx = $phpEx;

		if ($id)
		{
			// @todo make a view() method to output data to screen
			$this->setId($id)->pull()->view();
		}
	}

	public function setId($id = 0)
	{
		$this->id = (int) $id ?: $this->id;
		return $this;
	}

	public function pull()
	{
		$sql = 'SELECT * FROM ' . BLOGS_TABLE . " WHERE blog_id = {$this->id}";
		$result = $this->db->sql_query($sql);
		$data = $this->db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		$this->setData($data);

		return $data;
	}

	public function push()
	{
		$mode = $this->id ? 'UPDATE' : 'INSERT';

		$sql_ary = $this->data;
		switch ($mode)
		{
			case 'UPDATE':
				$sql = 'UPDATE ' . BLOGS_TABLE . ' SET ' . $this->db->sql_build_array($mode, $data) . " WHERE blog_id = {$this->id}";
			break;

			case 'INSERT':
				$sql = 'INSERT INTO ' . BLOGS_TABLE . ' ' $this->db->sql_build_array($mode, $data);
			break;

			default:
			break;
		}
		$db->sql_query($sql);

		if ($mode == 'INSERT')
		{
			$this->id = $this->db->sql_nextid();
		}

		return $this;
	}

	public function pullComments()
	{
		
	}

}
