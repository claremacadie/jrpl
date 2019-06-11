<?php // This creates the form for adding and editing predictions?>
<?php // Don't change id=, or name= in the input<>, these do not relate to database column titles!?>

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