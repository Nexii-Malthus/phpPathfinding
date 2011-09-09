<?php
// Released to Public Domain. Created by Nexii Malthus.

class NodeGraph2D {
	// This is an example class of a node graph.
	// We don't have to really extend the NodeGraph class, as all methods are overwritten anyways.
	// Nodes are in a fixed 2D tile grid of a known size.
	// The grid is spaced at 1.0 unit apart. Creating a distance of sqrt(2) for diagonal tiles.
	// $Tiles is a two-dimensional array (Array[X][Y])
	// storing one float which is used for G cost or to define an obstruction.
	
	
	public $Tiles;
	public $SX;
	public $SY;
	public $Directions = Array(
		Array( 0,-1), Array( 1, 0), Array( 0, 1), Array(-1, 0),
		Array( 1,-1), Array( 1, 1), Array(-1, 1), Array(-1,-1)
	);
	public $Movement_Horizontally = 1.0;
	public $Movement_Diagonally = M_SQRT2;
	
	
	
	
	/// Methods for basics
	function __construct($SizeX, $SizeY) {
		$this->SX = $SizeX;
		$this->SY = $SizeY;
		$this->Tiles = array_fill(0, $SizeX, array_fill(0, $SizeY, 0.0));
	}
	
	function XY2Node($X, $Y) {
		return ($Y * $this->SX) + $X;
	}
	
	function Node2XY($Lookup) {
		$X = $Lookup % $this->SX;
		$Y = (int)($Lookup / $this->SX);
		return Array($X, $Y);
	}
	
	
	
	/// Methods for debugging-ish
	function Set($NewTiles) {
		foreach($NewTiles as $NewTile)
			$this->Tiles[$NewTile[0]][$NewTile[1]] = $NewTile[2];
	}
	
	function Random() {
		$X = rand(1, $this->SX-1);
		$Y = rand(1, $this->SY-1);
		if($this->Tiles[$X][$Y] == 255) return $this->Random();
		return $this->XY2Node($X, $Y);
	}
	
	function Direction($NodeFrom, $NodeTo) {
		list($FX, $FY) = $this->Node2XY($NodeFrom);
		list($TX, $TY) = $this->Node2XY($NodeTo);
		$Dirs = Array(
			-1 => Array(-1 => 7, 0 => 3, 1 => 6),
			 0 => Array(-1 => 0, 0 => 'C', 1 => 2),
			 1 => Array(-1 => 4, 0 => 1, 1 => 5)
		);
		return $Dirs[$TX-$FX][$TY-$FY];
	}
	
	
	
	/// Pathfinding-related stuff
	function Neighbours($Node) {
		list($X, $Y) = $this->Node2XY($Node);
		
		$Neighbours = Array();
		for($i = 0; $i < 8; ++$i) {
			$NX = $X + $this->Directions[$i][0];
			$NY = $Y + $this->Directions[$i][1];
			
			if($NX < 0 || $NY < 0 || $NX >= $this->SX || $NY >= $this->SY)
				continue;
			
			if($this->Tiles[$NX][$NY] == 255)
				continue;
			
			$Neighbours[] = ($NY * $this->SX) + $NX;
		}
		
		return $Neighbours;
	}
	
	function G($NodeFrom, $NodeTo) {
		// Assumes we are being given a neighbour, as expected.
		list($FX, $FY) = $this->Node2XY($NodeFrom);
		list($TX, $TY) = $this->Node2XY($NodeTo);
		$G = $this->Tiles[$TX][$TY];
		if($FX == $TX || $FY == $TY)
			 $G += $this->Movement_Horizontally;
		else $G += $this->Movement_Diagonally;
		return $G;
	}
	
	function H($NodeFrom, $NodeTo) {
		list($FX, $FY) = $this->Node2XY($NodeFrom);
		list($TX, $TY) = $this->Node2XY($NodeTo);
		return sqrt(pow($TX - $FX, 2) + pow($TY - $FY, 2));
	}
}
?>