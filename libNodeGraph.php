<?php
// Released to Public Domain. Created by Nexii Malthus.

class NodeGraph {
	// This is a stub class.
	// Meant to help clarify the methods (and why/for what) the Pathfinding lib
	// will use when supplied with a node graph object.
	// Note that $Node* should be an integer for array lookup purposes and use as references/pointers to nodes.
	
	
	function Neighbours($Node) {
		// Return an array of connected neighbours.
		return Array();
	}
	
	function G($NodeFrom, $NodeTo) {
		// We need the 'G' costs. The cost of choosing this node. (Choice costs? -- i.e. breaking down a door)
		// You may interpret this as how difficult it would be to move to/in this node. (Movement costs?)
		// As if it were a slope or other difficult terrain to manouver. (Terrain costs?)
		return 0;
	}
	
	function H($NodeFrom, $NodeTo) {
		// We want the 'H' or heuristic cost between two nodes.
		// You can interpret this as the euclidean distance.
		// Using square roots isn't too bad and returns an extremely accurate result we need for a good path.
		return 0;
	}
}
?>