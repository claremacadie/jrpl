<?php // doctype html?>
<?php // This files sets the layout for the jrpl website using the jrpl.css file?>
<?php // Make sure jrpl.css is in the same directory as index.php?>
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
				<li><a href="/team/list">Teams list</a></li>
				<li><a href="/group/list">Groups list</a></li>
				<li><a href="/match/list">Match list</a></li>
				<li><a href="/prediction/usermatchpredictions">Fixtures</a></li>
					
				<?php // Administer teams, matches and predictions are only shown if logged in user has permission to edit these?>
				<?php // This displays a logout option when a user is logged in and and login option when they are not logged in?>
				<?php if ($loggedIn): ?>
					
					<?php if ($user->hasPermission(\Jrpl\Entity\user::EDIT_TEAMS)): ?>
						<li><a href="/team/edit">Add team</a></li>
					<?php endif; ?>
					
					<?php if ($user->hasPermission(\Jrpl\Entity\user::EDIT_GROUPS)): ?>
						<li><a href="/group/edit">Add group</a></li>
					<?php endif; ?>
					
					<?php if ($user->hasPermission(\Jrpl\Entity\user::EDIT_MATCHES)): ?>
						<li><a href="/match/edit">Add match</a></li>
					<?php endif; ?>
					
					<?php if ($user->hasPermission(\Jrpl\Entity\user::LIST_PREDICTIONS)): ?>
						<li><a href="/prediction/list">List predictions</a></li>
					<?php endif; ?>
					
					<?php if ($user->hasPermission(\Jrpl\Entity\user::EDIT_USER_ACCESS)): ?>
						<li><a href="/user/list">Administer users</a></li>
					<?php endif; ?>
											
					<li><a href="/logout">Log out</a></li>
					
				<?php else: ?>
					<li><a href="/login">Log in or Register new user</a></li>
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