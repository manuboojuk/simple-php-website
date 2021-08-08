<?php
	include 'queryStats.php';
	getQuery('frogswins');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width">
		<link rel="stylesheet" type="text/css" href="style.css" />
		<style>.FrogsNavLink{color: black; background-color: white;}</style>
		<title>Games</title>
	</head>
	<body>
		<header>
			<?php include 'navbar.php';?>
		</header>
		<main class='mainBody'>
			<section>
				<h1>Welcome to Frogs</h1>
				<p>Solve the Frogs puzzle to win! Remember, starting over counts as a loss!</p>
				<?php
					function getImg($index) {
						if ($_SESSION['Frogs']->frogPond[$index] == 0) {
							echo "view/yellowFrog.gif";
						}
						else if ($_SESSION['Frogs']->frogPond[$index] == 1) {
							echo "view/greenFrog.gif";
						}
						else {
							echo "view/empty.gif";
						}
					}
				?>
				<form method="post">
					<div class="frogsLayout">
						<div><input type="image" name="0" value=<?php echo $_SESSION['Frogs']->frogPond[0]?> src="<?php getImg(0)?>" width="50" height="50" alt="submit"></div>
						<div><input type="image" name="1" value=<?php echo $_SESSION['Frogs']->frogPond[1]?> src="<?php getImg(1)?>" width="50" height="50" alt="submit"></div>
						<div><input type="image" name="2" value=<?php echo $_SESSION['Frogs']->frogPond[2]?> src="<?php getImg(2)?>" width="50" height="50" alt="submit"></div>
						<div><input type="image" name="3" value=<?php echo $_SESSION['Frogs']->frogPond[3]?> src="<?php getImg(3)?>" width="50" height="50" alt="submit"></div>
						<div><input type="image" name="4" value=<?php echo $_SESSION['Frogs']->frogPond[4]?> src="<?php getImg(4)?>" width="50" height="50" alt="submit"></div>
						<div><input type="image" name="5" value=<?php echo $_SESSION['Frogs']->frogPond[5]?> src="<?php getImg(5)?>" width="50" height="50" alt="submit"></div>
						<div><input type="image" name="6" value=<?php echo $_SESSION['Frogs']->frogPond[6]?> src="<?php getImg(6)?>" width="50" height="50" alt="submit"></div>
					</div>
				</form>
				<form action="index.php" method="post">
					<input type="submit" name="submit" value="start again">
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

