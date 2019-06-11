<?php
// This creates a team entity class and its methods are available to team objects

namespace Jrpl\Entity;

class Match {
	public $matchId;
	public $team1Id;
	public $team2Id;
	public $matchDateTime;
	public $team1Score;
	public $team2Score;
	private $teams;
	private $teamsTable;
	private $prediction;
	private $predictionsTable;

	public function __construct(\Ninja\DatabaseTable $teamsTable, \Ninja\DatabaseTable $predictionsTable) {
		$this->teamsTable = $teamsTable;
		$this->predictionsTable = $predictionsTable;
	}
	
	// This method returns team 1 or 2 for the current match
	public function getTeam($teamNumber) {
		if (empty($this->teams[$teamNumber])) {
			$teamProperty = 'team' . $teamNumber . 'Id';
			$this->teams[$teamNumber] = $this->teamsTable->findById($this->{$teamProperty});
		}
		return $this->teams[$teamNumber];
	}	
	
	// This method returns a loggedin user's prediction for a given matchId
	public function getUserPrediction($userId) {
		if (empty($this->prediction)) {
			// [0] is used to turn the array into a single row
			$this->prediction = $this->predictionsTable->find(['userId', 'matchId'], [$userId, $this->matchId])[0];
		}
		return $this->prediction;
	}	
}