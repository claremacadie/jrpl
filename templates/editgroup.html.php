<?php // This creates the form for adding and editing groups?>
<?php // Don't change id=, or name= in the input<>, these do not relate to database column titles!?>

<form action="" method="post">
	<input 
		type="hidden"
		name="group[groupId]"
		value="<?=$group->groupId ?? ''?>"
	/>
	
	<label for="groupname">Enter group name:</label>
	
	<input 
		type="text"
		id="groupname"
		name="group[groupName]"
		value="<?=$group->groupName ?? ''?>"
	/>

	<input
		type="submit"
		name="submit"
		value="Save"
	/>
</form>