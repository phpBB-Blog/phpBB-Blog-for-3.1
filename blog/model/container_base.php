<?php
/**
 *
 * @package phpBBBlog
 * @copyright (c) 2012 phpBBBlog group
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

abstract class phpbb_ext_phpbbblog_model_container_base implements phpbb_ext_phpbbblog_model_container, ArrayAccess, IteratorAggregate, Countable
{
	protected $db;
	protected $object_data;
	protected $table;

	public function __construct($table, dbal $db)
	{
		$this->db		= $db;
		$this->table	= $table;
	}

	protected function loadContainer($ids = array())
	{
		$ids = is_array($ids) ? $ids : array($ids);
		
		$sql_ary = array(
			'SELECT'	=> 'c.*',
			'FROM'		=> array(
				$this->table => 'c',
			),
		);

		if (!empty($ids))
		{
			$sql_ary['WHERE'] = $this->db->sql_in_set('c.id', $ids);
		}

		$sql	= $this->db->sql_build_query('SELECT', $sql_ary);
		$result	= $this->db->sql_query($sql);
		$rowset	= $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		return $rowset;
	}

	public function get_object_data()
	{
		return $this->object_data;
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

	//-- IteratorAggregate implementation

	public function getIterator()
	{
		return new ArrayIterator($this->object_data);
	}

	//-- Countable implementation

	public function count()
	{
		return count($this->object_data);
	}
}
