<?php
// This creates a Team entity class and its methods are available to team objects

namespace Jrpl\Entity;

class Team {
	public $id;
	private $matchesTable;
	private $predictionsTable;
	
	public function __construct(\Ninja\DatabaseTable $teamsTable, \Ninja\DatabaseTable $predictionsTable) {
		$this->teamssTable = $teamsTable;
		$this->predictionsTable = $predictionsTable;
	}
	
	// This method returns the teams for the current match
	public function getTeams() {
		if (empty($this->team)) {
			$this->team = $this->teamsTable->findById($this->teamId);
		}
		return $this->team;
	}
	
	// This method determines whether a joke has a category assigned
	// It loops through the categories and checks to see if each one matches a given $categoryId
	/*public function hasCategory($categoryId) {
		$jokeCategories = $this->jokeCategoriesTable->find('jokeId', $this->id);
		foreach ($jokeCategories as $jokeCategory) {
			if ($jokeCategory->categoryId == $categoryId) {
				return true;
			}
		}
	}*/
	
	// This method removes all category assignments for a particular joke from the joke_category table
	// This is used to clear all categories before adding categories back in when editing jokes
	// (it's easier than looping through each category to see if it is checked and unchecking if needed)
	/*public function clearCategories() {
		$this->jokeCategoriesTable->deleteWhere('jokeId', $this->id);
	}*/	
}