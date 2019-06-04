<?php
// This creates a team entity class and its methods are available to team objects

namespace Jrpl\Entity;

class Team {
	public $teamId;
	public $teamName;
	public $teamFlag;
	public $groupId;
	private $groupsTable;

	public function __construct(\Ninja\DatabaseTable $groupsTable) {
		$this->groupsTable = $groupsTable;
	}
	
	// This method returns the group for the current team
	public function getGroup() {
		if (empty($this->group)) {
			$this->group = $this->groupsTable->findById($this->groupId);
		}
		return $this->group;
	}	
}