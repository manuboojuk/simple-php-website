<?php
	include 'queryStats.php';
	getQuery('guessgamewins');
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
				<?php echo(view_errors($errors)); ?>
				<?php 
					foreach($_SESSION['GuessGame']->history as $key=>$value){
						echo("<br/> $value");
					}
				?>
				<form method="post">
					<input type="submit" name="submit" value="start again" />
				</form>		
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


