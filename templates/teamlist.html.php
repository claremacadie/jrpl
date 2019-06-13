<?php // Template for the team list?>
<?php // $team->teamName, teamName is the title of the column in the database?>

<h2>Team List</h2>

<a href="/team/edit">Add team</a>

<table>
	<thead>
		<th>Flag</th>
		<th>Name</th>
		<th>Group</th>
		<th>Flag filename</th>
		<th>Edit</th>
	</thead>
	
	<body>
		<?php foreach ($teams as $team): ?>
		<tr>
			<td><img src="/images/<?=$team->teamFlag;?>" height=50 width=50/></td>
			<td><?=$team->teamName;?></td>
			
			<?php // use the getGroup method in the team entity to return the name of the group ?>
			<td><?=$team->getGroup()->groupName;?></td>

			<td><?=$team->teamFlag;?></td>
			
			<td><a href ="/team/edit?teamId=<?=$team->teamId?>">Edit</a></td>
			
			<td>
				<form action="/team/delete" method="post">
					<input type="hidden" name="teamId" value="<?=$team->teamId?>">
					<input type="submit" value="Delete">
				</form>
			</td>
		</tr>
		<?php endforeach; ?>
	</body>
</table>