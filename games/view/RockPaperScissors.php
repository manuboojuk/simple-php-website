<?php
	include 'queryStats.php';
	getQuery('rockpaperscissorswins');

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
		<style>.RockPaperScissorsNavLink{color: black; background-color: white;}</style>
		<title>Games</title>
	</head>
	<body>
		<header>
			<?php include 'navbar.php';?>
		</header>
		<main class='mainBody'>
			<section>

				<h1>Welcome to Rock Paper Scissors</h1>
				<p>Human vs Machine, First to win 5 rounds wins the game!</p>
				
				<?php if(!$_SESSION["RockPaperScissors"]->isGameOver()){ ?>
					<form method="post">
						<input type="submit" name="choice" value="Rock"/>
						<input type="submit" name="choice" value="Paper"/>
						<input type="submit" name="choice" value="Scissors"/>
						<input type="hidden" name="token" value="<?php echo($_SESSION['token']); ?>" />
					</form>
				<?php } ?>
		
				<?php echo(view_errors($errors)); ?> 

				<?php 
					foreach($_SESSION['RockPaperScissors']->history as $key=>$value){
						echo("<br/> $value");
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

