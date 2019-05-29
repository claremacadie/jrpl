<?php // This file produces the html code for a page to edit a user's permissions ?>
<?php // userName is the title of the column in the database?>

<h2>Edit <?=$user->userName?>'s Permissions</h2>

<form action ="" method="post">
	<?php foreach ($permissions as $name => $value):?>
	<div>
		<input 
			name="permissions[]"
			type="checkbox"
			value="<?=$value?>"
			<?php if ($user->hasPermission($value)): echo 'checked';?> 
			<?php endif;?>
		/>
		<label><?=$name?>
	</div>
	<?php endforeach; ?>
	
	<input type="submit" value="Submit" />
</form>