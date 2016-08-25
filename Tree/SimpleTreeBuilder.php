<?php

namespace Wame\Utils\Tree;

use Nette\Object;

/**
 * Class SimpleTreeSorter is used to convert array of items which have parent_id into tree. Each node in tree is represented as TreeNode.
 * 
 * @author Dominik Gmiterko <ienze@ienze.me>
 */
class SimpleTreeBuilder extends Object implements ITreeBuilder
{
    /** @var string */
    private $parentColumn = 'parent_id';
    
    /** @var string */
    private $idColumn = 'id';
    
    /** @var int */
    private $fromId = 1;

    /**
     * Converts array into tree.
     * 
     * @param array $items Array of items
     * @param string $parentColumn Property of items containing a parent_id
     * @param string $idColumn Proeprty of items containing id
     * @param int $fromId Where to start converting of tree
     * @return TreeNode Root tree node
     */
    public function buildTree($items)
    {
        $itemsChilds = [];

        foreach ($items as $item) {
            $parentColumn = $this->parentColumn;
            $parentId = 0 + $item->$parentColumn;
            $itemsChilds[$parentId][] = $item;
        }

        return $this->build($itemsChilds, $this->fromId);
    }

    private function build($itemsChilds, $parentId)
    {
        if (isset($itemsChilds[$parentId])) {
            $items = [];

            foreach ($itemsChilds[$parentId] as $item) {
                $idColumn = $this->idColumn;
                $items[] = new TreeNode($item, $this->build($itemsChilds, $idColumn, $item->$idColumn));
            }

            return $items;
        }
    }
    
    function getParentColumn()
    {
        return $this->parentColumn;
    }

    function getIdColumn()
    {
        return $this->idColumn;
    }

    function getFromId()
    {
        return $this->fromId;
    }

    function setParentColumn($parentColumn)
    {
        $this->parentColumn = $parentColumn;
    }

    function setIdColumn($idColumn)
    {
        $this->idColumn = $idColumn;
    }

    function setFromId($fromId)
    {
        $this->fromId = $fromId;
    }


}
