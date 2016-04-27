<?php

namespace Wame\Utils\Tree;

class ComplexTreeSorter extends \Nette\Object {
	
	private $items;

	public function __construct($items) {
		if ($items instanceof \Nette\Database\Table\Selection) {
			$this->items = $items->fetchAll();
		} else {
			$this->items = $items;
		}
	}
	
	public function sortTree($fromId = 1) {
		return $this->findNodeAndChilds($this->items, $fromId);
	}
	
	private function findNodeAndChilds($nodes, $li) {
		$node = NULL;
		
		foreach ($nodes as $n) {
			if ($n->getLeft() == $li) {
				$node = $n;
			}
		}
		
		if ($node) {
			$childNodes = [];

			$nextNodeLi = $li + 1;
			while ($nextNodeLi < $node->getRight()) {
				$childNode = $this->findNodeAndChilds($nodes, $nextNodeLi);
				if ($childNode) {
					$childNodes[] = $childNode;
					$nextNodeLi = $childNode->getRight() + 1;
				} else {
					throw new \Exception('Tree is in incorrect format!');
				}
			}

			return new TreeNode($node, $childNodes);
		}
	}
}