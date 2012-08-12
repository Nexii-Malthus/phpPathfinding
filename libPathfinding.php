<?php
// Copyright (C) 2012 Nexii Malthus
// Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so.
// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

class PriorityQueue extends SplPriorityQueue {
	public function compare($a, $b) { // Reversed to favor lowest costs!
		if($a < $b) return 1;
		if($a > $b) return -1;
		return 0;
	}
}


define('STATUS_UNTOUCHED',	0);
define('STATUS_OPEN',		1);
define('STATUS_CLOSED',		2);


class PathFinding {
	public $Graph;
	public $Limit = 750;
	public $Cache;
	public $Debug;
	
	function __construct(&$Graph) {
		$this->Graph = &$Graph;
	}
	
	function Find($NodeStart, $NodeEnd) {
		$Queue = new PriorityQueue(); // Open Nodes ordered based on F cost
		$Queue->setExtractFlags(PriorityQueue::EXTR_DATA);
		
		$Closed = 0;
		$Found = FALSE;
		$this->Debug = '';
		
		$this->Cache = Array( // Open and Closed Nodes. Stores calculated costs and parent nodes.
			$NodeStart => Array(
				'G' => 0,
				'F' => 0,
				'Parent' => $NodeStart,
				'Status' => STATUS_OPEN
			)
		);
		$Queue->insert($NodeStart, $this->Cache[$NodeStart]['F']);
		
		while(!$Queue->isEmpty()) {
			$Node = $Queue->extract();
			
			if($this->Cache[$Node]['Status'] == STATUS_CLOSED)
				continue;
			
			if($Node == $NodeEnd) {
				$this->Cache[$Node]['Status'] = STATUS_CLOSED;
				$Found = TRUE;
				break;
			}
			
			if($Closed > $this->Limit) {
				$this->Debug = 'Hit limit. ('.$this->Limit.')';
				return NULL;
			}
			
			$Neighbours = $this->Graph->Neighbours($Node);
			foreach($Neighbours as $Neighbour) {
				$G = $this->Cache[$Node]['G'] + $this->Graph->G($Node, $Neighbour);
				
				if(	isset($this->Cache[$Neighbour])
					&& $this->Cache[$Neighbour]['Status']
					&& $this->Cache[$Neighbour]['G'] <= $G
				) continue;
				
				$F = $G + $this->Graph->H($Neighbour, $NodeEnd);
				
				$this->Cache[$Neighbour] = Array(
					'G' => $G,
					'F' => $F,
					'Parent' => $Node,
					'Status' => STATUS_OPEN
				);
				$Queue->insert($Neighbour, $F);
			}
			++$Closed;
			$this->Cache[$Node]['Status'] = STATUS_CLOSED;
		}
		
		if($Found) {
			$Path = Array();
			$Node = $NodeEnd;
			while($NodeStart != $Node) {
				$Path[] = $Node;
				$Node = $this->Cache[$Node]['Parent'];
			}
			$Path[] = $Node;
			return array_reverse($Path);
		}
		$this->Debug = 'Path not found, ran out of open nodes.';
		return NULL;
	}
}
?>