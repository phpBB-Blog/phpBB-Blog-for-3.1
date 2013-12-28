<?php
/**
 *
 * @package phpBB Blog
 * @copyright (c) 2013 phpBB Blog Group
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace phpbb_blog\blog\migrations\v10x;

/**
 * @ignore
 */
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
 * Initial schema changes needed for Extension installation
 */
class m1_initial_schema extends \phpbb\db\migration\migration
{
	/**
	 * @inheritdoc
	 */
	public function update_schema()
	{
		return array(
			'add_tables'	=> array(
				$this->table_prefix . 'blog_posts'	=> array(
					'COLUMNS'	=> array(
						'id'				=> array('UINT', NULL, 'auto_increment'),
						'title'				=> array('VCHAR_UNI', ''),
						'slug'				=> array('VCHAR_UNI', ''),
						'time'				=> array('UINT', 0),
						'edit_time'			=> array('UINT', 0),
						'edit_reason'		=> array('VCHAR_UNI', ''),
						'status'			=> array('UINT', 0),
						'locked'			=> array('TINT:1', 0),
						'poster_id'			=> array('UINT', 0),
						'comment_count'		=> array('UINT', 0),
						'content'			=> array('TEXT', ''),
						'bbcode_uid'		=> array('VCHAR_UNI', ''),
						'bbcode_bitfield'	=> array('VCHAR_UNI', ''),
					),
					'PRIMARY_KEY'	=> 'id',
					'KEYS'		=> array(
						'slug'			=> array('UNIQUE', 'slug'),
						'poster_id'		=> array('INDEX', 'poster_id'),
					),
				),

				$this->table_prefix . 'blog_comments'	=> array(
					'COLUMNS'	=> array(
						'id'				=> array('UINT', NULL, 'auto_increment'),
						'post_id'			=> array('UINT', 0),
						'time'				=> array('UINT', 0),
						'edit_time'			=> array('UINT', 0),
						'edit_reason'		=> array('VCHAR_UNI', ''),
						'status'			=> array('UINT', 0),
						'poster_id'			=> array('UINT', 0),
						'content'			=> array('TEXT', ''),
						'bbcode_uid'		=> array('VCHAR_UNI', ''),
						'bbcode_bitfield'	=> array('VCHAR_UNI', ''),
					),
					'PRIMARY_KEY'	=> 'id',
					'KEYS'		=> array(
						'poster_id'		=> array('INDEX', 'poster_id'),
					),
				),

				$this->table_prefix . 'blog_categories'	=> array(
					'COLUMNS'	=> array(
						'id'			=> array('UINT', NULL),
						'title'			=> array('VCHAR_UNI', ''),
						'slug'			=> array('VCHAR_UNI', ''),
						'post_count'	=> array('UINT', 0),
					),
					'PRIMARY_KEY'	=> 'id',
					'KEYS'		=> array(
						'slug'			=> array('UNIQUE', 'slug'),
					),
				),

				$this->table_prefix . 'blog_tags'	=> array(
					'COLUMNS'	=> array(
						'id'			=> array('UINT', NULL),
						'title'			=> array('VCHAR_UNI', ''),
						'slug'			=> array('VCHAR_UNI', ''),
					),
					'PRIMARY_KEY'	=> 'id',
					'KEYS'		=> array(
						'slug'			=> array('UNIQUE', 'slug'),
					),
				),

				$this->table_prefix . 'blog_post_categories'	=> array(
					'COLUMNS'	=> array(
						'id'			=> array('UINT', NULL),
						'category_id'	=> array('UINT', 0),
						'post_id'		=> array('UINT', 0),
					),
					'PRIMARY_KEY'	=> 'id',
					'KEYS'		=> array(
					),
				),

				$this->table_prefix . 'blog_post_tags'	=> array(
					'COLUMNS'	=> array(
						'id'			=> array('UINT', NULL),
						'tag_id'		=> array('UINT', 0),
						'post_id'		=> array('UINT', 0),
					),
					'PRIMARY_KEY'	=> 'id',
					'KEYS'		=> array(
					),
				),
			),
		);
	}

	/**
	 * @inheritdoc
	 */
	public function revert_schema()
	{
		return array(
			'drop_tables'	=> array(
				$this->table_prefix . 'blog_posts',
				$this->table_prefix . 'blog_comments',
				$this->table_prefix . 'blog_categories',
				$this->table_prefix . 'blog_tags',
				$this->table_prefix . 'blog_post_tags',
			),
		);
	}
}
