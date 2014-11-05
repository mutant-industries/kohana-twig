### Controller

The twig module comes with a controller trait which you can easily
extend. It works similarly to the stock `Controller_Template`.

	<?php defined('SYSPATH') or die('No direct script access.');

	class Controller_Welcome extends Controller_Template {
        use Template_Twig;

		public function action_index()
		{
			$this->template->variable = 'Hello World';

			// You can always change the filename in your action, if needed
			$this->template->set_filename('welcome/other_template');
		}
	}

Since twig templates support inheritance from within the
template it generally isn't necessary to instantiate multiple views. However, if you need to load a custom template you can always do so with:

	$view = new Twig('welcome');

A `Twig` object works exactly the same as `View` object.
