<?php
// Released to Public Domain. Created by Nexii Malthus.

interface NodeGraph {
	// This is an interface of what is expected from a NodeGraph object.
	// Comments help clarify why or for what the methods used in the Pathfinding lib.
	// Note that $Node, $NodeFrom and $NodeTo should be an integer for array lookup purposes.
	
	
	public function Neighbours($Node);
		// Return an array of connected neighbours.
	
	public function G($NodeFrom, $NodeTo);
		// We need the 'G' costs. The cost of choosing this node. (Choice costs? -- i.e. breaking down a door)
		// You may interpret this as how difficult it would be to move to/in this node. (Movement costs?)
		// As if it were a slope or other difficult terrain to manouver. (Terrain costs?)
	
	public function H($NodeFrom, $NodeTo);
		// We want the 'H' or heuristic cost between two nodes.
		// You can interpret this as the euclidean distance.
		// Using square roots isn't too bad and returns an extremely accurate result we need for a good path.
}
?>