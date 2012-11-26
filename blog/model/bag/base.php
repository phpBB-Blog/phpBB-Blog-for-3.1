<?php
/**
 *
 * @package phpBBBlog
 * @copyright (c) 2012 phpBBBlog group
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

/**
 * @ignore
 */
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
 * Base class for the "container" models.
 */
abstract class phpbb_ext_phpbbblog_model_bag_base implements phpbb_ext_phpbbblog_model_bag, ArrayAccess, IteratorAggregate, Countable
{
	/** @var dbal */
	protected $db;

	/**
	 * @var array All objects that are part of this collection
	 */
	protected $object_data = array();

	/**
	 * @var string the table that holds the data for this container
	 */
	protected $table;

	/**
	 * @param string $table
	 * @param dbal
	 */
	public function __construct($table, dbal $db)
	{
		$this->db		= $db;
		$this->table	= $table;
	}

	/**
	 * Load the complete container
	 *
	 * Load all the data for this container, this can
	 * be limited to a given set of objects.
	 *
	 * @param string|array $ids
	 * @return array The dataset
	 */
	protected function load_bag($ids = array())
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

	/**
	 * Get all the objects
	 *
	 * @return array
	 */
	public function get_object_data()
	{
		return $this->object_data;
	}

	public function set_object_data(array $data)
	{
		$this->object_data = $data;
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
