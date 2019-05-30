<?php // This creates the form for adding and editing categories of jokes?>
<?php // Don't change id=, or name= in the input<>, these do not relate to database column titles!?>

<form action="" method="post">
	<input 
		type="hidden"
		name="category[categoryId]"
		value="<?=$category->categoryId ?? ''?>"
	/>
	
	<label for="categoryname">Enter category name:</label>
	
	<input 
		type="text"
		id="categoryname"
		name="category[categoryName]"
		value="<?=$category->categoryName ?? ''?>"
	/>
	
	<input
		type="submit"
		name="submit"
		value="Save"
	/>
</form>