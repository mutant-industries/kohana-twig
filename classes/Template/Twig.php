<?php defined('SYSPATH') or die('No direct script access.');

trait Template_Twig {

	/**
	 * @var String
	 */
	protected $_environment = 'default';

	/**
	 * Loads the template [Twig] object.
	 */
	public function before()
	{
		if ($this->auto_render === TRUE)
		{
			// Load the template
			$this->template = new Twig($this->template, array(), $this->_environment);
		}
	}

} // End Template_Twig
