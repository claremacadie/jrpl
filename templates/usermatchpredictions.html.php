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
			
			<?php // When a user is logged in and if the matchId matches the matchId of a prediction, and ?>
			<?php // the userId matches the userId of a prediction, then the predictions are displayed and can be edited, ?>
			<?php // else 'no prediction' is displayed and a new prediction created ?>	
			<?php if ($user): ?>
				<?php // Use getUserPrediction method on the match entity to return a user's predictions, if they have been submitted ?>
				<?php if($match->getUserPrediction($user->userId)): ?>
					<td><?=$match->getUserPrediction($user->userId)->team1Prediction;?></td>
					<td><?=$match->getUserPrediction($user->userId)->team2Prediction;?></td>
					<td><?=$match->getUserPrediction($user->userId)->userPredictionPoints;?></td>
					<td><a href ="/prediction/edit?predictionId=<?=$match->getUserPrediction($user->userId)->predictionId?>">Edit prediction</a></td>
				<?php else: ?>
						<td>No prediction</td>
						<td>No prediction</td>
						<td>-</td>
						<td><a href ="/prediction/edit?matchId=<?=$match->matchId?>">Add prediction</a></td>
				<?php endif; ?>				
			<?php endif; ?>

		</tr>
		<?php endforeach; ?>
	</body>
</table>