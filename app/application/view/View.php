<?php
namespace Tabster\Application\View;

use Tabster\Application\Config\Config;

class View {
	private $config;
	private $router;
	private $templateVariables;
	private $defaultVariables; // will overwrite template variables key/pairs;
	
	private $twigLoader;
	private $twigEnvironment;
	private $twigTemplate;
	
    public function __construct(Config $config)
	{
		$this->config = $config;
		$this->templateVariables = [];
		$this->defaultVariables = $config->defaultVariables; // from $this->config, maybe
		
		$this->twigLoader = new \Twig_Loader_Filesystem($this->config->templatePath);
		$this->twigEnvironment = new \Twig_Environment($this->twigLoader, $this->config->environmentOptions);
		$this->renderedTemplate;
	}
	
	public function __set($index, $value)
	{
		$this->templateVariables[$index] = $value;
	}
	
	public function __get($index)
	{
		return array_key_exists($index, $this->templateVariables) ? $this->templateVariables[$index] : false;
	}
	
	public function setVars($array)
	{
		if(!is_array($setVars)) {
			throw new \Exception('setVars expects argument 1 to be of type array. ' . gettype($array) . ' was given.');
		}
		
		foreach($array as $index => $value) {
			$this->templateVariables[$index] = $value;
		}
	}
	
	public function setTemplate($templatename)
	{
		$this->twigTemplate = $this->twigEnvironment->loadTemplate($templatename . '.twig');
	}
	
	public function render($display = true)
	{
		$variables = array_merge($this->templateVariables, $this->defaultVariables);
		if($display) {
			echo $this->twigTemplate->render($variables);
		} else {
			return $this->twigTemplate->render($variables);
		}
	}
	
	public function display()
	{
		echo $this->renderedTemplate;
	}
}
