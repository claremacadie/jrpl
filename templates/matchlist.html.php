<?php // Template for the match list?>

<h2>Match List</h2>

<table>
	<thread>
		<th>Team1 Name</th>
		<th>Team2 Name</th>
		<th>DateTime</th>
		<th>Team1 Score</th>
		<th>Team2 Score</th>
		<th>Stage</th>
		<th>Edit</th>
	</thread>
	
	<body>
		<?php foreach ($matches as $match): ?>
		<tr>
			<?php // use the getTeam method in the match entity to return the name of the team ?>
			<td><?=$match->getTeam(1)->teamName;?></td>
			<td><?=$match->getTeam(2)->teamName;?></td>
			
			<td><?=$match->matchDateTime;?></td>
			<td><?=$match->team1Score;?></td>
			<td><?=$match->team2Score;?></td>
			<td><?=$match->matchStage;?></td>

			<td>
				<a href ="/match/edit?matchId=<?=$match->matchId?>">Edit</a>
			</td>
			<td>
				<form action="/match/delete" method="post">
					<input type="hidden" name="matchId" value="<?=$match->matchId?>">
					<input type="submit" value="Delete">
				</form>
			</td>
		</tr>
		<?php endforeach; ?>
	</body>
</table>