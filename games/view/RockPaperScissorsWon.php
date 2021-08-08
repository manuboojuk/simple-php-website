<?php
	include 'queryStats.php';
	getQuery('rockpaperscissorswins');
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
                <p>We have a winner!</p>
		        <?php echo(view_errors($errors)); ?>
                <?php 
                    foreach($_SESSION['RockPaperScissors']->history as $key=>$value){
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

