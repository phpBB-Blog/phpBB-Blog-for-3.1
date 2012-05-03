<?php

class objects_base_class extends phpbb_ext_blog_blog_objects_base
{
	protected $var1;
	protected $var2;
	protected $get = 'foobar';
	private $_private = 'this is private';

	public function set_var2($value)
	{
		$this->var2 = 'foobar';
	}

	public function load() {}
	public function parse() {}
	public function submit() {}
}
