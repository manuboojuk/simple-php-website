<?php

// global definitions
$ROCK = 0;
$PAPER = 1;
$SCISSORS = 2;

class RockPaperScissors {
	
	// wins
	public $humanWins = 0;
	public $machineWins = 0;
	
	// choices
	public $humanChoice;
	public $machineChoice;
	
	// bookkeeping
	public $numGames = 0;
	public $history = array();
	public $state = ""; 

	public function __construct() {
		$this->humanWins = 0;
		$this->machineWins = 0;
		$this->numGames = 0;
		$this->history = array();
		$this->state = "";
	}
		
	public function playRound ($playerChoice) {
		
		// get the players choices
		$this->humanChoice = $playerChoice;
		$this->machineChoice = rand(0,2);

		// check who won current round //

		// case of tie
		if ($this->humanChoice == $this->machineChoice) {
			
			if ($this->humanChoice == $GLOBALS['ROCK']) {
				$this->state = "Both players played rock. Draw.";
			}
			
			else if ($this->humanChoice == $GLOBALS['PAPER']) {
				$this->state = "Both players played paper. Draw.";
			}

			else {
				$this->state = "Both players played scissors. Draw.";
			}
		}

		// case where human plays rock
		if ($this->humanChoice == $GLOBALS['ROCK']) {
			
			if ($this->machineChoice == $GLOBALS['SCISSORS']) {
				$this->state = "Human played rock, machine played scissors. Human Wins Round #$this->numGames.";
				$this->humanWins++;
			}
			else {
				$this->state = "Human played rock, Machine played paper. Machine Wins Round #$this->numGames.";
				$this->machineWins++;
			}
		}

		// case where human plays paper
		if ($this->humanChoice == $GLOBALS['PAPER']) {
			
			if ($this->machineChoice == $GLOBALS['ROCK']) {
				$this->state = "Human played paper, machine played rock. Human Wins Round #$this->numGames.";
				$this->humanWins++;
			}
			else {
				$this->state = "Human played paper, Machine played scissors. Machine Wins Round #$this->numGames.";
				$this->machineWins++;
			}
		}

		// case where human plays scissors
		if ($this->humanChoice == $GLOBALS['SCISSORS']) {
			
			if ($this->machineChoice == $GLOBALS['PAPER']) {
				$this->state = "Human played scissors, machine played paper. Human Wins Round #$this->numGames.";
				$this->humanWins++;
			}
			else {
				$this->state = "Human played scissors, Machine played rock. Machine Wins Round #$this->numGames.";
				$this->machineWins++;
			}
		}

		// record history
		$this->numGames++;
		$this->history[] = "Game #$this->numGames: $this->state.";

		// check winners
		if ($this->humanWins == 5) {
			$this->history[] = "Human Wins.";
		}

		if ($this->machineWins == 5) {
			$this->history[] = "Machine Wins";
		}
	}

	public function isGameOver() {

		if ($this->humanWins >= 5 || $this->machineWins >= 5) {
			return true;
		}

		else {
			return false;
		}
	}

	public function getState() {
		return $this->state;
	}
}
?>
