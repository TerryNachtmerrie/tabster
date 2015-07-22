<?php
namespace Tabster\Application\View;

use Tabster\Application\Config\Config;

class View {
	private $config;
	private $templateVariables;
	private $defaultVariables; // will overwrite template variables key/pairs;
	
	private $twigLoader;
	private $twigEnvironment;
	
    public function __construct(Config $config)
	{
		$this->config = $config;
		$this->templateVariables = [];
		$this->injectedVariables = []; // from $this->config, maybe
		
		$this->twigLoader = new \Twig_Loader_Filesystem($this->config->templatePath);
		$this->twigEnvironment = new \Twig_Environment($this->twigLoader, $this->config->environmentOptions);
	}
	
	public function __set($index, $value)
	{
		$this->templateVariables[$index] = $value;
	}
	
	public function __get($index)
	{
		return array_key_exists($this->templateVariables[$index]) ? $this->templateVariables : false;
	}
}
