<?php // Template for the prediction list?>

<?php // use the getUser method in the prediction entity to return the name of the user ?>
<h2><?=$user->userName?>'s Predictions</h2>
	
<table>
	<thead>
		<th>Stage</th>
		<th>Team1 Flag</th>
		<th>Team1 Name</th>
		<th>Team2 Name</th>
		<th>Team2 Flag</th>
		<th>Match Datetime</th>
		<th>Team1 Score</th>
		<th>Team2 Score</th>
		<th>Team1 Prediction</th>
		<th>Team2 Prediction</th>
		<th>Prediction Points</th>
		<th>Edit</th>
	</thead>
	
	<body>
	<?php foreach ($matches as $match): ?>
		<tr>
			<td><?=$match->matchStage;?></td>

			<?php // use the getTeam method in the match entity to return the name of the team ?>
			<td><img src="/images/<?=$match->getTeam(1)->teamFlag;?>" height=50 width=50/></td>
			<td><?=$match->getTeam(1)->teamName;?></td>
			<td><?=$match->getTeam(2)->teamName;?></td>
			<td><img src="/images/<?=$match->getTeam(2)->teamFlag;?>" height=50 width=50/></td>
			
			<td><?=$match->matchDateTime;?></td>
			<td><?=$match->team1Score;?></td>
			<td><?=$match->team2Score;?></td>
			
			<td><?=$prediction->team1Prediction;?></td>
			<td><?=$prediction->team2Prediction;?></td>
			<td><?=$prediction->userPredictionPoints;?></td>

			<td>
				<a href ="/prediction/edit?predictionId=<?=$prediction->predictionId?>">Edit</a>
			</td>
			<td>
				<form action="/prediction/delete" method="post">
					<input type="hidden" name="predictionId" value="<?=$prediction->predictionId?>">
					<input type="submit" value="Delete">
				</form>
			</td>
		</tr>
		<?php endforeach; ?>
	</body>
</table>