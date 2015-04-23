<?php

/**
 * Smarty template engine integration into Zend Framework
 * Some ideas borrowed from http://devzone.zend.com/article/120
 */
class Mleko_Zend_View_Smarty extends Zend_View_Abstract {

	/**
	 * Instance of Smarty
	 * @var Smarty
	 */
	protected $_smarty = null;

	/**
	 * Template explicitly set to render in this view
	 * @var string 
	 */
	protected $_customTemplate = '';

	/**
	 * Smarty config
	 * @var array
	 */
	private $config_ = null;

	/**
	 * Class definition and constructor
	 *
	 * @param array $config
	 */
	public function __construct($config) {
		$this->config_ = $config;
		//parent::__construct($config);
		$this->_loadSmarty();
	}

	/**
	 * Return the template engine object
	 *
	 * @return Smarty
	 */
	public function getEngine() {
		return $this->_smarty;
	}

	/**
	 * Implement _run() method
	 *
	 * The method _run() is the only method that needs to be implemented in any subclass of Zend_View_Abstract. It is called automatically within the render() method. My implementation just uses the display() method from Smarty to generate and output the template.
	 *
	 * @param string $template
	 */
	protected function _run() {
		$file = func_num_args() > 0 && file_exists(func_get_arg(0)) ? func_get_arg(0) : '';
		if ($this->_customTemplate || $file) {
			$template = $this->_customTemplate;
			if (!$template) {
				$template = $file;
			}
			Mleko_Log::dbg($template);
			Mleko_Log::dbg($this->_smarty->getTemplateDir());
			$this->_smarty->display($template);
		} else {
			throw new Zend_View_Exception('Cannot render view without any template being assigned or file does not exist');
		}
	}

	/**
	 * Overwrite assign() method
	 *
	 * The next part is an overwrite of the assign() method from Zend_View_Abstract, which works in a similar way. The big difference is that the values are assigned to the Smarty object and not to the $this->_vars variables array of Zend_View_Abstract.
	 *
	 * @param string|array $var
	 * @return Ext_View_Smarty
	 */
	public function assign($var, $value = null) {
		if (is_string($var)) {
			$this->_smarty->assign($var, $value);
		} elseif (is_array($var)) {
			foreach ($var as $key => $value) {
				$this->assign($key, $value);
			}
		} else {
			throw new Zend_View_Exception('assign() expects a string or array, got ' . gettype($var));
		}
		return $this;
	}

	/**
	 * Overwrite escape() method
	 *
	 * The next part is an overwrite of the escape() method from Zend_View_Abstract. It works both for string and array values and also uses the escape() method from the Zend_View_Abstract. The advantage of this is that I don't have to care about each value of an array to get properly escaped.
	 *
	 * @param mixed $var
	 * @return mixed
	 */
	public function escape($var) {
		if (is_string($var)) {
			return parent::escape($var);
		} elseif (is_array($var)) {
			foreach ($var as $key => $val) {
				$var[$key] = $this->escape($val);
			}
		}
		return $var;
	}

	/**
	 * Print the output
	 *
	 * The next method output() is a wrapper on the render() method from Zend_View_Abstract. It just sets some headers before printing the output.
	 *
	 * @param &lt;type> $name
	 */
	public function output($name) {
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Cache-Control: no-cache");
		header("Pragma: no-cache");
		header("Cache-Control: post-check=0, pre-check=0", false);

		print parent::render($name);
	}

	/**
	 * Use Smarty caching
	 *
	 * The last two methods were created to simply integrate the Smarty caching mechanism in the View class. With the first one you can check for cached template and with the second one you can set the caching on or of.
	 *
	 * @param string $template
	 * @return bool
	 */
	public function isCached($template) {
		return $this->_smarty->is_cached($template);
	}

	/**
	 * Enable/disable caching
	 *
	 * @param bool $caching
	 * @return Ext_View_Smarty
	 */
	public function setCaching($caching) {
		$this->_smarty->caching = $caching;
		return $this;
	}

	/**
	 * Template getter (return file path)
	 * @return string
	 */
	public function getTemplate() {
		return $this->_customTemplate;
	}

