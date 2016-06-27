<?php

namespace Wame\Utils\Entity;

use Nette\PhpGenerator\ClassType,
	Nette\PhpGenerator\PhpFile;

class EntityBuilder {

	/** @var stirng */
	private $name;

	/** @var string[] classes */
	private $classes = [];

	/** @var FieldDefinition[] fields */
	private $fields = [];

	public function __construct($name) {
		$this->name = $name;
	}

	public function addClass($class) {
		$this->classes[] = $class;
	}

	public function addField(FieldDefinition $fieldDefinition) {
		$this->fields[] = $fieldDefinition;
	}

	public function build() {

		$i = 0;
		foreach ($this->classes as $class) {

			$phpFile = new PhpFile();
			$phpClass = $phpFile->addClass($this->getClass($i));

			if ($i == count($this->classes) - 1) { // last
				$phpClass->addDocument("@Doctrine\ORM\Mapping\Entity");
				$phpClass->addDocument("@Doctrine\ORM\Mapping\Table(name=\"" . $this->getName() . "\")");
			} else {
				$phpClass->addDocument("@Doctrine\ORM\Mapping\MappedSuperclass");
			}
			
			if ($i == 0) { // first
				$phpClass->addExtend($class);

				$this->buildFields($phpClass, $this->fields);
			} else {
				$phpClass->addExtend($this->getClass($i - 1));

				PhpClassDuplicator::duplicate($class, $phpClass);
			}

			$path = EntityHandler::ENTITIES_PATH . $this->getName() . ($i == 0 ? '' : $i) . '.php';

			file_put_contents($path, (string) $phpFile);
			$i++;
		}
	}

	private function buildFields(ClassType $phpClass, $fields) {
		foreach ($fields as $field) {
			$property = $phpClass->addProperty($field->getName(), $field->getValue());
			foreach ($field->getOptions() as $option) {
				$property->addDocument($option);
			}
		}
	}

	public function hash() {
		return \Wame\Utils\Arrays::hash($this->classes);
	}

	public function getName() {
		return $this->name;
	}

	public function getClass($i = NULL) {
		if ($i === NULL) {
			$i = count($this->classes) - 1;
		}
		return EntityHandler::ENTITIES_NAMESPACE . $this->name . ($i == 0 ? '' : $i);
	}

}