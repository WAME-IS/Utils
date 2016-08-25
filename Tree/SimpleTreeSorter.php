<?php

namespace Wame\Utils\Tree;

/**
 * Class SimpleTreeSorter is used to convert array of items which have parent_id into tree. Each node in tree is represented as TreeNode.
 * 
 * @author Dominik Gmiterko <ienze@ienze.me>
 */
class SimpleTreeSorter extends \Nette\Object
{

    /**
     * Converts array into tree.
     * 
     * @param array $items Array of items
     * @param string $parent Property of items containing a parent_id
     * @param string $idColumn Proeprty of items containing id
     * @param int $fromId Where to start converting of tree
     * @return TreeNode Root tree node
     */
    public function sortTree($items, $parentColumn = 'parent_id', $idColumn = 'id', $fromId = 0)
    {
        $itemsChilds = [];

        foreach ($this->items as $item) {
            $parentId = 0 + $item->$parentColumn;
            $itemsChilds[$parentId][] = $item;
        }

        return $this->build($itemsChilds, $idColumn, $fromId);
    }

    private function build($itemsChilds, $idColumn, $parentId)
    {
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
