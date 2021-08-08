<?php
	ini_set('display_errors', 'On');
	require_once "lib/lib.php";
	require_once "model/GuessGame.php";
	require_once "model/RockPaperScissors.php";
	require_once "model/Frogs.php";

	session_save_path("sess");
	session_start(); 

	$dbconn = db_connect();

	$errors=array();
	$view="";

	// handle operations and assign state accordingly
	include 'operationHandler.php';

	/* controller code */

	/* local actions, these are state transforms */
	if(!isset($_SESSION['state'])){
		$_SESSION['state']='login';
	}

	switch($_SESSION['state']){
		case "login":
			// the view we display by default
			$view="login.php";

			// check if submit or not
			if(empty($_REQUEST['submit']) || $_REQUEST['submit']!="login"){
				break;
			}

			// check token
			if (isset($_SESSION['token']) && $_REQUEST['token'] != $_SESSION['token']) {
				break;
			}

			// validate and set errors
			if(empty($_REQUEST['user']))$errors[]='user is required';
			if(empty($_REQUEST['password']))$errors[]='password is required';
			if(!empty($errors))break;

			// perform operation, switching state and view if necessary
			if(!$dbconn){
				$errors[]="Can't connect to db";
				break;
			}

			// cleanse user input
			$_REQUEST['user'] = htmlspecialchars($_REQUEST['user']);
			$_REQUEST['password'] = htmlspecialchars($_REQUEST['password']);

			// get user info from db
			$query = "SELECT * FROM appuser WHERE userid=$1;";
			$result = pg_prepare($dbconn, "", $query);
			$result = pg_execute($dbconn, "", array($_REQUEST['user']));
			$row = pg_fetch_array($result, NULL, PGSQL_ASSOC);

            if($row != false && password_verify($_REQUEST['password'], $row['password'])){
				$_SESSION['user'] = htmlspecialchars($_REQUEST['user']);
				$_SESSION['userInfo'] = $row;
				$_SESSION['GuessGame'] = new GuessGame();
				$_SESSION['RockPaperScissors'] = new RockPaperScissors();
				$_SESSION['Frogs'] = new Frogs();
				$_SESSION['state']='Stats';
				$view="Stats.php";
			} else {
				$errors[]="invalid login";
			}

			$_SESSION['token'] = md5(uniqid());

			break;

		case "Register":

			// set the view
			$view = "Register.php";

			// check if submitted or not
			if (empty($_REQUEST['regSubmit']) || $_REQUEST['regSubmit']!="Register!") {
				break;
			}

			// check token
			if ($_REQUEST['token'] != $_SESSION['token']) {
				break;
			}

			// check if text fields are empty
			if(empty($_REQUEST['regUsername']))$errors[]='[ERROR]: Please enter a username';
			if(empty($_REQUEST['regPassword']))$errors[]='[ERROR]: Please enter a password';
			if(empty($_REQUEST['regPassword2']))$errors[]='[ERROR]: Please enter password twice';

			// cleanse user input
			$_REQUEST['regUsername'] = htmlspecialchars($_REQUEST['regUsername']);
			$_REQUEST['regPassword'] = htmlspecialchars($_REQUEST['regPassword']);
			$_REQUEST['regPassword2'] = htmlspecialchars($_REQUEST['regPassword2']);

			// check if the other fields are empty
			if(empty($_REQUEST['gender']))$errors[]='[ERROR]: Please indicate your gender';
			if($_REQUEST['regPassword'] != $_REQUEST['regPassword2'])$errors[]='[ERROR]: Passwords must match';

			// check if username is taken
			$query = "SELECT * FROM appuser WHERE userid = $1";
			$result = pg_prepare($dbconn, "", $query);
			$result = pg_execute($dbconn, "", array($_REQUEST['regUsername']));
			if ($row = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
				$errors[]='[ERROR]: Username taken, please choose another username';
			}

			if(!empty($errors))break;

			// make a db query to enter a row for new user
			$query = "INSERT INTO appuser(userid, password, gender, age, uoftStudent, pizzaPref, guessgamewins, rockpaperscissorswins, frogswins) VALUES ($1, $2, $3, $4, $5, $6, 0, 0, 0);";
			$result = pg_prepare($dbconn, "", $query);
			$attributes = array();

			// set username and password
			$attributes[] = $_REQUEST['regUsername'];
			$attributes[] = password_hash($_REQUEST['regPassword'], PASSWORD_BCRYPT);

			// set gender
			if ($_REQUEST['gender'] == 'male') {
				$attributes[] = 'Male';
			}
			else if ($_REQUEST['gender'] == 'female') {
				$attributes[] = 'Female';
			}
			else {
				$attributes[] = 'Other';
			}

			// set age
			$attributes[] = intval($_REQUEST['age']);

			// set uoftStudent attribute
			if (isset($_REQUEST['student'])) {
				$attributes[] = 1;
			}
			else {
				$attributes[] = 0;
			}

			// set pizzaPref attribute
			if (isset($_REQUEST['pizzaPref'])) {
				$attributes[] = 1;
			}
			else {
				$attributes[] = 0;
			}

			// insert the row
			$result = pg_execute($dbconn, "", $attributes);
			$view = 'login.php';
			$_SESSION['state'] = 'login';

			$_SESSION['token'] = md5(uniqid());

			break;

		case "GuessGame":

			// the view we display by default
			$view="GuessGame.php";

			// check if submit or not and check token
			if(empty($_REQUEST['submit'])||$_REQUEST['submit']!="guess"||$_REQUEST['token'] != $_SESSION['token']){
				break;
			}

			// validate and set errors
			if(!is_numeric($_REQUEST["guess"]))$errors[]="Guess must be numeric.";
			if(!empty($errors))break;

			// cleanse user input (bit overkill but just to be safe)
			$_REQUEST["guess"] = htmlspecialchars($_REQUEST["guess"]);

			// perform operation, switching state and view if necessary
			$_SESSION["GuessGame"]->makeGuess($_REQUEST['guess']);
			if($_SESSION["GuessGame"]->gameOver){
				
				// set state and view 
				$_SESSION['state']="GuessGameWon";
				$view="GuessGameWon.php";

				// update db if won
				if ($_SESSION['GuessGame']->getState() == 'correct') {
					$query = "UPDATE appuser SET guessgamewins = guessgamewins + 1 WHERE userid = $1;";
					$result = pg_prepare($dbconn, "", $query);
					$result = pg_execute($dbconn, "", array($_SESSION['userInfo']['userid']));
				}
			}
			$_SESSION['token'] = md5(uniqid());
			$_REQUEST['guess']="";

			break;
			
		case "GuessGameWon":

			// the view we display by default
			$view="GuessGame.php";

			// check if submit or not
			if(empty($_REQUEST['submit'])||$_REQUEST['submit']!="start again"){
				$view="GuessGameWon.php";
				break;
			}

			// perform operation, switching state and view if necessary
			$_SESSION["GuessGame"]=new GuessGame();
			$_SESSION['state']="GuessGame";
			$view="GuessGame.php";
			break;
		
		case "Stats":

			$view='Stats.php';
			break;
		
		case "RockPaperScissors":

			// set default view
			$view='RockPaperScissors.php';

			// check if submit or not
			if (!isset($_REQUEST['choice'])) {
				break;
			}

			// check token
			if ($_REQUEST['token'] != $_SESSION['token']) {
				break;
			}

			// input humans choice
			if ($_REQUEST['choice'] == 'Rock') {
				$_SESSION["RockPaperScissors"]->playRound(0);
			}

			else if ($_REQUEST['choice'] == 'Paper') {
				$_SESSION["RockPaperScissors"]->playRound(1);
			}

			else {
				$_SESSION["RockPaperScissors"]->playRound(2);
			}

			if ($_SESSION["RockPaperScissors"]->isGameOver()) {
				$_SESSION['state'] = "RockPaperScissorsWon";
				$view = "RockPaperScissorsWon.php";

				// update db if won
				if ($_SESSION['RockPaperScissors']->humanWins == 5) {
					$query = "UPDATE appuser SET rockpaperscissorswins = rockpaperscissorswins + 1 WHERE userid = $1;";
					$result = pg_prepare($dbconn, "", $query);
					$result = pg_execute($dbconn, "", array($_SESSION['userInfo']['userid']));
				}
			}
			$_SESSION['token'] = md5(uniqid());
			break;
		
		case "RockPaperScissorsWon":

			// check if submit or not
			if(empty($_REQUEST['submit'])||$_REQUEST['submit']!="start again"){
				$view="RockPaperScissorsWon.php";
				break;
			}

			$_SESSION["RockPaperScissors"] = new RockPaperScissors();
			$_SESSION['state'] = "RockPaperScissors";
			$view="RockPaperScissors.php";
			break;

		case "Frogs":
			$view="Frogs.php";

			// check if submit or not, start again if the button is pressed
			if(empty($_REQUEST['submit'])||$_REQUEST['submit']!="start again"){
				$view="Frogs.php";
			}

			else {
				$_SESSION['Frogs'] = new Frogs();
			}
			
			if (isset($_REQUEST['0_x'])) {
				$_SESSION['Frogs']->makeMove(0);
			}
			if (isset($_REQUEST['1_x'])) {
				$_SESSION['Frogs']->makeMove(1);
			}
			if (isset($_REQUEST['2_x'])) {
				$_SESSION['Frogs']->makeMove(2);
			}
			if (isset($_REQUEST['3_x'])) {
				$_SESSION['Frogs']->makeMove(3);
			}
			if (isset($_REQUEST['4_x'])) {
				$_SESSION['Frogs']->makeMove(4);
			}
			if (isset($_REQUEST['5_x'])) {
				$_SESSION['Frogs']->makeMove(5);
			}
			if (isset($_REQUEST['6_x'])) {
				$_SESSION['Frogs']->makeMove(6);
			}

			if ($_SESSION['Frogs']->hasWon()) {
				$_SESSION['state'] = "FrogsWon";
				$view = "FrogsWon.php";

				// update db if won
				$query = "UPDATE appuser SET frogswins = frogswins + 1 WHERE userid = $1;";
				$result = pg_prepare($dbconn, "", $query);
				$result = pg_execute($dbconn, "", array($_SESSION['userInfo']['userid']));
			}

			break;
		
		case "FrogsWon":

			// the view we display by default
			$view="FrogsWon.php";

			// check if submit or not
			if(empty($_REQUEST['submit'])||$_REQUEST['submit']!="start again"){
				$view="FrogsWon.php";
				break;
			}

			$_SESSION["Frogs"]=new Frogs();
			$_SESSION['state']="Frogs";
			$view="Frogs.php";
			break;
		
		case "Profile":

			// default view
			$view='Profile.php';

			// user feedback
			$_SESSION['profileUpdates'] = '';

			// check token
			if (isset($_REQUEST['token']) && $_REQUEST['token'] != $_SESSION['token']) {
				break;
			}

			if (isset($_REQUEST['submit']) && $_REQUEST['submit'] == 'Update Username') {
				
				// check if username is empty
				if (empty($_REQUEST['newUsername']))$errors[] = '[ERROR] New Username cannot be Blank';

				// cleanse user input
				$_REQUEST['newUsername'] = htmlspecialchars($_REQUEST['newUsername']);

				// check if username is taken
				$query = "SELECT * FROM appuser WHERE userid = $1";
				$result = pg_prepare($dbconn, "", $query);
				$result = pg_execute($dbconn, "", array($_REQUEST['newUsername']));
				if ($row = pg_fetch_array($result, NULL, PGSQL_ASSOC))$errors[]='[ERROR]: Username taken, please choose another username';
				
				if(!empty($errors))break;

				// update db
				$query = "UPDATE appuser SET userid = $1 WHERE userid = $2;";
				$result = pg_prepare($dbconn, "", $query);
				$result = pg_execute($dbconn, "", array($_REQUEST['newUsername'], $_SESSION['userInfo']['userid']));

				// update session and break
				$_SESSION['userInfo']['userid'] = $_REQUEST['newUsername'];
				$_SESSION['profileUpdates'] = 'Successfully Updated Username!';
				break;
			}

			else if (isset($_REQUEST['submit']) && $_REQUEST['submit'] == 'Update Password') {

				// check if fields are empty
				if(empty($_REQUEST['newPassword']))$errors[]='[ERROR]: New password cannot be Blank';
				if(empty($_REQUEST['newPassword2']))$errors[]='[ERROR]: Please enter password twice';

				// cleanse user input
				$_REQUEST['newPassword'] = htmlspecialchars($_REQUEST['newPassword']);
				$_REQUEST['newPassword2'] = htmlspecialchars($_REQUEST['newPassword2']);

				// error check
				if($_REQUEST['newPassword'] != $_REQUEST['newPassword2'])$errors[]='[ERROR]: Passwords must match';
				if(password_verify($_REQUEST['newPassword'], $_SESSION['userInfo']['password']))$errors[] ='[ERROR]: New password cannot be the same as your old password';

				if(!empty($errors))break;
				
				$hashed_password = password_hash($_REQUEST['newPassword'], PASSWORD_BCRYPT);

				// update db
				$query = "UPDATE appuser SET password = $1 WHERE userid = $2;";
				$result = pg_prepare($dbconn, "", $query);
				$result = pg_execute($dbconn, "", array($hashed_password, $_SESSION['userInfo']['userid']));

				// update session and break
				$_SESSION['userInfo']['password'] = $hashed_password;
				$_SESSION['profileUpdates'] = 'Successfully Updated Password!';
				break;
			}

			else if (isset($_REQUEST['submit']) && $_REQUEST['submit'] == 'Update Gender') {

				// error check
				if(empty($_REQUEST['newGender']))$errors[]='[ERROR]: Updated gender must be one of the three options';
				if($_REQUEST['newGender'] == $_SESSION['userInfo']['gender'])$errors[]='[ERROR]: Updated gender must not be the same as your previously chosen gender';

				if(!empty($errors))break;
				
				// update db
				$query = "UPDATE appuser SET gender = $1 WHERE userid = $2;";
				$result = pg_prepare($dbconn, "", $query);
				$result = pg_execute($dbconn, "", array($_REQUEST['newGender'], $_SESSION['userInfo']['userid']));

				// update session and break
				$_SESSION['userInfo']['gender'] = $_REQUEST['newGender'];
				$_SESSION['profileUpdates'] = 'Successfully Updated Gender!';
				break;
			}

			else if (isset($_REQUEST['submit']) && $_REQUEST['submit'] == 'Update Age') {

				// error check
				if(intval($_REQUEST['newAge']) == $_SESSION['userInfo']['age'])$errors[]='[ERROR]: Updated age must not be same as previous age';
				if(!empty($errors))break;
				
				// update db
				$query = "UPDATE appuser SET age = $1 WHERE userid = $2;";
				$result = pg_prepare($dbconn, "", $query);
				$result = pg_execute($dbconn, "", array(intval($_REQUEST['newAge']), $_SESSION['userInfo']['userid']));

				// update session and break
				$_SESSION['userInfo']['age'] = intval($_REQUEST['newAge']);
				$_SESSION['profileUpdates'] = 'Successfully Updated Age!';
				break;
			}

			else if (isset($_REQUEST['submit']) && $_REQUEST['submit'] == 'Update UofT Student Status') {

				// error check
				if(isset($_REQUEST['newStudentStatus']) && $_SESSION['userInfo']['uoftstudent'] == 't')$errors[]='[ERROR]: New Student Status must not be the same as your previous student status';
				if(!isset($_REQUEST['newStudentStatus']) && $_SESSION['userInfo']['uoftstudent'] == 'f')$errors[]='[ERROR]: New Student Status must not be the same as your previous student status';

				if(!empty($errors))break;
				
				// update db
				$query = "UPDATE appuser SET uoftstudent = $1 WHERE userid = $2;";
				$result = pg_prepare($dbconn, "", $query);
				$result = pg_execute($dbconn, "", array((int)isset($_REQUEST['newStudentStatus']), $_SESSION['userInfo']['userid']));

				// update session and break
				if (isset($_REQUEST['newStudentStatus'])) {
					$_SESSION['userInfo']['uoftstudent'] = 't';
				}
				else {
					$_SESSION['userInfo']['uoftstudent'] = 'f';
				}
				$_SESSION['profileUpdates'] = 'Successfully Updated Student Status!';
				break;
			}
			
			else if (isset($_REQUEST['submit']) && $_REQUEST['submit'] == 'Update Pizza Preference') {

				// error check
				if(isset($_REQUEST['newPizzaPref']) && $_SESSION['userInfo']['pizzapref'] == 't')$errors[]='[ERROR]: New Pizza preference must not be the same as your previous pizza preference';
				if(!isset($_REQUEST['newPizzaPref']) && $_SESSION['userInfo']['pizzapref'] == 'f')$errors[]='[ERROR]: New Pizza preference must not be the same as your previous pizza preference';

				if(!empty($errors))break;
				
				// update db
				$query = "UPDATE appuser SET pizzapref = $1 WHERE userid = $2;";
				$result = pg_prepare($dbconn, "", $query);
				$result = pg_execute($dbconn, "", array((int)isset($_REQUEST['newPizzaPref']), $_SESSION['userInfo']['userid']));

				// update session and break
				if (isset($_REQUEST['newPizzaPref'])) {
					$_SESSION['userInfo']['pizzapref'] = 't';
				}
				else {
					$_SESSION['userInfo']['pizzapref'] = 'f';
				}
				$_SESSION['profileUpdates'] = 'Successfully Updated Pizza Preference!';
				break;
			}	

			// reset token and break
			unset($_SESSION['token']);
			break;
	}

	require_once "view/$view";
?>
