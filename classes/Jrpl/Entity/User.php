<?php

// This file creates an entity class 'user'
// This enables methods to be called on the $user instance, e.g. $user->addPrediction($prediction]);
// For this to work, $user needs to be an object, rather than an array, which is what this file does
// $userName is the title of the column in the database

namespace Jrpl\Entity;

class user {
	public $userId;
	public $userName;
	public $email;
	public $password;
	private $predictionsTable;
	
	// Define the constants for user permissions
	const EDIT_TEAMS = 1;
	const EDIT_MATCHES = 2;
	const EDIT_GROUPS = 4;
	const LIST_PREDICTIONS = 8;
	const EDIT_PREDICTIONS = 16;
	const EDIT_USER_ACCESS = 32;	
	
	// Create a DatabaseTable object called $jpredictionsTable
	public function __construct(\Ninja\DatabaseTable $predictionsTable) {
		$this->predictionsTable = $predictionsTable;
	}
	
	// This method checks if a user has a specific permissions
	public function hasPermission($permission) {
		return $this->permissions & $permission;
	}

	// This method adds predictions to the database using the save method (defined in DatabaseTable)
	// It sets the userId of the prediction to be added as the id of this User class
	// and return enables the value of the save method to be output when this method is used
	public function addPrediction($prediction) {
		$prediction['userId'] = $this->userId;
		return $this->predictionsTable->save($prediction);
	}
}