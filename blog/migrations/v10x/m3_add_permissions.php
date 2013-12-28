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
 * Add the permissions this extension will use
 */
class m1_add_permissions extends \phpbb\db\migration\migration
{
	/**
	 * @inheritdoc
	 */
	static public function depends_on()
	{
		return array('\phpbb_blog\blog\migrations\v10x\m1_initial_schema');
	}

	/**
	 * @inheritdoc
	 */
	public function update_data()
	{
		return array(
			array('permission.add', array('a_blog')), // manage blog settings

			array('permission.add', array('m_blog_approve_posts')), // Approve/unapprove posts
			array('permission.add', array('m_blog_approve_comments')), // Approve/unapprove comments
			array('permission.add', array('m_blog_lock_posts')), // Lock/unlock posts
			array('permission.add', array('m_blog_delete_posts')), // delete blog posts
			array('permission.add', array('m_blog_edit_posts')), // edit blog posts
			array('permission.add', array('m_blog_delete_comments')), // delete comments
			array('permission.add', array('m_blog_edit_comments')), // edit comments
			array('permission.add', array('m_blog_reports')), // can view and manage reported blog posts and comments

			array('permission.add', array('u_blog_view')), // Can view the blog
			array('permission.add', array('u_blog_post')), // Can post new blog posts
			array('permission.add', array('u_blog_post_approved')), // Can post without approval
			array('permission.add', array('u_blog_comment')), // Can comment on blog posts
			array('permission.add', array('u_blog_comment_approved')), // Can comment without approval
			array('permission.add', array('u_blog_report')), // Can report blog posts and
		);
	}

	/**
	 * @inheritdoc
	 */
	public function revert_data()
	{
		return array(
			array('permission.remove', array('a_blog')),

			array('permission.remove', array('m_blog_approve_posts')),
			array('permission.remove', array('m_blog_approve_comments')),
			array('permission.remove', array('m_blog_lock_posts')),
			array('permission.remove', array('m_blog_delete_posts')),
			array('permission.remove', array('m_blog_edit_posts')),
			array('permission.remove', array('m_blog_delete_comments')),
			array('permission.remove', array('m_blog_edit_comments')),
			array('permission.remove', array('m_blog_reports')),

			array('permission.remove', array('u_blog_view')),
			array('permission.remove', array('u_blog_post')),
			array('permission.remove', array('u_blog_post_approved')),
			array('permission.remove', array('u_blog_comment')),
			array('permission.remove', array('u_blog_comment_approved')),
			array('permission.remove', array('u_blog_report')),
		);
	}
}
