<?php

// This is the prediction controller

namespace Jrpl\Controllers;

class Prediction {
	private $usersTable;
	private $teamsTable;
	private $matchesTable;
	private $predictionsTable;
	private $authentication;
	
	public function __construct(\Ninja\DatabaseTable $usersTable, \Ninja\DatabaseTable $teamsTable, \Ninja\DatabaseTable $matchesTable, \Ninja\DatabaseTable $predictionsTable, \Ninja\Authentication $authentication) {
		$this->usersTable = $usersTable;
		$this->teamsTable = $teamsTable;
		$this->matchesTable = $matchesTable;
		$this->predictionsTable = $predictionsTable;
		$this->authentication = $authentication;
	}
	
	// If an id is set, this method finds the prediction in the database and returns it to the form to be edited
	// If no id is set, then the form is blank
	public function edit() {

		// Set $user to the logged in user
		$user = $this->authentication->getUser();
		 
		// Set $matches to be the list of all matches
		$matches = $this->matchesTable->findAll();

		if (isset($_GET['predictionId'])) {
			$prediction = $this->predictionsTable->findById($_GET['predictionId']);
			$match = $prediction->getMatch();
		}
		
		if (isset($_GET['matchId'])) {
			$match = $this->matchesTable->findById($_GET['matchId']);
		}
		
		// Set $nextMatch for the carousel on the predictionedit page to navigate to the next match in order of matchDateTime
		$nextMatch = $this->matchesTable->findNextRecord($match, 'matchDateTime');
		
		// Set $previousMatch for the carousel on the predictionedit page to navigate to the previous match in order of matchDateTime
		$previousMatch = $this->matchesTable->findPreviousRecord($match, 'matchDateTime');
		
		$title = 'Edit Prediction';
		
		return [
			'template' => 'predictionedit.html.php',
			'title' =>$title,
			'variables' => [
				'user' => $user,
				'match' => $match,
				'nextMatch' => $nextMatch,
				'previousMatch' => $previousMatch,
				'matches' => $matches,
				'prediction' => $prediction ?? null]
		];
	}
	
	// This method uses the DatabaseTable save method to update existing predictions and insert new predictions
	public function saveEdit() {
		$prediction = $_POST['prediction'];

		//Set $user to the logged in user
		$user = $this->authentication->getUser();

		// This uses the addPrediction method in the user entity to add the prediction to the database
		// As a by-product, this converts the $prediction array created by the edit page into an entity
		// This prediction entity can then be used in the redirect URL below
		$prediction = $user->addPrediction($prediction);
		
		// Redirect browser to display prediction edit page again
		header('location: /prediction/edit?predictionId=' . $prediction->predictionId);
		
		// End this program flow to prevent PHP warning in error log
		die();
	}	

	// This method lists all the matches, ordered by matchDateTime, with the logged in user's predictions
	public function usermatchpredictions() {

		// Get all the matches 
		$matches = $this->matchesTable->findAll('matchDateTime');
		
		// Get the currently logged in user
		$user = $this->authentication->getUser();
		
		$title = 'User match predictions';
		return [
			'template' => 'usermatchpredictions.html.php',
			'title' => $title,
			'variables' => [
				'user' => $user,
				'matches' => $matches]
		];
	}
			
	// This method lists the predictions and the template enables them to be edited and deleted
	public function list() {
		$predictions = $this->predictionsTable->findAll();
		
		$title = 'Predictions list';
		return [
			'template' => 'predictionlist.html.php',
			'title' => $title,
			'variables' => [
				'predictions' => $predictions]
		];
	}
			
	// This method enables predictions to be deleted
	public function delete() {
		$this->predictionsTable->delete($_POST['predictionId']);
		
		// redirects the browser to the list page
		header('location: /prediction/list');
		
		// End this program flow to prevent PHP warning in error log
		die();
	}
}