<?php // This creates the form for adding and editing teams?>
<?php // Don't change id=, or name= in the input<>, these do not relate to database column titles!?>

<form action="" method="post">
	<input 
		type="hidden"
		name="team[teamId]"
		value="<?=$team->teamId ?? ''?>"
	/>
	
	<label for="teamname">Enter team name:</label>
	
	<input 
		type="text"
		id="teamname"
		name="team[teamName]"
		value="<?=$team->teamName ?? ''?>"
	/>

	<label for="groupname">Enter group:</label>
	
	<input 
		type="text"
		id="groupname"
		name="team[teamGroup]"
		value="<?=$team->teamGroup ?? ''?>"
	/>
	
	<input
		type="submit"
		name="submit"
		value="Save"
	/>
</form>