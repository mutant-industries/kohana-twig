<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class for managing Twig contexts as arrays
 *
 * @package Kohana/Twig
 * @author Jonathan Geigerm, Mutant Industries ltd. <mutant-industries@hotmail.com>
 */
class Kohana_Twig extends View {

    /**
     * @var string The extension of the file
     */
    protected $_extension;

    /**
     * @var string The environment the view is attached to
     */
    protected $_environment;

    /**
     * Constructor
     *
     * @param array $data
     */
    public function __construct($file = NULL, $data = NULL, $environment = 'default')
    {
        // Allow passing the environment if $data is not needed
        if (is_string($data))
        {
            $environment = $data;
            $data = NULL;
        }

        parent::__construct($file, $data);

        // Allow passing a Twig_Environment
        if ( ! $environment instanceof Twig_Environment)
        {
            // Load the default extension from the config
            $this->_extension = Kohana::$config->load('twig.' . $environment . '.loader.extension');

            $environment = Kohana_Twig_Environment::instance($environment);
        }

        $this->_environment = $environment;
    }

    /**
     * Sets the view filename.
     *
     * @throws  View_Exception
     * @param   string  filename
     * @return  View
     */
    public function set_filename($file)
    {
        // Store the file path locally
        $this->_file = $file;

        // Split apart at the extension if necessary
        if ($extension = pathinfo($file, PATHINFO_EXTENSION))
        {
            $this->set_extension($extension);
        }

        return $this;
    }

    /**
     * Sets a file exension
     *
     * @param string $extension
     * @return void
     */
    public function set_extension($extension)
    {
        // Strip any leading period
        $extension = ltrim($extension, '.');

        // Use this for regenerating the path, using substr
        // or some other method seems like it could miss some edge-cases
        $pathinfo = pathinfo($this->_file);

        if (isset($pathinfo['dirname']) && isset($pathinfo['filename']))
        {
            // Chomp off any extension at the end
            $this->_file = $pathinfo['dirname'] . '/' . $pathinfo['filename'];
        }

        // Save this for later
        $this->_extension = $extension;

        return $this;
    }

    /**
     * Returns the templates filename (sans extension)
     *
     * @return string
     */
    public function filename()
    {
        return $this->_file;
    }

    /**
     * Returns the template's extension
     *
     * @return string
     */
    public function extension()
    {
        return $this->_extension;
    }

    /**
     * Returns the full path of the current template ($filename + $extension)
     *
     * @return string
     */
    public function path()
    {
        if ($this->_extension)
        {
            return $this->_file . '.' . $this->_extension;
        } else
        {
            return $this->_file;
        }
    }

    /**
     * Returns the final data plus global data merged as an array
     *
     * @return array
     */
    public function as_array()
    {
        return $this->_data + Twig::$_global_data;
    }

    /**
     * Returns the environment this view is attached to
     *
     * @return Twig_Environment
     */
    public function environment()
    {
        return $this->_environment;
    }

    /**
     * Renders the view object to a string. Global and local data are merged
     * and extracted to create local variables within the view file.
     *
     * Note: Global variables with the same key name as local variables will be
     * overwritten by the local variable.
     *
     * @throws   View_Exception
     * @param    view filename
     * @return   string
     */
    public function render($file = NULL)
    {
        if ($file !== NULL)
        {
            $this->set_filename($file);
        }

        if (empty($this->_file))
        {
            throw new Kohana_View_Exception('You must set the file to use within your view before rendering');
        }

		if (Kohana::$profiling === TRUE AND class_exists('Profiler', FALSE))
		{
			// Start a new benchmark
			$benchmark = Profiler::start('template', $this->path());
		}
        // Combine local and global data and capture the output
        $output = $this->_environment->loadTemplate($this->path())->render($this->as_array());

        if (isset($benchmark))
		{
			// Stop the benchmark
			Profiler::stop($benchmark);
		}

        return $output;
    }

}
