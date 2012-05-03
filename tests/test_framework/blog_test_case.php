<?php

class blog_test_case extends phpbb_test_case
{
	public function get_test_case_helpers()
	{
		if (!$this->test_case_helpers)
		{
			$this->test_case_helpers = new blog_test_case_helpers($this);
		}

		return $this->test_case_helpers;
	}
}
