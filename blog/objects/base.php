<?php
/**
 *
 * @package phpBB-Blog
 * @copyright (c) 2012 phpBB-Blog
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

/**
 * base object
 *
 * Base class that is shared by all objects, defines some
 * default behavior and implements the object interface
 */
abstract class phpbb_ext_blog_blog_objects_base implements phpbb_ext_blog_blog_objects_interface
{
	protected $id;

	/**
	 * Construct the object
	 *
	 * @param dbal $db The phpBB DBAL object
	 * @param integer $id
	 */
	public function __construct(dbal $db, $id = 0)
	{
		$this->db = $db;
		$this->set_data('id', $id);

		if ($this->id > 0)
		{
			$this->load();
		}
	}

	/**
	 * Set object data
	 *
	 * Set object variable if accessable
	 *
	 * @param array|string $data  An array containing the data that
	 *                            must be set, or the property name
	 * @param string       $value The value for the given property
	 */
	public function set_data($data, $value = '')
	{
		if (!is_array($data))
		{
			$data = array($data => $value);
		}

		foreach ($data as $var => $value)
		{
			if (property_exists($this, $var))
			{
				$type = gettype($value);
				set_var($this->$var, $value, $type, true);
			}
		}
	}

	/**
	 * __get
	 */
	public function __get($name)
	{
		if (isset($this->$name))
		{
			return $this->$name;
		}
	}

	//-- Some wrappers that are *only* used during development to not break things
	public function load()
	{
		throw new Exception("Not implemented!");
	}
	public function parse()
	{
		throw new Exception("Not implemented!");
	}
	public function submit()
	{
		throw new Exception("Not implemented!");
	}
}
