<?php

namespace Wame\Utils\Tree;

interface ITreeBuilder
{

    /**
     * Converts array into tree.
     * 
     * @param array $items Array of items
     * @return TreeNode Root tree node
     */
    public function buildTree($items);
    
}
