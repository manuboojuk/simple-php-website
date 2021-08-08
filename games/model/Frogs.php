<?php

class Frogs {

	public $frogPond;
	public $state;

	public function __construct() {
		$this->frogPond = array(0, 0, 0, -1, 1, 1, 1);
		$this->state = "";
	}
	
	public function makeMove($index){
		
		// if its a right moving frog
		if (($this->frogPond)[$index] == 0) {

			// simple move
			if ($index + 1 < 7 && ($this->frogPond)[$index + 1] == -1) {
				($this->frogPond)[$index] = -1;
				($this->frogPond)[$index + 1] = 0;
			}

			// jump move
			else if ($index + 2 < 7 && ($this->frogPond)[$index + 2] == -1) {
				($this->frogPond)[$index] = -1;
				($this->frogPond)[$index + 2] = 0; 
			}
		}

		// if its a left moving frog
		if (($this->frogPond)[$index] == 1) {
			
			// simple move
			if ($index - 1 >= 0 && ($this->frogPond)[$index - 1] == -1) {
				($this->frogPond)[$index] = -1;
				($this->frogPond)[$index - 1] = 1;
			}

			// jump move
			else if ($index - 2 >= 0 && ($this->frogPond)[$index - 2] == -1) {
				($this->frogPond)[$index] = -1;
				($this->frogPond)[$index - 2] = 1; 
			}
		}
	}

	public function hasWon() {
		if ($this->frogPond == array(1, 1, 1, -1, 0, 0, 0)) {
			return 1;
		}
		else {
			return 0;
		}
	}

	public function getState(){
		return $this->frogPond;
	}
}
?>
