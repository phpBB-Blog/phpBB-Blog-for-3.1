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
