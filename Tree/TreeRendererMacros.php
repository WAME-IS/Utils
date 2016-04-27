<?php

namespace Wame\Utils\Tree;

use Latte,
	Latte\MacroNode,
	Latte\PhpWriter;

class TreeRendererMacros extends \Latte\Macros\MacroSet {

	public static function install(Latte\Compiler $compiler) {
		$me = new static($compiler);

		$me->addMacro('treeRenderer', array($me, 'macroTreeRenderer'), array($me, 'macroTreeRenderer'));
	}

	public function macroTreeRenderer(MacroNode $node, PhpWriter $writer) {

		if (!$node->closing) {
			return $writer->write('$treeRenderer = %node.word; if(!is_array($treeRenderer)) {$treeRenderer = [$treeRenderer];} $treeRendererFunc = function($treeRendererFunc, $items) use ($_control, $_presenter) { echo "<ul>"; foreach( $items as $item) { echo "<li>"');
		} else {
			return $writer->write('echo "</li>"; if(count($item->child_nodes)) { call_user_func($treeRendererFunc, $treeRendererFunc, $item->child_nodes); } } echo "</ul>"; }; call_user_func($treeRendererFunc, $treeRendererFunc, $treeRenderer)');
		}
	}

}