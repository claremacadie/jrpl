<?php //This file creates the html code for the jokes list page on the website?>

<?php //Loop through the categories and create a list with links for each one?>
<div class="jokelist">
	<ul class="categories">
		<li><a href="/joke/list">All jokes</a></li>
		<?php foreach ($categories as $category): ?>
			<li><a href="/joke/list?category=<?=$category->id?>"><?=$category->name?></a></li>
		<?php endforeach; ?>
	</ul>

<?php //Outputs the total number of jokes?>

<div class="jokes">
	<?php if (empty($currentCategory)): ?>
		<p><?=$totalJokes?> jokes in total have been submitted to the Internet Joke Database.</p>
	<?php else: ?>
		<p><?=$totalJokes?> jokes in the <?=$currentCategory->name?> category have been submitted to the Internet Joke Database.</p>
	<?php endif; ?>
	
	<?php //Output a list of jokes with an email link for the author, date (formatted to 1st april 2019), edit link and delete button?>
	<?php foreach ($jokes as $joke): ?>
		<blockquote>
			<?=(new \Ninja\Markdown($joke->jokeText))->toHtml()?>
			(by <a href="mailto:<?php echo htmlspecialchars($joke->getAuthor()->email, ENT_QUOTES, 'UTF-8'); ?>">
			<?=htmlspecialchars($joke->getAuthor()->name, ENT_QUOTES, 'UTF-8'); ?>
			</a> 
			on <?php $date = new DateTime($joke->jokeDate); echo $date->format('jS F Y'); ?>)
			
			<?php //When a user is logged in, if their userId matches the authorId of a joke, ?>
			<?php //Or if the user has permissions to edit or delete jokes, ?>
			<?php //the edit and delete actions are available?>
			<?php //Otherwise, just the joke is listed?>	
			<?php if ($user): ?>
			
				<?php if ($user->id  == $joke->authorId || $user->hasPermission(\Ijdb\Entity\Author::EDIT_JOKES)): ?>
					<a href ="/joke/edit?id=<?=$joke->id?>">
					Edit
					</a>
				<?php endif; ?>
				
				<?php if ($user->id  == $joke->authorId || $user->hasPermission(\Ijdb\Entity\Author::DELETE_JOKES)): ?>
					 <form action="/joke/delete" method="post">
						<input type="hidden" name="id" value="<?=$joke->id?>">
						<input type="submit" value="Delete">
					</form>
				<?php endif; ?>
				
			<?php endif; ?>
				
		</blockquote>
	<?php endforeach; ?>

	Select page:
	
	<?php // Calculate the number of pages (ceil rounds up)
	$numPages = ceil($totalJokes/10);
	
	// Display a link for each page
	// This uses the shorthand if to append &category=$categoryId to the link if it is set (p657)
	for ($i = 1; $i <= $numPages; $i++):
		if ($i == $currentPage):
	?>
			<a class="currentpage" href="/joke/list?page=<?=$i?><?=!empty($currentCategory) ? '&category=' . $currentCategory->id : '' ?>"><?=$i?></a>
			
		<?php else: ?>
			<a href="/joke/list?page=<?=$i?><?=!empty($currentCategory) ? '&category=' . $currentCategory->id : '' ?>"><?=$i?></a>
			
		<?php endif; ?>
	<?php endfor; ?>	
		
</div>













