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
	
	
	public function getRequest()
	{
		return $this->request;
	}
	
	
	public function getParameter($name)
	{
		return $this->getRequest()->getParameter($name);
	}
	
	
	public function getParameters()
	{
		return $this->getRequest()->getParameters();
	}

}