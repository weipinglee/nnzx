<?php

namespace Library\views;
/**
 * Simple view class to help enforce private constructs.
 *
 */
use \Library\client;
class wittyAdapter implements \Yaf\View_Interface {


	protected $witty = null;

	public $layout = '';

	/**
	 * Constructor.
	 *
	 * @param array $config Configuration key-value pairs.
	 */
	public function __construct($config) {

		// set template path
		$this->witty = new witty();
		//初始化目录
		$client = client::getDevice();
		
		$templateName = isset($config['template'][$client]) ? $config['template'][$client] : 'pc';

		$this->witty->setTemplateName($templateName);
		$tpl_dir =  $config['tpl_dir'].'/'.$templateName.'/'  ;
		$this->witty->setTplDir($tpl_dir);
		$this->witty->setLayoutDir($tpl_dir.'/layout/');
		$this->witty->setCompileDir($config['compile_dir'].'/'.$templateName.'/');
		$this->witty->setCacheDir($config['cache_dir']);

		//$this->_options = $options;
	}

	public function setLayout($layout){
		$this->witty->setLayout($layout);
	}

	/**
	 * Assigns variables to the view script via differing strategies.
	 *
	 * Yaf_View_Simple::assign('name', $value) assigns a variable called 'name'
	 * with the corresponding $value.
	 *
	 * Yaf_View_Simple::assign($array) assigns the array keys as variable
	 * names (with the corresponding array values).
	 *
	 * @see    __set()
	 *
	 * @param  string|array     The assignment strategy to use.
	 * @param  mixed (Optional) If  assigning a named variable, use this
	 *                              as the value.
	 *
	 * @return witty
	 * @throws Yaf_Exception_LoadFailed_View if $name is
	 * neither a string nor an array,
	 */
	public function assign($name, $value = null) {
		// which strategy to use?
		if (is_string($name))
		{
			// assign by name and value
			$this->witty->assign($name,$value);
		}
		elseif (is_array($name))
		{
			// assign from associative array
			foreach ($name as $key => $val)
			{
				$this->witty->assign($key,$val);
			}
		}
		else
		{
			throw new \Yaf\Exception('assign() expects a string or array, received ' . gettype($name));
		}

		return $this;
	}

	/**
	 * Assigns by reference a variable to the view script.
	 *
	 * @param  string The name of the variable to be used in the template .
	 * @param  mixed  the variable value
	 *
	 * @return Yaf_View_Simple
	 * @throws Yaf_Exception_LoadFailed_View if $name is not a string,
	 */
	public function assignRef($name, &$value) {
		// which strategy to use?
		if (is_string($name))
		{
			// assign by name and value
			$this->witty->assign($name,$value);
		}
		else
		{
			throw new \Yaf\Exception('assign() expects a string, received ' . gettype($name));
		}

		return $this;
	}

	/**
	 * 设置模板目录
	 * @param $dir
	 */
	public function setScriptPath($dir){
		$this->witty->setTplDir($dir);
	}

	/**
	 * Return path to find the view script used by render()
	 *
	 * @return null|string Null if script not found
	 */
	public function getScriptPath() {
		return $this->witty->_tpl_dir;
	}



	/**
	 * Processes a view script and displays the output.
	 *
	 * @param string $tpl      The script name to process.
	 * @param string $tpl_vars The variables to use in the view.
	 *
	 * @return string The script output.
	 */
	public function display($tpl, $tplVars = array()) {

		if (!is_string($tpl) || $tpl == null)
		{
			return false;
		}

		$this->witty->render($tpl);

		return true;

	}


	/**
	 * Assigns a variable or an associative array to the view script.
	 *
	 * @see assign()
	 *
	 * @param string $name  The variable name or array.
	 * @param mixed  $value The variable value.
	 *
	 * @return void
	 */
	public function __set($name, $value) {
		$this->witty->assign($name, $value);
	}



	/**
	 * Processes a view script and returns the output.
	 *
	 * @param string $tpl      The script name to process.
	 * @param string $tpl_vars The variables to use in the view.
	 *
	 * @return string The script output.
	 */
	public function render($tpl, $tplVars = array()) {

		if (!is_string($tpl) || $tpl == null)
		{
			return false;
		}
		// find the script file name using the private method
		//$template = $this->_script($tpl);

		$this->witty->render($tpl);

	}


}
