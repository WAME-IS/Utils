<?php

namespace Wame\Utils\Tree;

class SimpleTreeSorter extends \Nette\Object {

	private $items;

	public function __construct($items) {
		if ($items instanceof \Nette\Database\Table\Selection) {
			$this->items = $items->fetchAll();
		} else {
			$this->items = $items;
		}
	}

	public function sortTree($parentColumn = 'parent_id', $idColumn = 'id', $fromId = 0) {
		$itemsChilds = [];

		foreach ($this->items as $item) {
			$parentId = 0 + $parentId = $item->$parentColumn;
			$itemsChilds[$parentId][] = $item;
		}

		return $this->build($itemsChilds, $idColumn, $fromId);
	}

	private function build($itemsChilds, $idColumn, $parentId) {
		$items = [];

		if (isset($itemsChilds[$parentId])) {
			foreach ($itemsChilds[$parentId] as $item) {
				
				$items[] = new TreeNode($item, $this->build($itemsChilds, $idColumn, $item->$idColumn));
			}

			return $items;
		}

		return null;
	}
}
