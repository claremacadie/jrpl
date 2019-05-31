<?php // Template for the group list?>
<?php // $group->groupName, groupName is the title of the column in the database?>

<h2>Team List</h2>

<table>
	<thread>
		<th>Group Name</th>
		<th>Edit</th>
	</thread>
	
	<body>
		<?php foreach ($groups as $group): ?>
		<tr>
			<td><?=$group->groupName;?></td>
			<td>
				<a href ="/group/edit?groupId=<?=$group->groupId?>">Edit</a>
			</td>
			<td>
				<form action="/group/delete" method="post">
					<input type="hidden" name="groupId" value="<?=$group->groupId?>">
					<input type="submit" value="Delete">
				</form>
			</td>
		</tr>
		<?php endforeach; ?>
	</body>
</table>