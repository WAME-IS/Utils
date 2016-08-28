<?php

namespace Wame\Utils\Tree;

use Exception;
use Nette\InvalidArgumentException;
use Nette\Object;

/**
 * Class NestedSetTreeBuilder is used to convert array of items which have left and right ids into tree. Each node in tree is represented as TreeNode.
 * 
 * @author Dominik Gmiterko <ienze@ienze.me>
 */
class NestedSetTreeBuilder extends Object implements ITreeBuilder
{

    /** @var int Where to start converting of tree */
    private $fromId = 1;
    private $leftId = null;

    /**
     * Converts array into tree.
     * 
     * @param array $items Array of items
     * @return TreeNode Root tree node
     */
    public function buildTree($items)
    {

        if ($this->leftId) {
            $li = $this->leftId;
        } else {
            $li = null;
            foreach ($items as $item) {
                if ($item->getId() == $this->fromId) {
                    $li = $item->getLeft();
                    break;
                }
            }
        }

        if (!$li) {
            throw new InvalidArgumentException("No item with id {$this->fromId} found!");
        }

        return $this->findNodeAndChilds($items, $li);
    }

    private function findNodeAndChilds($nodes, $li)
    {
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
                    throw new Exception('Tree is in incorrect format!');
                }
            }

            return new TreeNode($node, $childNodes);
        }
    }

    function getFromId()
    {
        return $this->fromId;
    }

    function setFromId($fromId)
    {
        $this->fromId = $fromId;
    }

    public function setFrom($item)
    {
        $this->fromId = $item->getId();
        $this->leftId = $item->getLeft();
    }
}
