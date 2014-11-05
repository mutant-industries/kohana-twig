Twig Module
===========

From [twig-project.org](http://twig-project.org)

> **Fast**: Twig compiles templates down to plain optimized PHP code. The overhead
compared to regular PHP code was reduced to the very minimum.

> **Secure**: Twig has a sandbox mode to evaluate untrusted template code. This allows
Twig to be used as a templating language for applications where users may modify
the template design.

> **Flexible**: Twig is powered by a flexible lexer and parser. This allows the developer
to define its own custom tags and filters, and create its own DSL.

Credit goes to [Jonathan Geiger](http://github.com/jonathangeiger/kohana-twig) and
[John Heathco](http://github.com/jheathco/kohana-twig) for creating the original modules.
This fork contains the following improvements.

* Refactoring & cleanup
* Updated to follow the Kohana convention, Kohana 3.3 support
* Twital support

Installation
------------

1. git submodule add https://github.com/mutant-industries/kohana-twig.git modules/twig
2. cd modules/twig && git submodule update --init
3. composer install
4. Enable twig in your bootstrap.php file
5. use in Controller

Twital support in twital branch:

1. cd modules/twig
2. git checkout twital
3. composer update

Usage
-----

Pretty similar to using the Controller_Template class.

    class Controller_Example extends Controller_Template {
      use Template_Twig;

      public function action_index()
      {
        $this->template->variable = "Hello World";
      }
    }

