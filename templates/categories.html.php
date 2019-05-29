<?php //This produces the HTML code to provide a list of categories that can be edited and deleted?>

<h2>Categories</h2>

<a href="/category/edit">Add a new category</a>

<?php foreach ($categories as $category): ?>

	<blockquote>
		<p>
			<?=htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8')?>
			
			<a href="/category/edit?categoryId=<?=$category->categoryId?>">Edit</a>
			
			<form action="/category/delete" method="post"/>
			
				<input
					type="hidden"
					name="categoryId"
					value="<?=$category->categoryId?>"
				/>
				
				<input
					type="submit"
					value="Delete"
				/>
			</form>
		</p>
	</blockquote>
<?php endforeach; ?>