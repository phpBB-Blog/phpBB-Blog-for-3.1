<?php
/**
 *
 * @package phpBB-Blog-Tests
 * @copyright (c) 2012 phpBB-Blog
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

// Fetch the tests config
require 'config.php';

// Assure nothing breaks
$phpEx = 'php';
define('IN_PHPBB', true);

// Load some phpBB dependencies we need for these tests
require $phpbb_root_path . 'includes/class_loader.php';
$phpbb_class_loader = new phpbb_class_loader('phpbb_', $phpbb_root_path . 'includes/', ".$phpEx");
$phpbb_class_loader->register();
