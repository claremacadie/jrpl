<?php // Template for the match list?>

<h2>Match list</h2>
<a href="/match/edit">Add match</a>

<table>
	<thead>
		<th>Edit match details</th>
		<th>Team1 Flag</th>
		<th>Team1 Name</th>
		<th>Team2 Name</th>
		<th>Team2 Flag</th>
		<th>Stage</th>
		<th>DateTime</th>
		<th>Team1 Score</th>
		<th>Team2 Score</th>
		<th>Submit match score</th>
	</thead>
	
	<body>
		<?php foreach ($matches as $match): ?>
		<tr>
			<td>
				<a href ="/match/edit?matchId=<?=$match->matchId?>">Edit</a>
			</td>
			
			<?php // use the getTeam method in the match entity to return the name of the team ?>
			<td><img src="/images/<?=$match->getTeam(1)->teamFlag;?>" height=50 width=50/></td>
			<td><?=$match->getTeam(1)->teamName;?></td>
			<td><?=$match->getTeam(2)->teamName;?></td>
			<td><img src="/images/<?=$match->getTeam(2)->teamFlag;?>" height=50 width=50/></td>
			
			<td><?=$match->matchStage;?></td>
			<td><?=$match->matchDateTime;?></td>
			
			<td><?=$match->team1Score;?></td>
			<td><?=$match->team2Score;?></td>

			<td>
				<a href ="/match/score?matchId=<?=$match->matchId?>">Submit Score</a>
			</td>
			
			<td>
				<form action="/match/delete" method="post">
					<input type="hidden" name="matchId" value="<?=$match->matchId?>">
					<input type="submit" value="Delete match">
				</form>
			</td>
		</tr>
		<?php endforeach; ?>
	</body>
</table>