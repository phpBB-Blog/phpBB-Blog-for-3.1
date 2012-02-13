<?php

/**
* Blog object
*/

class phpbb_ext_blog_includes_blog
{
	/**
	* @var phpBB User object
	*/
	private $user;

	/**
	* @var phpBB DBAL object
	*/
	private $db;

	/**
	* @var phpBB Template object
	*/
	private $template;

	/**
	* @var phpBB Request object
	*/
	private $request;

	/**
	* @var phpBB Root path
	*/
	private $phpbb_root_path;

	/**
	* @var PHP Extension
	*/
	private $phpEx;
	
	/**
	* @var Identifier for this Blog Post
	*/
	private $id;

	/**
	* @var Array of data about the Blog Post (minus the ID)
	*/
	public $data;

	/**
	* Constructor method for blog post class
	*/
	public function __construct($id = 0)
	{
		global $db, $template, $user, $config, $request;
		global $phpbb_root_path, $phpEx;

		$this->db				=& $db;
		$this->template			=& $template;
		$this->user				=& $user;
		$this->config			=& $config;
		$this->request			=& $request;
		$this->phpbb_root_path	=& $phpbb_root_path;
		$this->phpEx			=& $phpEx;

		if ($id)
		{
			$this->setId($id)->pull();
		}
	}

	/**
	* Set the Blog ID
	*
	* @param int $id Unique identifier
	* @return current object instance
	*/
	public function setId($id = 0)
	{
		$this->id = (int) $id ?: $this->id;
		return $this;
	}

	/**
	* Retrieve array of data for a blog post
	*
	* @return current object instance
	*/
	public function pull()
	{
		if (!$this->id)
		{
			// probably should do something to indicate error, but this will work for now
			return $this;
		}

		$sql = 'SELECT * FROM ' . BLOGS_TABLE . " WHERE blog_id = {$this->id}";
		$result = $this->db->sql_query($sql);
		$data = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		$this->setData($data);

		// We don't return the array; we can access it as a class property if needed
		// Yay for chained methods! :)
		return $this;
	}

	/**
	* Push the data to the DB, either insert or update depending on if $id is present
	*
	* @return current object instance
	*/
	public function push()
	{
		$mode = $this->id ? 'UPDATE' : 'INSERT';

		if (empty($this->data))
		{
			// probably should do something to indicate error, but this will work for now
			return $this;
		}

		switch ($mode)
		{
			case 'UPDATE':
				$sql = 'UPDATE ' . BLOGS_TABLE . ' SET ' . $this->db->sql_build_array($mode, $this->data) . " WHERE blog_id = {$this->id}";
			break;

			case 'INSERT':
				$sql = 'INSERT INTO ' . BLOGS_TABLE . ' ' . $this->db->sql_build_array($mode, $this->data);
			break;

			default:
			break;
		}

		$this->db->sql_query($sql);

		if ($mode == 'INSERT')
		{
			$this->id = $this->db->sql_nextid();
		}

		return $this;
	}

	/**
	* Get comments to this Blog Post
	*/
	public function pullComments()
	{
		// for now
		return $this;
	}

}
