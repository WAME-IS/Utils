<?php

namespace Wame\Utils\Tree;

use Nette\MemberAccessException,
	Nette\Object,
	Nette\Utils\ObjectMixin;

class TreeNode {

	const CHILDS_NAME = 'child_nodes';

	private $item;
	private $childs;

	public function __construct($item, $childs = null) {
		$this->item = $item;
		$this->childs = $childs ? $childs : [];
	}

	public function __call($name, $args) {
		return call_user_func([$this->item, $name], $args);
	}

	public function __get($name) {
		if ($name != 'item') {
			if ($name == self::CHILDS_NAME) {
				return $this->childs;
			} else {
				return $this->item->$name;
			}
		} else {
			return $this->$name;
		}
	}

	public function __set($name, $value) {
		$this->item->$name = $value;
	}

	/**
	 * Is property defined?
	 * @param  string  property name
	 * @return bool
	 */
	public function __isset($name) {
		return ObjectMixin::has($this->item, $name);
	}

	/**
	 * Access to undeclared property.
	 * @param  string  property name
	 * @return void
	 * @throws MemberAccessException
	 */
	public function __unset($name) {
		ObjectMixin::remove($this->item, $name);
	}

	public function __toString() {
		if (is_scalar($this->item)) {
			return $this->item;
		} else {
			return (string) $this->item;
		}
	}

}
