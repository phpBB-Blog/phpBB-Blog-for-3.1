<?php
/**
*
* @package testing
* @copyright (c) 2008 phpBB Group
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

define('IN_PHPBB', true);
$phpbb_root_path = __DIR__ . '/vendor/phpBB/phpBB/';
$phpbb_tests_path = __DIR__ . '/vendor/phpBB/tests/';
$phpEx = 'php';

$table_prefix = (!defined('table_prefix')) ? 'phpbb_' : table_prefix;

require_once $phpbb_root_path . 'includes/class_loader.' . $phpEx;

// Blog class loaders
$phpbb_class_loader = new phpbb_class_loader('phpbb_blog_mock_', __DIR__ . '/mock/', '.php');
$phpbb_class_loader->register();
$phpbb_class_loader = new phpbb_class_loader('phpbb_ext_phpbbblog_', __DIR__ . '/../blog/', '.php');
$phpbb_class_loader->register();

// phpBB Class loaders
$phpbb_class_loader_mock = new phpbb_class_loader('phpbb_mock_', $phpbb_root_path . '../tests/mock/', '.php');
$phpbb_class_loader_mock->register();
$phpbb_class_loader = new phpbb_class_loader('phpbb_', $phpbb_root_path . 'includes/', '.php');
$phpbb_class_loader->register();

require_once $phpbb_tests_path . 'test_framework/phpbb_test_case_helpers.php';
require_once $phpbb_tests_path . 'test_framework/phpbb_test_case.php';
require_once $phpbb_tests_path . 'test_framework/phpbb_database_test_case.php';
require_once $phpbb_tests_path . 'test_framework/phpbb_database_test_connection_manager.php';

require_once __DIR__ . '/test_framework/blog_test_case.php';
require_once __DIR__ . '/test_framework/blog_database_test_case.php';
require_once __DIR__ . '/test_framework/blog_database_test_connection_manager.php';

// Include some files that aren't autoloaded
require_once $phpbb_root_path . 'includes/functions.php';
require_once $phpbb_root_path . 'includes/utf/utf_tools.php';
