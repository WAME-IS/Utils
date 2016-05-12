<?php

namespace Wame\Utils;

use Nette\Caching\Cache;
use Nette\Caching\IStorage;
use Nette\Utils\Finder;

class CacheManager
{
	const CACHE_FOLDER = '/cache';
    
    /** @var IStorage */
    private $storage;
    
 	/** @var array */
	private $data;
	
	/** @var string */
	private $dir;
	
	/** @var string */
	private $key;
	
	/** @var array */
	private $tags = [];
	
	
    public function __construct(IStorage $storage) 
    {
        $this->storage = $storage;
    }
	
    
	/**
	 * Data
	 * 
	 * @param array $data
	 */
	public function setData($data)
	{
		$this->data = $data;
	}
	
	
	/**
	 * Folder dir
	 * 
	 * @param string $dir
	 */
	public function setDir($dir)
	{
		$this->dir = $dir;
	}
	
	
	/**
	 * Cache key name
	 * 
	 * @param string $key
	 */
	public function setKey($key)
	{
		$this->key = $key;
	}
	
	
	/**
	 * Set cache tags
	 * 
	 * @param string $tag
	 */
	public function setTag($tag)
	{
		$this->tags[] = $tag;
	}

	
	/********************************************************************************/
	
	/**
	 * Load data from cache
	 * 
	 * @return mixed
	 */
	public function load()
	{
		$cache = new Cache($this->storage, $this->dir);
		
		return $cache->load($this->key);
	}
	
	/**
	 * Save data to cache
	 * 
	 * @return mixed
	 */
	public function save()
	{
		$cache = new Cache($this->storage, $this->dir);
		$cache->save($this->key, $this->data);
		
		return $this->data;
	}
	
	/**
	 * Remove data from cache
	 */
	public function clean()
	{
		foreach (Finder::findFiles('*')->in($this->storage . '/' . $this->dir) as $key => $file) {
			unlink($key);
		}
	}

	/**
	 * Clean cache by tag
	 * 
	 * @param mixed $tags
	 */
	public function cleanByTag()
	{
		$cache = new Cache($this->storage, 'Nette.Templating.Cache');
        $cache->clean([Cache::TAGS => $this->tags]);
	}

}
