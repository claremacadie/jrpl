<?php

// This is the match controller

namespace Jrpl\Controllers;

class Match {
	private $matchesTable;
	private $teamsTable;
	
	public function __construct(\Ninja\DatabaseTable $matchesTable, \Ninja\DatabaseTable $teamsTable) {
		$this->matchesTable = $matchesTable;
		$this->teamsTable = $teamsTable;
	}
	
	// If an id is set, this method finds the match in the database and returns it to the form to be edited
	// If no id is set, then the form is blank
	public function edit() {
		if (isset($_GET['matchId'])) {
			$match = $this->matchesTable->findById($_GET['matchId']);
		}
		
		// $teams is used on the matchedit.html.php form for a dropdown list
		$teams = $this->teamsTable->findAll();
		
		$title = 'Edit Match';
		
		return [
			'template' => 'matchedit.html.php',
			'title' =>$title,
			'variables' => [
				'match' => $match ?? null,
				'teams' => $teams]
		];
	}
	
	// This method uses the DatabaseTable save method to update existing matches and insert new matches
	public function saveEdit() {
		$match = $_POST['match'];

		// This allows no team, no datetime, no score and no stage to be selected in the match edit page
		if ($match['team1Id'] == '') {
			$match['team1Id'] = null;
		}
		if ($match['team2Id'] == '') {
			$match['team2Id'] = null;
		}
		if ($match['matchDateTime'] == '') {
			$match['matchDateTime'] = null;
		}
		if ($match['team1Score'] == '') {
			$match['team1Score'] = null;
		}
		if ($match['team2Score'] == '') {
			$match['team2Score'] = null;
		}
		if ($match['matchStage'] == '') {
			$match['matchStage'] = null;
		}

		$this->matchesTable->save($match);
		
		// Redirect browser to match/list webpage
		header('location: /match/list');
		
		// End this program flow to prevent PHP warning in error log
		die();
	}	

	// This method lists the matches and the template enables them to be edited and deleted
	public function list() {
		$matches = $this->matchesTable->findAll();
		$title = 'Matches';
		return [
			'template' => 'matchlist.html.php',
			'title' => $title,
			'variables' => ['matches' => $matches]
		];
	}
			
	// This method enables matches to be deleted
	public function delete() {
		$this->matchesTable->delete($_POST['matchId']);
		
		// redirects the browser to the list page
		header('location: /match/list');
		
		// End this program flow to prevent PHP warning in error log
		die();
	}
}