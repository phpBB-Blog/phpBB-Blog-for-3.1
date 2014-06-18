<?php
/**
 *
 * @package phpBB Blog
 * @copyright (c) 2013 phpBB Blog Group
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace phpbb_blog\blog\operators\interfaces;

interface tag
{
	protected $tagRepository;

	/**
	 * Gets a list of alias' for tags
	 *
	 * @param  boolean $unused True if you want to include un-used tags
	 * @return array
	 * @access public
	 */
	public function getTagsSimpleList($unused = false)

	/**
	 * Gets details about all the tags
	 *
	 * @param  boolean $unused True if you want to include un-used tags
	 * @param  string  $sort   Sort by size (most number of post using the tag) or id (age)
	 * @return array
	 * @access public
	 */
	public function getTagsArray($unused = false, $sort = 'size')

	/**
	 * Creates a tag
	 * @param  string $name  The friendly tag name
	 * @param  string $alias The alias/slug for the tag
	 * @return int 	  $tagId The ID of the created tag (or false if it fails)
	 * @access public
	 */
	public function createTag($name, $alias)

	/**
	 * Deletes a tag
	 *
	 * @param  int $id ID of the tag to delete
	 * @return boolean
	 * @access public
	 */
	public function deleteTag($id)

	/**
	 * Deletes all unused tags
	 *
	 * @return array $deletedTags An list of the name's of deleted tags
	 * @access public
	 */
	public function deleteOrphanTags()

	public function recalculatePosts()
}
