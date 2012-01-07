<?php
// Released to Public Domain. Created by Nexii Malthus.

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