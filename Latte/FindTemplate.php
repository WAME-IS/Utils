<?php

namespace Wame\Utils\Latte;


class FindTemplate
{
	const DEFAULT_TEMPLATE = 'default.latte';
	
	/** @var string */
	private $dir;
	
	/** @var string */
	private $templateFile;
	
	/** @var string */
	private $customTemplate;
	
	
	public function __construct($dir, $templateFile = 'null', $customTemplate = null) 
	{
		$this->dir = $dir;
		$this->templateFile = $templateFile;
		$this->customTemplate = $customTemplate;
	}
	
	
    /**
	 * Find the most appropriate template
	 * 
	 * @return string
	 */
	public function find()
	{
		$file = null;
		$dirs = [];

		if ($this->templateFile) {
			$dirs[] = APP_PATH . '/' . $this->dir . '/' . $this->templateFile;
			if ($this->customTemplate) { $dirs[] = TEMPLATES_PATH . '/' . $this->customTemplate . '/' . $this->dir . '/' . $this->templateFile; }
			$dirs[] = VENDOR_PATH . '/' . PACKAGIST_NAME . '/' . $this->dir . '/' . $this->templateFile;
		}
		
		$dirs[] = APP_PATH . '/' . $this->dir . '/' . self::DEFAULT_TEMPLATE;
		if ($this->customTemplate) { $dirs[] = TEMPLATES_PATH . '/' . $this->customTemplate . '/' . $this->dir . '/' . self::DEFAULT_TEMPLATE; }
		$dirs[] = VENDOR_PATH . '/' . PACKAGIST_NAME . '/' . $this->dir . '/' . self::DEFAULT_TEMPLATE;
		
		foreach ($dirs as $dir) {
			if (is_file($dir)) { $file = $dir; break; }
		}
		
		return $file;
	}

}