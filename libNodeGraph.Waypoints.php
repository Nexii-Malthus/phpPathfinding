<?php
// Copyright (C) 2012 Nexii Malthus
// Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so.
// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

require_once 'libNodeGraph.php';

class NodeGraphWaypoints implements NodeGraph {
	// This representation implements a waypoint graph that has specific one-way or two-way links between nodes.
	// For example to force traffic to drive on one side of a road in one way lanes of sort.
	
	public $Nodes;
	
	
	/// Methods for basics
	function __construct($Nodes) {
		$this->Nodes = $Nodes;
	}
	
	
	/// Other Methods
	function Random() {
		$Node = array_rand($this->Nodes);
		return $Node;
	}
	
	function Pos($Node) {
		return $this->Nodes[$Node]['Pos'];
	}
	
	function Closest($PosFrom) {
		$Distance = 99999999.;
		$Closest = NULL;
		foreach($this->Nodes as $Node => $Contents) {
			$PosTo = $Contents['Pos'];
			$D = $this->VecDist($PosFrom, $PosTo);
			if($D < $Distance) {
				$Closest = $Node;
				$Distance = $D;
			}
		}
		return $Closest;
	}
	
	function VecDist($a, $b) {
		return sqrt(pow($b[0] - $a[0], 2) + pow($b[1] - $a[1], 2) + pow($b[2] - $a[2], 2));
	}
	
	
	/// Pathfinding-related stuff
	function Neighbours($Node) {
		return $this->Nodes[$Node]['Neighbours'];
	}
	
	function G($NodeFrom, $NodeTo) {
		$PosFrom = $this->Nodes[$NodeFrom]['Pos'];
		$PosTo = $this->Nodes[$NodeTo]['Pos'];
		return $this->VecDist($PosFrom, $PosTo);
	}
	
	function H($NodeFrom, $NodeTo) {
		$PosFrom = $this->Nodes[$NodeFrom]['Pos'];
		$PosTo = $this->Nodes[$NodeTo]['Pos'];
		return $this->VecDist($PosFrom, $PosTo);
	}
}
?>