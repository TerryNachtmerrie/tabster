<?php
namespace Tabster\Application\View;

use Tabster\Application\Config\Config;
use Tabster\Library\TwigHelper;
use \Altorouter as Router;

class View {
	private $config;
	private $router;
	private $templateVariables;
	private $defaultVariables; // will overwrite template variables key/pairs;
	
	private $twigLoader;
	private $twigEnvironment;
	private $twigTemplate;
	
    public function __construct(Config $config, Router $router)
	{
		$this->config = $config;
		$this->router = $router;
		
		$this->templateVariables = [];
		$this->defaultVariables = $config->defaultVariables; // from $this->config, maybe
		$this->defaultVariables['router'] = $this->router;
		
		$this->twigLoader = new \Twig_Loader_Filesystem($this->config->templatePath);
		$this->twigEnvironment = new \Twig_Environment($this->twigLoader, $this->config->environmentOptions);
		
		$twig_css = new \Twig_SimpleFunction('css', function($link, $options = []){
			$attributes = '';
			foreach($options as $name => $value) {
				if(is_int($name)) {
					$attributes .= ' ' . $value . ' ';
				} else {
					$attributes .= ' ' . $name . '="' . $value . '" ';
				}
			}
			return sprintf('<link rel="stylesheet" type="text/css" href="%s" %s>', $link, $attributes);
		});
		$this->twigEnvironment->addFunction($twig_css);
		
		$twig_js = new \Twig_SimpleFunction('js', function($link, $options = []){
			$attributes = '';
			foreach($options as $name => $value) {
				if(is_int($name)) {
					$attributes .= ' ' . $value . ' ';
				} else {
					$attributes .= ' ' . $name . '="' . $value . '" ';
				}
			}
			return sprintf('<script src="%s" %s></script>', $link, $attributes);
		});
		$this->twigEnvironment->addFunction($twig_js);
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
	
}
