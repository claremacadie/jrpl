<?php
// This creates a category entity with associated methods

namespace Jrpl\Entity;

use Ninja\DatabaseTable;

class Category {
	public $id;
	public $team1;
	public $team2;
	private $matchesTable;
	private $teamsTable;
	
	// Construct the teamsTable and matchesTable
	public function __construct(DatabaseTable $teamsTable, DatabaseTable $matchesTable) {
		$this->teamsTable = $teamsTable;
		$this->matchesTable = $matchesTable;
	}
	
	// This method returns the first 10 matches matching a particular team
	public function getMatches($limit = null, $offset = null) {
		$teams = $this->teamsTable->find('teamId', $this->id, null, $limit, $offset);
		$matches = [];
		foreach ($teams as $team) {
			$match = $this->matchesTable->findById($team->teamId);
			if ($match) {
				$matches[] = $match;
			}
		}
		return $matches;
	}

	// This method returns the total number of matches for a given team
	public function getNumMatches() {
		return $this->matchesTable->total('teamId', $this->id);
	}
}