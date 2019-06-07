<?php

// This is the prediction controller

namespace Jrpl\Controllers;

class Prediction {
	private $usersTable;
	private $teamsTable;
	private $matchesTable;
	private $predictionsTable;
	
	public function __construct(\Ninja\DatabaseTable $usersTable, \Ninja\DatabaseTable $teamsTable, \Ninja\DatabaseTable $matchesTable, \Ninja\DatabaseTable $predictionsTable) {
		$this->usersTable = $usersTable;
		$this->teamsTable = $teamsTable;
		$this->matchesTable = $matchesTable;
		$this->predictionsTable = $predictionsTable;
	}
	
	// If an id is set, this method finds the prediction in the database and returns it to the form to be edited
	// If no id is set, then the form is blank
	public function edit() {
		if (isset($_GET['predictionId'])) {
			$prediction = $this->predictionsTable->findById($_GET['predictionId']);
		}
		
		// $teams is used on the predictionedit.html.php form for a dropdown list
		$teams = $this->teamsTable->findAll();
		
		$title = 'Edit Match';
		
		return [
			'template' => 'predictionedit.html.php',
			'title' =>$title,
			'variables' => [
				'prediction' => $prediction ?? null,
				'teams' => $teams]
		];
	}
	
	// This method uses the DatabaseTable save method to update existing predictions and insert new predictions
	public function saveEdit() {
		$prediction = $_POST['prediction'];

		// This allows no team to be selected in the prediction edit page
		if ($prediction['team1Id'] == '') {
			$prediction['team1Id'] = null;
		}
		if ($prediction['team2Id'] == '') {
			$prediction['team2Id'] = null;
		}

		$this->predictionsTable->save($prediction);
		
		// Redirect browser to prediction/list webpage
		header('location: /prediction/list');
		
		// End this program flow to prevent PHP warning in error log
		die();
	}	

	// This method lists the predictions and the template enables them to be edited and deleted
	public function list() {
		$predictions = $this->predictionsTable->findAll();
		
		// $teams is used on the predictionlist.html.php to get team names using the prediction entity
		$teams = $this->teamsTable->findAll();
		
		$title = 'Predictions';
		return [
			'template' => 'predictionlist.html.php',
			'title' => $title,
			'variables' => [
				'predictions' => $predictions,
				'teams' => $teams]
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