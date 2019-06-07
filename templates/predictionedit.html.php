<?php // This creates the form for adding and editing matches?>
<?php // Don't change id=, or name= in the input<>, these do not relate to database column titles!?>

<form action="" method="post">
	<input 
		type="hidden"
		name="match[matchId]"
		value="<?=$match->matchId ?? ''?>"
	/>
	
	<label for="team1">Enter team 1:</label>	
	<select id="team1"
		name="match[team1Id]">
		<option value="">--Please choose a team--</option>
		<?php // Create a dropdown list using the teams variable ?>
		<?php foreach ($teams as $team): ?>
			<option value="<?=$team->teamId;?>" <?php if ($match->team1Id == $team->teamId): ?> selected <?php endif; ?>><?=$team->teamName;?></option>
		<?php endforeach; ?>
	</select>

	<label for="team2">Enter team 2:</label>	
	<select id="team2"
		name="match[team2Id]">
		<option value="">--Please choose a team--</option>
		<?php // Create a dropdown list using the teams variable ?>
		<?php foreach ($teams as $team): ?>
			<option value="<?=$team->teamId;?>" <?php if ($match->team2Id == $team->teamId): ?> selected <?php endif; ?>><?=$team->teamName;?></option>
		<?php endforeach; ?>
	</select>
	
	<label for="matchdatetime">Date and Time of Match (yyyy-mm-dd hh:mm:ss):</label>
	<input 
		type="text"
		id="matchdatetime"
		name="match[matchDateTime]"
		value="<?=$match->matchDateTime ?? ''?>"
	/>

	<label for="matchteam1score">Team 1 Score:</label>
	<input 
		type="text"
		id="matchteam1score"
		name="match[team1Score]"
		value="<?=$match->team1Score ?? ''?>"
	/>

	<label for="matchteam2score">Team 2 Score:</label>
	<input 
		type="text"
		id="matchteam2score"
		name="match[team2Score]"
		value="<?=$match->team2Score ?? ''?>"
	/>
	
	<label for="matchstage">Stage</label>
	<input 
		type="text"
		id="matchstage"
		name="match[matchStage]"
		value="<?=$match->matchStage ?? ''?>"
	/>

	<input
		type="submit"
		name="submit"
		value="Save"
	/>
</form>