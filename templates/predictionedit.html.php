<?php // This creates the form for adding and editing predictions?>
<?php // Don't change id=, or name= in the input<>, these do not relate to database column titles!?>

<form action="" method="post">
	<input 
		type="hidden"
		name="prediction[predictionId]"
		value="<?=$prediction->predictionId ?? ''?>"
	/>
	<h2><?=$prediction->getUser()->userName?>'s Predictions</h2>
	<label for="team1prediction"><?=$prediction->getTeam(1)->teamName?> Prediction:</label>
	<input 
		type="text"
		id="team1prediction"
		name="prediction[team1Prediction]"
		value="<?=$prediction->team1Prediction ?? ''?>"
	/>

	<label for="team2prediction"><?=$prediction->getTeam(2)->teamName?> Prediction:</label>
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