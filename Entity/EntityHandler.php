<?php

namespace Wame\Utils\Entity;

class EntityHandler {

	const ENTITIES_NAMESPACE = 'Temp\App\Entities\\',
			ENTITIES_PATH = TEMP_PATH.'/entities/';

	/** @var EntityBuilder[] */
	private $builders = [];
	
	/** @var \Nette\Caching\Cache */
	private $cache;
	
	public static function generateEntitiesFolder() {
		if(!file_exists(self::ENTITIES_PATH)) {
			mkdir(self::ENTITIES_PATH, 760, TRUE);
		}
	}

	public function __construct(\Nette\Caching\IStorage $cache) {
		self::generateEntitiesFolder();
		
		$this->cache = new \Nette\Caching\Cache($cache);
	}
	
	/**
	 * @param stirng $name
	 * @return EntityBuilder
	 */
	public function getBuilder($name) {
		if (!array_key_exists($name, $this->builders)) {
			$this->builders[$name] = new EntityBuilder($name);
		}
		return $this->builders[$name];
	}

	/**
	 * Build entities, called by system
	 */
	public function buildEntities() {
		
		//Check for changes
		$hashes = [];
		foreach ($this->builders as $builder) {
			$hashes[] = $builder->hash();
		}
		$hash = Wame\Utils\Arrays::hash($hashes);
		
		$oldHash = $this->cache->load('entitiesLock');
		
		//Generate php files
		if($hash != $oldHash) {
			$this->rebuildEntities();
			
			$this->cache->save('entitiesLock', $hash);
		}
		
		//Load classes
		$loader = new \Nette\Loaders\RobotLoader();
		$loader->addDirectory(self::ENTITIES_PATH);
		$loader->setCacheStorage($this->cache->getStorage());
		$loader->register();
	}

	private function rebuildEntities() {
		
		foreach(\Nette\Utils\Finder::find('*.php')->in(self::ENTITIES_PATH) as $file) {
			unlink($file);
		}
		
		foreach ($this->builders as $builder) {
			$builder->build();
		}
	}
	
	public function getBuilders() {
		return $this->builders;
	}
}