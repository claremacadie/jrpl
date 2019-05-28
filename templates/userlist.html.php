<?php // Template for the user list?>

<h2>User List</h2>

<table>
	<thread>
		<th>Name</th>
		<th>Email</th>
		<th>Edit</th>
	</thread>
	
	<body>
		<?php foreach ($users as $user): ?>
		<tr>
			<td><?=$user->username;?></td>
			<td><?=$user->email;?></td>
			<td>
				<a href="/user/permissions?id=<?=$user->id;?>">Edit Permissions</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</body>
</table>