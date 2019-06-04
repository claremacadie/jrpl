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
	
	<select id="groupname"
		name="team[groupId]">
		
		<?php // If a group is already entered for the team, display this in the dropdown, otherwise display 'Please choose...' ?>
		<?php if (isset($team->groupId)): ?>
			<option value="<?=$team->groupId;?>"><?=$team->getGroup()->groupName;?></option>
		<?php else: ?>		
			<option value="">--Please choose a group--</option>
		<?php endif;?>
		
		<?php // Create a dropdown list using the group variable ?>
		<?php foreach ($groups as $group): ?>
			<option value="<?=$group->groupId;?>"><?=$group->groupName;?></option>
		<?php endforeach; ?>
	</select>
	
	<input
		type="submit"
		name="submit"
		value="Save"
	/>
</form>