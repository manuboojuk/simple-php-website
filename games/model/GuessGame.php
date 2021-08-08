<?php

class GuessGame {
	public $secretNumber = 5;
	public $numGuesses = 0;
	public $history = array();
	public $state = "";
	public $gameOver;

	public function __construct() {
        	$this->secretNumber = rand(1,10);
			$this->gameOver = false;
    	}
	
	public function makeGuess($guess){
		$this->numGuesses++;
		if($guess>$this->secretNumber){
			$this->state="too high";
		} else if($guess<$this->secretNumber){
			$this->state="too low";
		} else {
			$this->state="correct";
			$this->gameOver = true;
		}
		$this->history[] = "Guess #$this->numGuesses was $guess and was $this->state.";

		if ($this->state != "correct" && $this->numGuesses == 3) {
			$this->history[] = "You lost!";
			$this->gameOver = true;
		}
	}

	public function getState(){
		return $this->state;
	}
}
?>
