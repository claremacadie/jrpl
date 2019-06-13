<?php // This creates the form for submitting match scores ?>


<img src="/images/<?=$match->getTeam(1)->teamFlag;?>" height=50 width=50/>
<img src="/images/<?=$match->getTeam(2)->teamFlag;?>" height=50 width=50/>

<form action="" method="post">
	<input 
		type="hidden"
		name="match[matchId]"
		value="<?=$match->matchId ?? ''?>"
	/>
	
	<label for="team1score"><?=$match->getTeam(1)->teamName?> Score:</label>
	<input 
		type="text"
		id="team1score"
		name="match[team1Score]"
		value="<?=$match->team1Score ?? ''?>"
	/>
	
	<label for="team1score"><?=$match->getTeam(2)->teamName?> Score:</label>
	<input 
		type="text"
		id="team2score"
		name="match[team2Score]"
		value="<?=$match->team2Score ?? ''?>"
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