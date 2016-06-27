<?php

namespace Wame\Utils\Entity;

class PhpClassDuplicator {

	public static function duplicate($class, \Nette\PhpGenerator\ClassType $phpClass) {

		$fromClass = new \Nette\Reflection\ClassType($class);
		
		//properties
		foreach ($fromClass->getProperties() as $porperty) {
			$insertedProp = $phpClass->addProperty($porperty->name);
			foreach (self::extractAnnotationsStrings($porperty->getDocComment()) as $annotation) {
				$insertedProp->addDocument($annotation);
			}
		}

		//methods
		/*
		  foreach ($fromClass->getMethods() as $method) {
		  $insertedMeth = $phpClass->addMethod($method->name);
		  $insertedMeth->
		  }
		 */
	}

	private static function extractAnnotationsStrings($doc) {
		$annotaions = [];

		$lines = explode("\n", $doc);
		foreach ($lines as $line) {
			if (\Nette\Utils\Strings::contains($line, '* @')) {
				$annotaions[] = \Nette\Utils\Strings::after($line, '* ');
			}
		}

		return $annotaions;
	}

}