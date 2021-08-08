<?php
	include 'queryStats.php';
	getQuery('guessgamewins');

	// for form resubmissions
	if (!isset($_SESSION['token'])) {
		$_SESSION['token'] = md5(uniqid());
	}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width">
		<link rel="stylesheet" type="text/css" href="style.css" />
		<title>Games</title>
		<style>.GuessGameNavLink{color: black; background-color: white;}</style>
	</head>
	<body>
		<header>
			<?php include 'navbar.php';?>
		</header>
		<main class='mainBody'>
			<section>
				<h1>Guess Game</h1>
				<p>Guess the Secret number in under 3 guess to win!</p>
				<?php
					// So I don't have to deal with uninitialized $_REQUEST['guess']
					$_REQUEST['guess']=!empty($_REQUEST['guess']) ? $_REQUEST['guess'] : '';
				?>
				<?php if($_SESSION["GuessGame"]->getState()!="correct"){ ?>
					<form method="post">
						<input type="text" name="guess" value="<?php echo(htmlentities($_REQUEST['guess'])); ?>" /> 
						<input type="submit" name="submit" value="guess" />
						<input type="hidden" name="token" value="<?php echo($_SESSION['token']); ?>" />
					</form>
				<?php } ?>
			
				<?php echo(view_errors($errors)); ?> 

				<?php 
					foreach($_SESSION['GuessGame']->history as $key=>$value){
						echo("<br/> $value");
					}
					if($_SESSION["GuessGame"]->getState()=="correct"){ 
				?>
						<form method="post">
							<input type="submit" name="submit" value="start again" />
						</form>
				<?php 
					} 
				?>
			</section>
			<section class='stats'>
				<h1>Stats and Top 3 Leaderboard</h1>
				<?php include 'statsBox.php'?>
			</section>
		</main>
		<footer>
			A project by ME
		</footer>
	</body>
</html>

