<?php // Template for the prediction list?>
	
<table>
	<thead>
		<th>User Name</th>
		<th>Stage</th>
		<th>Team1 Name</th>
		<th>Team2 Name</th>
		<th>Team1 Score</th>
		<th>Team2 Score</th>
		<th>Team1 Prediction</th>
		<th>Team2 Prediction</th>
		<th>Prediction Points</th>
		<th>Edit</th>
	</thead>
	
	<body>
		<?php foreach ($predictions as $prediction): ?>
		<tr>
			<?php // use the getUser method in the prediction entity to return the name of the user?>
			<td><?=$prediction->getUser()->userName?></td>

			<?php // user the getMatch method in the prediction entity to return the stage for the match ?>
			<td><?=$prediction->getMatch()->matchStage;?></td>
			
			<?php // use the getTeam method in the prediction entity to return the name of the team ?>
			<td><?=$prediction->getTeam(1)->teamName;?></td>
			<td><?=$prediction->getTeam(2)->teamName;?></td>
			
			<?php // user the getMatch method in the prediction entity to return the scores for the match ?>
			<td><?=$prediction->getMatch()->team1Score;?></td>
			<td><?=$prediction->getMatch()->team2Score;?></td>
			
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