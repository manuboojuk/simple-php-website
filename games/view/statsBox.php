<table>
    <tr>
        <td>
            #1:	
        </td>
        <td>
            <?php echo $leaderboard[0]?>
        </td>
        <td>
            <?php if ($leaderboard[0] != "vacant")echo '=====>';?>
        </td>
        <td>
            <?php if ($leaderboard[0] != "vacant")echo $leaderboardScores[0];?>
        </td>
        <td>
            <?php if ($leaderboard[0] != "vacant")echo 'Wins';?>
        </td>
    </tr>
    <tr>
        <td>
            #2:	
        </td>
        <td>
            <?php echo $leaderboard[1]?>
        </td>
        <td>
            <?php if ($leaderboard[1] != "vacant")echo '=====>';?>
        </td>
        <td>
            <?php if ($leaderboard[1] != "vacant")echo $leaderboardScores[1];?>
        </td>
        <td>
            <?php if ($leaderboard[1] != "vacant")echo 'Wins';?>
        </td>
    </tr>
    <tr>
        <td>
            #3:	
        </td>
        <td>
            <?php echo $leaderboard[2]?>
        </td>
        <td>
            <?php if ($leaderboard[2] != "vacant")echo '=====>';?>
        </td>
        <td>
            <?php if ($leaderboard[2] != "vacant")echo $leaderboardScores[2];?>
        </td>
        <td>
            <?php if ($leaderboard[2] != "vacant")echo 'Wins';?>
        </td>
    </tr>
</table>