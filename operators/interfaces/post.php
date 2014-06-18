<?php
/**
*
* Blog extension for the phpBB Forum Software package.
*
* @copyright (c) 2014 phpBB Blog Group
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace phpbb_blog\blog\operators\interfaces;

interface post
{
	protected $postRepository;
	protected $tagRepository;
	protected $categoryRepository;
	protected $commentsRepository;

	/**
	 * Gets full details of the posts matching the criteria
	 *
	 * @param  boolean $loadComments True if comments should be loaded also
	 * @param  integer $posts        Number of posts to get, 0 for all
	 * @param  string  $sort         Sort in Ascending or Descending order (by creation)
	 * @param  string  $category     Only get posts from a certian category
	 * @param  string  $tag          Only get posts with a certian tag
	 * @param  array   $statuses 	 List of statuses of which posts should be loaded
	 * @return array   $postsData    The data of the loaded posts
	 * @access public
	 */
	public function getPosts($loadComments = true, $posts = 0, $sort = 'ASC', $category = null, $tag = null, $statuses = array(1))

	/**
	 * Gets full details on a selected post
	 * @param  int 		$id 		The ID of the post to get the data of
	 * @return array 	$postData 	The data of the loaded post
	 * @access public
	 */
	public function getPostId($id)

	/**
	 * Gets the id of the post and uses this to run getPostId
	 *
	 * @param  string $slug The slug of the post
	 * @return getPostId()
	 * @access public
	 */
	public function getPost($slug)

	public function createPost($data)

	public function softDeletePost($id)

	public function editPost($id, $data)

	public function lockPost($id)

	public function approvePost($id)

	public function disapprovePost($id)

	public function recalculateComments($id)
}
