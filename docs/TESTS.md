## PHPUnit
The phpBB-Blog unit tests use PHPUnit framework. Version 3.5 or
better is required to run the tests. PHPUnit prefers to be installed
via PEAR; refer to http://www.phpunit.de/ for more information.

## Preparation
Copy `tests/_config.php` to `tests/config.php` and edit the options to match your local setup.

## Running
Once the prerequisites are installed, run the tests from the project root directory (above `blog/`):
`	$ phpunit`

## More Information
Further information is available on phpBB wiki:
http://wiki.phpbb.com/display/DEV/Unit+Tests