	/**
	 * Template filename setter
	 * @param string
	 * @return Ext_View_Smarty
	 */
	public function setTemplate($tpl) {
		$this->_customTemplate = $tpl;
		return $this;
	}

	/**
	 * Magic setter for Zend_View compatibility. Performs assign()
	 *
	 * @param string $key
	 * @param mixed $val
	 */
	public function __set($key, $val) {
		$this->assign($key, $val);
	}

	/**
	 * Magic getter for Zend_View compatibility. Retrieves template var
	 *
	 * @param string $key
	 * @return mixed
	 */
	public function __get($key) {
		return $this->_smarty->getTemplateVars($key);
	}

	/**
	 * Magic getter for Zend_View compatibility. Removes template var
	 * 
	 * @see View/Zend_View_Abstract::__unset()
	 * @param string $key
	 */
	public function __unset($key) {
		$this->_smarty->clearAssign($key);
	}

	/**
	 * Allows testing with empty() and isset() to work
	 * Zend_View compatibility. Checks template var for existance
	 *
	 * @param string $key
	 * @return boolean
	 */
	public function __isset($key) {
		return (null !== $this->_smarty->getTemplateVars($key));
	}

	/**
	 * Zend_View compatibility. Retrieves all template vars
	 * 
	 * @see Zend_View_Abstract::getVars()
	 * @return array
	 */
	public function getVars() {
		return $this->_smarty->getTemplateVars();
	}

	/**
	 * Updates Smarty's template_dir field with new value
	 *
	 * @param string $dir
	 * @return Ext_View_Smarty
	 */
	public function setTemplateDir($dir) {
		$this->_smarty->setTemplateDir($dir);
		return $this;
	}

	/**
	 * Adds another Smarty template_dir to scan for templates
	 *
	 * @param string $dir
	 * @return Ext_View_Smarty
	 */
	public function addTemplateDir($dir) {
		$this->_smarty->addTemplateDir($dir);
		return $this;
	}

	/**
	 * Adds another Smarty plugin directory to scan for plugins
	 *
	 * @param string $dir
	 * @return Ext_View_Smarty
	 */
	public function addPluginDir($dir) {
		$this->_smarty->addPluginsDir($dir);
		return $this;
	}

	/**
	 * Zend_View compatibility. Removes all template vars
	 * 
	 * @see View/Zend_View_Abstract::clearVars()
	 * @return Ext_View_Smarty
	 */
	public function clearVars() {
		$this->_smarty->clearAllAssign();
		$this->assign('this', $this);
		return $this;
	}

	/**
	 * Zend_View compatibility. Add the templates dir
	 * 
	 * @see View/Zend_View_Abstract::addBasePath()
	 * @return Ext_View_Smarty
	 */
	public function addBasePath($path, $classPrefix = 'Zend_View') {
		parent::addBasePath($path, $classPrefix);
		$this->addScriptPath($path . '/templates');
		$this->addTemplateDir($path . '/templates/');
		return $this;
	}

	/**
	 * Zend_View compatibility. Set the templates dir instead of scripts
	 * 
	 * @see View/Zend_View_Abstract::setBasePath()
	 * @return Ext_View_Smarty
	 */
	public function setBasePath($path, $classPrefix = 'Zend_View') {
		parent::setBasePath($path, $classPrefix);
		$this->setScriptPath($path . '/templates');
		$this->setTemplateDir($path . '/templates/');
		return $this;
	}

	/**
	 * Magic clone method, on clone create diferent smarty object
	 */
	public function __clone() {
		$this->_loadSmarty();
	}

	/**
	 * Initializes the smarty and populates config params
	 * 
	 * @throws Zend_View_Exception
	 * @return void
	 */
	private function _loadSmarty() {
		if (!class_exists('Smarty', true)) {
			require_once 'Smarty/Smarty.class.php';
		}

		$this->_smarty = new Smarty();
		
		foreach ($this->config_ as $key => $val) {
			switch ($key) {
				case 'plugins_dir':
					$this->_smarty->addPluginsDir($val);
					break;
				default :
					$this->_smarty->$key = $val;
			}
		}

		$this->assign('this', $this);
	}

}

?>