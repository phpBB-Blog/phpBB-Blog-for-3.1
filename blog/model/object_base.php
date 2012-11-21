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
	protected $table;

	public function __construct($id = 0, array $data = array(), dbal $db, $table)
	{
		$this->db = $db;
		$this->set_id($id);
		$this->table = $table;

		empty($data) ?: $this->set_data($data);
	}

	protected function load_object()
	{
		$sql_ary = array(
			'SELECT'	=> 't.*',
			'FROM'		=> array(
				$this->table => 't',
			),
			'WHERE'		=> "t.id = {$this->id}",
		);
		$sql	= $this->db->sql_build_query('SELECT', $sql_ary);
		$result	= $this->db->sql_query($sql);
		$row	= $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		if ($row)
		{
			$this->data = $row;
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
		return isset($this->data[$key]);
	}

	public function offsetGet($key)
	{
		return (isset($this->data[$key])) ? $this->data[$key] : '';
	}

	public function offsetSet($key, $value)
	{
		$key = $key ?: count($this);
		$this->data[$key] = $value;
	}

	public function offsetUnset($key)
	{
		unset($this->data[$key]);
	}

	public function __toString()
	{
		return var_export($this->data, true);
	}
}
