<?php

// This is the team controller

namespace Jrpl\Controllers;

class Team {
	private $teamsTable;
	
	public function __construct(\Ninja\DatabaseTable $teamsTable) {
		$this->teamsTable = $teamsTable;
	}
	
	// If an id is set, this method finds the team in the database and returns it to the form to be edited
	// If no id is set, then the form is blank
	public function edit() {
		if (isset($_GET['teamId'])) {
			$team = $this->teamsTable->findById($_GET['teamId']);
		}
		
		$title = 'Edit Team';
		
		return [
			'template' => 'editteam.html.php',
			'title' =>$title,
			'variables' => [
				'team' => $team ?? null,
				'teamGroup' => $teamGroup ?? null]
		];
	}
	
	// This method uses the DatabaseTable save method to update existing teams and insert new teams
	public function saveEdit() {
		$team = $_POST['team'];
		$this->teamsTable->save($team);
		
		// Redirect browser to team/list webpage
		header('location: /team/list');
		
		// End this program flow to prevent PHP warning in error log
		die();
	}	

	// This method lists the teams and the template enables them to be edited and deleted
	public function list() {
		$teams = $this->teamsTable->findAll();
		$title = 'Teams';
		return [
			'template' => 'teamlist.html.php',
			'title' => $title,
			'variables' => ['teams' => $teams]
		];
	}
			
	// This method enables teams to be deleted
	public function delete() {
		$this->teamsTable->delete($_POST['teamId']);
		
		// redirects the browser to the team/list page
		header('location: /team/list');
		
		// End this program flow to prevent PHP warning in error log
		die();
	}
}