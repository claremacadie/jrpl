<?php

// This is the group controller

namespace Jrpl\Controllers;

class Group {
	private $groupsTable;
	
	public function __construct(\Ninja\DatabaseTable $groupsTable) {
		$this->groupsTable = $groupsTable;
	}
	
	// If an id is set, this method finds the group in the database and returns it to the form to be edited
	// If no id is set, then the form is blank
	public function edit() {
		if (isset($_GET['groupId'])) {
			$group = $this->groupsTable->findById($_GET['groupId']);
		}
		
		$title = 'Edit Group';
		
		return [
			'template' => 'editgroup.html.php',
			'title' =>$title,
			'variables' => [
				'group' => $group ?? null]
		];
	}
	
	// This method uses the DatabaseTable save method to update existing groups and insert new groups
	public function saveEdit() {
		$group = $_POST['group'];
		$this->groupsTable->save($group);
		
		// Redirect browser to group/list webpage
		header('location: /group/list');
		
		// End this program flow to prevent PHP warning in error log
		die();
	}	

	// This method lists the groups and the template enables them to be edited and deleted
	public function list() {
		$groups = $this->groupsTable->findAll();
		$title = 'Groups';
		return [
			'template' => 'listgroups.html.php',
			'title' => $title,
			'variables' => ['groups' => $groups]
		];
	}
			
	// This method enables groups to be deleted
	public function delete() {
		$this->groupsTable->delete($_POST['groupId']);
		
		// redirects the browser to the group/list page
		header('location: /group/list');
		
		// End this program flow to prevent PHP warning in error log
		die();
	}
}