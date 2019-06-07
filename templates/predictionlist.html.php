<?php // Template for the prediction list?>

<h2>Prediction List</h2>

<table>
	<thread>
		<th>User Name</th>
		<th>Team1 Name</th>
		<th>Team2 Name</th>
		<th>Team1 Prediction</th>
		<th>Team2 Prediction</th>
		<th>Prediction Points</th>
		<th>Edit</th>
	</thread>
	
	<body>
		<?php foreach ($predictions as $prediction): ?>
		<tr>
			<?php // use the getUser method in the prediction entity to return the name of the user ?>
			<td><?=$prediction->getUser()->userName;?></td>
		
			<?php // use the getTeam method in the prediction entity to return the name of the team ?>
			<td><?=$prediction->getTeam(1)->teamName;?></td>
			<td><?=$prediction->getTeam(2)->teamName;?></td>
			
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