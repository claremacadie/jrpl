<?php // doctype html?>
<?php // This files sets the layout for the jokedatabase website using the jokes.css file?>
<?php // Make sure jokes.css is in the same directory as index.php?>
<html>
	<head>
	  <meta charset="utf-8">
	  <link rel="stylesheet" href="/jrpl.css">
	  <title><?=$title?></title>
	</head>
	<body> 
		<header>
			<h1> Julian Rimet Prediction League</h1>
		</header>
		<nav>
			<ul>
				<li><a href="/">Home</a></li>
				<li><a href="/joke/list">Jokes list</a></li>
				<li><a href="/joke/edit">Add a new joke</a></li>
				<li><a href="/team/list">Teams list</a></li>
				<li><a href="/team/edit">Add a new team</a></li>
				<li><a href="/group/list">Groups list</a></li>
				<li><a href="/group/edit">Add a new group</a></li>
				<li><a href="/match/list">Matches list</a></li>
				<li><a href="/match/edit">Add a new match</a></li>
					
				<?php // This displays a logout option when a user is logged in and and login option when they are not logged in?>
				<?php // Administer categories and users is only shown if logged in user has permission to edit these?>
				<?php if ($loggedIn): ?>
					
					<?php if ($user->hasPermission(\Jrpl\Entity\user::EDIT_CATEGORIES)): ?>
						<li><a href="/category/list">Administer categories</a></li>
					<?php endif; ?>
					
					<?php if ($user->hasPermission(\Jrpl\Entity\user::EDIT_USER_ACCESS)): ?>
						<li><a href="/user/list">Administer users</a></li>
					<?php endif; ?>
											
					<li><a href="/logout">Log out</a></li>
					
				<?php else: ?>
					<li><a href="/login">Log in</a></li>
				<?php endif; ?>
	
			</ul>
		</nav>
		
		<main>
			<?=$output?>
		</main>
		
		<footer>
			&copy; JRPL 2019
		</footer>	
	</body>

</html>