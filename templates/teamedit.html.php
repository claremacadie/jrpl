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
		
		<option value="">--Please choose a group--</option>
		
		<?php // Create a dropdown list using the group variable ?>
		<?php foreach ($groups as $group): ?>

			<option value="<?=$group->groupId;?>" <?php if ($team->groupId == $group->groupId): ?> selected <?php endif; ?>><?=$group->groupName;?></option>
		<?php endforeach; ?>
	</select>
	
	<input
		type="submit"
		name="submit"
		value="Save"
	/>
</form>