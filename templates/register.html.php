<?php // This file creates the html code for the register page on the website?>

<?php // This outputs the errors if the register form is filled in incorrectly?>
<?php if (!empty($errors)) : ?>
	
	<div class="errors">
		<p>Your account could not be created, please check the following:</p>
		<ul>
		<?php foreach ($errors as $error) : ?>
			<li><?=$error ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
<?php endif; ?>
			

<?php // This creates the form to register users?>
<?php // 'value = ....' this fills the input boxes with the value $user[name/email/password] if set, otherwise leave blank?>
<?php // i.e. when there is an error filling in these boxes, the page reloads with the information filled in that was already entered by the user?>
<form action="" method="post">

	<label for="email">Your email address</label>
	<input name="user[email]" id="email" type="text" value="<?=$user['email'] ?? ''?>">
	

	<label for="name">Your name</label>
	<input name="user[name]" id="name" type="text" value="<?=$user['name'] ?? ''?>">

	<label for="password">Password</label>
	<input name="user[password]" id="password" type="password" value="<?=$user['password'] ?? ''?>">

	<input type="submit" name="submit" value="Register account">

</form>