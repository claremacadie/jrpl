<?php
// This creates a team entity class and its methods are available to team objects

namespace Jrpl\Entity;

class Prediction {
	public $predictionId;
	public $userId;
	public $matchId;
	public $team1Prediction;
	public $team2Prediction;
	public $userMatchPoints;
	private $usersTable;
	private $teamsTable;
	private $matchesTable;
	private $user;
	private $match;

	public function __construct(\Ninja\DatabaseTable $usersTable, \Ninja\DatabaseTable $teamsTable, \Ninja\DatabaseTable $matchesTable) {
		$this->usersTable = $usersTable;
		$this->teamsTable = $teamsTable;
		$this->matchesTable = $matchesTable;
	}
	
	// This method returns team 1 or 2 for the current match
	public function getTeam($teamNumber) {
		if (empty($this->match)) {
			$this->match = $this->matchesTable->findById($this->matchId);
		}
		return $this->match->getTeam($teamNumber);
	}	

	// This method returns the user for the current prediction
	public function getUser() {
		if (empty($this->user)) {
			$this->user = $this->usersTable->findById($this->userId);
		}
		return $this->user;
	}	
	
	// This method returns the match for the current prediction
	public function getMatch() {
		if (empty($this->match)) {
			$this->match = $this->matchesTable->findById($this->matchId);
		}
		return $this->match;
	}	
}