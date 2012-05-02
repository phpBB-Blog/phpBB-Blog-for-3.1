<?php
/**
*
* @package phpBB Blog
* @copyright (c) 2011 imkingdavid
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

class phpbb_ext_blog_blog_controller extends phpbb_extension_controller
{
	public function __construct()
	{
		parent::__construct();

		// Include some files that *can not* be autoloaded
		global $table_prefix; // *MUST* be here, for the include!
		require dirname(__FILE__) . '/includes/constants.' . $phpEx;
	}

	/**
	* Extension front controller handler method
	*
	* @return null
	*/
	public function handle()
	{
		// blog front page stuff
		// @todo add language file
		$this->user->add_lang_ext('blog', 'blog');

		//$this->template->assign_var('MESSAGE', $this->get_message());

		// @todo make template files
		$this->template->set_filenames(array(
			'body' => 'blog_body.html'
		));

		page_header('WELCOME_TO_FOOBAR');
		page_footer();
	}
}
