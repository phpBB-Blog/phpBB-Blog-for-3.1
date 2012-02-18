<?php
/**
*
* @package phpBB Blog
* @copyright (c) 2011 imkingdavid
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

class phpbb_ext_blog_controller implements phpbb_extension_controller_interface
{
	/**
	* @var phpBB User object
	*/
	private $user;

	/**
	* @var phpBB DBAL object
	*/
	private $db;

	/**
	* @var phpBB Template object
	*/
	private $template;

	/**
	* @var phpBB Request object
	*/
	private $request;

	/**
	* @var phpBB Root path
	*/
	private $phpbb_root_path;

	/**
	* @var PHP Extension
	*/
	private $phpEx;

	public function __construct()
	{
		global $db, $template, $user, $config, $request;
		global $phpbb_root_path, $phpEx;

		$this->db				=& $db;
		$this->template			=& $template;
		$this->user				=& $user;
		$this->config			=& $config;
		$this->request			=& $request;
		$this->phpbb_root_path	=& $phpbb_root_path;
		$this->phpEx			=& $phpEx;
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

		// And the rest of this this goes at the end... basically just outputting the page.
		$this->template->set_ext_dir_prefix($this->phpbb_root_path . 'ext/blog/');

		// @todo make template files
		$this->template->set_filenames(array(
			'body' => 'blog_body.html'
		));

		page_header('WELCOME_TO_FOOBAR');
		page_footer();
	}
}
