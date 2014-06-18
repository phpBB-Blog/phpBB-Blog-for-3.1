<?php
/**
 *
 * @package phpBB Blog
 * @copyright (c) 2013 phpBB Blog Group
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace phpbb_blog\blog\operators\interfaces;

interface comment
{
	protected $commentsRepository;
	protected $postsRepository;

	public function createComment($data)

	public function editComment($data)

	public function moveComment($id, $oldPostId, $newPostId)

	public function approveComment($id)

	public function disapproveComment($id)

	public function deleteComment($soft = false)

	public function deleteOrphanComments()

	public function countComments($postId)

	public function getComments($postId)

	public function getComment($id)

	public function getAllComments()
}
