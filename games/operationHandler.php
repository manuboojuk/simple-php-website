<?php
    	
	if (!isset($_GET['operation'])) {
		$_GET['operation']="";
	}
	if ($_GET['operation'] == "register") {
		$_SESSION['state'] = "Register";
	}
	if ($_GET['operation'] == "stats") {
		$_SESSION['state'] = "Stats";
	}

	if ($_GET['operation'] == 'gg') {
		if ($_SESSION['GuessGame']->gameOver) {
			$_SESSION['state'] = 'GuessGameWon';
		}
		else {
			$_SESSION['state'] = 'GuessGame';
		}
	}

	if ($_GET['operation'] == 'rps') {
		if ($_SESSION["RockPaperScissors"]->isGameOver()) {
			$_SESSION['state'] = 'RockPaperScissorsWon';
		}
		else {
			$_SESSION['state'] = 'RockPaperScissors';
		}
	}

	if ($_GET['operation'] == 'frogs') {
		if ($_SESSION["Frogs"]->hasWon()) {
			$_SESSION['state'] = 'FrogsWon';
		}
		else {
			$_SESSION['state'] = 'Frogs';
		}
	}
	
	if ($_GET['operation'] == "profile") {
		$_SESSION['state'] = "Profile";
	}
	if ($_GET['operation'] == "logout") {
		$token = $_SESSION['token'];
		session_destroy();
		$_SESSION['token'] = $token;
		$_SESSION['state'] = "login";
	}
	unset($_GET['operation']);
?>