<?php
		// get wins
		$query = "SELECT * FROM appuser WHERE userid=$1";
		$result = pg_prepare($dbconn, "", $query);
		$result = pg_execute($dbconn, "", array($_SESSION['userInfo']['userid']));
		$row = pg_fetch_array($result, NULL, PGSQL_ASSOC);
		$guessGamesWins = $row['guessgamewins'];
		$rockPaperScissorsWins = $row['rockpaperscissorswins'];
		$frogsWins = $row['frogswins'];
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width">
		<link rel="stylesheet" type="text/css" href="style.css" />
		<style>.AllStatsNavLink{color: black; background-color: white;}</style>
		<title>Games</title>
	</head>
	<body>
		<header>
			<?php include 'navbar.php';?>
		</header>
		<main class='mainBody'>
			<section>
				<h1>Stats By Game</h1>
				<table>
					<tr>
						<td>
							Guess Game Wins:	
						</td>
						<td>
							<?php echo $guessGamesWins?>
						</td>
					</tr>
					<tr>
						<td>
							Rock Paper Scissors Wins:	
						</td>
						<td>
							<?php echo $rockPaperScissorsWins?>
						</td>
					</tr>
					<tr>
						<td>
							Frogs Wins:	
						</td>
						<td>
							<?php echo $frogsWins?>
						</td>
					</tr>
				</table>
			</section>
			<section class='stats'>
				<h1>Summary Stats</h1>
				Your total wins: <?php echo $guessGamesWins + $rockPaperScissorsWins + $frogsWins?>
			</section>
		</main>
		<footer>
			A project by ME
		</footer>
	</body>
</html>

