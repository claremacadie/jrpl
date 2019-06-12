<?php // This creates the form for adding and editing predictions ?>
<?php // Don't change id=, or name= in the input<>, these do not relate to database column titles!?>

<img src="/images/<?=$match->getTeam(1)->teamFlag;?>" height=50 width=50/>
<img src="/images/<?=$match->getTeam(2)->teamFlag;?>" height=50 width=50/>

<form action="" method="post">
	<input 
		type="hidden"
		name="prediction[predictionId]"
		value="<?=$prediction->predictionId ?? ''?>"
	/>
	
	<?php // This passes in the matchId so that it can be used by the addPrediction method to create a prediction with the correct matchId ?>
	<?php // userId doesn't have to be passed in because it is already in the user entity that contains the addPrediction method ?>
	<input 
		type="hidden"
		name="prediction[matchId]"
		value="<?=$match->matchId ?? ''?>"
	/>

	<label for="team1prediction"><?=$match->getTeam(1)->teamName?> Prediction:</label>
	<input 
		type="text"
		id="team1prediction"
		name="prediction[team1Prediction]"
		value="<?=$prediction->team1Prediction ?? ''?>"
	/>
	
	<label for="team2prediction"><?=$match->getTeam(2)->teamName?> Prediction:</label>
	<input 
		type="text"
		id="team2prediction"
		name="prediction[team2Prediction]"
		value="<?=$prediction->team2Prediction ?? ''?>"
	/>
	
	<input
		type="submit"
		name="submit"
		value="Save"
	/>
</form>

<?php // Display the datetime and stage of the match ?>
<td>Date and time of match: <?=$match->matchDateTime;?></td>
<td>Stage: <?=$match->matchStage;?></td>

<?php // Create a carousel to navigate to previous and next match ?>
<?php // The initial if($previousMatch) checks that there is a next match to go to, and only display the link if it exists ?>
<?php if($previousMatch): ?>
	<?php if($previousMatch->getUserPrediction($user->userId)): ?>
		<td><a href ="/prediction/edit?predictionId=<?=$previousMatch->getUserPrediction($user->userId)->predictionId?>">Previous match</a></td>
	<?php else: ?>
		<td><a href ="/prediction/edit?matchId=<?=$previousMatch->matchId?>">Previous match</a></td>
	<?php endif; ?>	
<?php endif; ?>	
<?php // The initial if($nextMatch) checks that there is a next match to go to, and only display the link if it exists ?>
<?php if($nextMatch): ?>
	<?php if($nextMatch->getUserPrediction($user->userId)): ?>
		<td><a href ="/prediction/edit?predictionId=<?=$nextMatch->getUserPrediction($user->userId)->predictionId?>">Next match</a></td>
	<?php else: ?>
		<td><a href ="/prediction/edit?matchId=<?=$nextMatch->matchId?>">Next match</a></td>
	<?php endif; ?>	
<?php endif; ?>	
			