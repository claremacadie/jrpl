<?php

// This file creates an entity class 'user'
// This enables methods to be called on the $user instance, e.g. $user->addJoke($joke);
// For this to work, $user needs to be an object, rather than an array, which is what this file does
// $userName is the title of the column in the database

namespace Jrpl\Entity;

class user {
	public $userId;
	public $userName;
	public $email;
	public $password;
	private $jokesTable;
	
	//Define the constants for user permissions
	const EDIT_JOKES = 1;
	const DELETE_JOKES = 2;
	const LIST_CATEGORIES = 4;
	const EDIT_CATEGORIES = 8;
	const REMOVE_CATEGORIES = 16;
	const EDIT_USER_ACCESS = 32;	
	
	//Create a DatabaseTable object called $jokesTable
	public function __construct(\Ninja\DatabaseTable $jokesTable) {
		$this->jokesTable = $jokesTable;
	}
	
	//This method retrieves jokes from the database where the userId matches the userId of this user class
	public function getJokes() {
		return $this->jokesTable->find('userId', $this->userId);
	}
	
	//This method adds jokes to the database using the save method (defined in DatabaseTable)
	//It sets the userId of the joke to be added as the userId of this user class
	//and return enables the value of the save method to be output when this method is used
	public function addJoke($joke) {
		$joke['userId'] = $this->userId;
		return $this->jokesTable->save($joke);
	}
	
	//This method checks if a user has a specific permissions
	public function hasPermission($permission) {
		return $this->permissions & $permission;
	}
}