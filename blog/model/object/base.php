<?php
/**
 *
 * @package phpBBBlog
 * @copyright (c) 2012 phpBBBlog group
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace phpbb_blog\blog\model\object;

/**
 * @ignore
 */
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
 * Base class for model objects
 */
abstract class base implements object, \ArrayAccess
{
	/**
	 * @var array The data for this object
	 */
	protected $data;

	/** @var dbal */
	protected $db;

	/**
	 * @var int The id of this object
	 */
	protected $id;

	/**
	 * @var string The database table
	 */
	protected $table;

	/**
	 * @param int $id
	 * @param array $data
	 * @param dbal $db
	 * @param string $table
	 */
	public function __construct($id = 0, array $data = array(), dbal $db, $table)
	{
		$this->db = $db;
		$this->set_id($id);
		$this->table = $table;
		empty($data) ?: $this->set_data($data);
	}

	/**
	 * Fetch this object from the database
	 */
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

	/**
	 * Get all data of this object
	 *
	 * @return array
	 */
	public function get_data()
	{
		return $this->data;
	}

	/**
	 * Get this objects id
	 *
	 * @return int
	 */
	public function get_id()
	{
		return $this->id;
	}

	/**
	 * Set the data array for this object
	 *
	 * @param array $data
	 */
	public function set_data(array $data)
	{
		$this->data = $data;
	}

	/**
	 * Set this objects id
	 *
	 * @param int $id
	 */
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
}
