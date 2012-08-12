<?php
// Copyright (C) 2012 Nexii Malthus
// Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so.
// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

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