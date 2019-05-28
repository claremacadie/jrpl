<?php

// This file creates an entity class 'User'
// This enables methods to be called on the $user instance, e.g. $user->addPrediction($prediction);
// For this to work, $user needs to be an object, rather than an array, which is what this file does

namespace Jrpl\Entity;

class User {
	public $id;
	public $name;
	public $email;
	public $password;
	private $matchesTable;
	
	// Define the constants for user permissions
	const EDIT_TEAMS = 1;
	const DELETE_TEAMS = 2;
	const LIST_MATCHES = 4;
	const EDIT_MATCHES = 8;
	const REMOVE_MATCHES = 16;
	const EDIT_USER_ACCESS = 32;	
	
	// Create a DatabaseTable object called $matchesTable
	public function __construct(\Ninja\DatabaseTable $matchesTable) {
		$this->matchesTable = matchesTable;
	}
	
	// This method retrieves jokes from the database where the userId matches the id of this Prediction class
	public function getPredictions() {
		return $this->predictionsTable->find('userId', $this->id);
	}
	
	// This method adds predictions to the database using the save method (defined in DatabaseTable)
	// It sets the userId of the prediction to be added as the id of this User class
	// and return enables the value of the save method to be output when this method is used
	public function addPrediction($prediction) {
		$prediction['userId'] = $this->id;
		return $this->predictionsTable->save($prediction);
	}
	
	// This method checks if a user has a specific permissions
	public function hasPermission($permission) {
		return $this->permissions & $permission;
	}
}