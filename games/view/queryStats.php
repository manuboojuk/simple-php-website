<?php

	// default values if leaderboard spots are vacant
	$leaderboard = array();
	$leaderboardScores = array();
	$leaderboard[] = "vacant";
	$leaderboard[] = "vacant";
	$leaderboard[] = "vacant";

	function getQuery($game) {

		// get top 3 players
		$query = 'SELECT * FROM appuser ORDER BY '.$game.' DESC LIMIT 3;';
		$result = pg_prepare($GLOBALS['dbconn'], "", $query);
		$result = pg_execute($GLOBALS['dbconn'], "", array());
		$row = pg_fetch_all($result, PGSQL_ASSOC);

		$i = 0;
		foreach ($row as $key=>$value) {
			$GLOBALS['leaderboard'][$i] = $value['userid'];
			$GLOBALS['leaderboardScores'][$i] = $value[$game];
			$i++;
		}
	}
?>