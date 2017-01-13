<?php

namespace Wame\Utils;

use Nette\Application\IRouter;
use Nette\Http\Request;

class HttpRequest
{
	/** @var \Nette\Application\Request */
	public $request;
	
	
	public function __construct(IRouter $router, Request $request) 
	{
		$this->request = $router->match($request);
	}


	/**
     * Get request
     * 
     * @return \Nette\Application\Request
     */
	public function getRequest()
	{
		return $this->request;
	}

    /**
     * Get parameter
     * 
     * @param string $name parameter name
     * @return string
     */
	public function getParameter($name)
	{
		return $this->getRequest()->getParameter($name);
	}

	/**
     * Get parameters
     * 
     * @return array
     */
	public function getParameters()
	{
		return $this->getRequest()->getParameters();
	}

}
