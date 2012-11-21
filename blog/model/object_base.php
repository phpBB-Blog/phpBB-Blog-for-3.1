<?php
/**
 *
 * @package phpBBBlog
 * @copyright (c) 2012 phpBBBlog group
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

abstract class phpbb_ext_phpbbblog_model_object_base implements phpbb_ext_phpbbblog_model_object, ArrayAccess
{
	protected $data;
	protected $db;
	protected $id;

	public function __construct($id = 0, array $data = array(), dbal $db)
	{
		$this->db = $db;
		$this->set_id($id);

		if (!empty($data))
		{
			empty($data) ?: $this->set_data($data);
		}
	}

	public function get_id()
	{
		return $this->id;
	}

	public function set_data(array $data)
	{
		$this->data = $data;
	}

	public function set_id($id)
	{
		$this->id = (int) $id;
	}

	//-- ArrayItterator implementation

	public function offsetExists($key)
	{
		return isset($this->object_data[$key]);
	}

	public function offsetGet($key)
	{
		return (isset($this->object_data[$key])) ? $this->object_data[$key] : '';
	}

	public function offsetSet($key, $value)
	{
		$key = $key ?: count($this);
		$this->object_data[$key] = $value;
	}

	public function offsetUnset($key)
	{
		unset($this->object_data[$key]);
	}

	public function __toString()
	{
		return var_export($this->data, true);
	}
}
