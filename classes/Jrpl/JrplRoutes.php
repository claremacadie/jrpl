<?php
// This file contains specific code for accessing the jrpl database
// DatabaseConnection.php sets up the connection to the database
// DatabaseTable.php contains functions to manipulate databases, including insert record, edit record and find record
// Authentication contains functions for users logging into the website

// namespace is like a folder and gives classes unique names, in case another developer creates an JrplRoutes class
namespace Jrpl;

// Implements the type hinting defined in Routes.php
// This ensures the correct formats are used as inputs
class JrplRoutes implements \Ninja\Routes {	
	private $usersTable;
	//private $teamsTable;
	//private $matchesTable;
	//private $predictionsTable;
	private $authentication;
	
	public function __construct() {
		include __DIR__ . '/../../includes/DatabaseConnection.php';

		// Create instances of DatabaseTables for the users, teams, matches and predictions tables
		$this->usersTable = new \Ninja\DatabaseTable($pdo, 'users', 'id', '\Jrpl\Entity\User', [&$this->usersTable]);
		//$this->teamsTable = new \Ninja\DatabaseTable($pdo, 'teams', 'id', '\Jrpl\Entity\Team', [&$this->teamsTable]);
		//$this->matchesTable = new \Ninja\DatabaseTable($pdo, 'matches', 'id', '\Jrpl\Entity\Match', [&$this->matchesTable]);
		//$this->predictionsTable = new \Ninja\DatabaseTable($pdo, 'predictions', 'id', '\Jrpl\Entity\Prediction', [&$this->predictionsTable]);
		
		// Create an instance of the Authentication class
		$this->authentication = new \Ninja\Authentication($this->usersTable, 'email', 'password');		
	}

	// This method creates $routes to enable URLs and request methods (_GET or _POST) to determine which method of which controller will be run
	// It uses type hinting to ensure it is array
	public function getRoutes(): array {
		// Create instance of controllers
		$userController = new \Jrpl\Controllers\Register($this->usersTable);
		//$teamController = new \Jrpl\Controllers\Team($this->teamsTable);
		$loginController = new \Jrpl\Controllers\Login($this->authentication);
		//$matchController = new \Jrpl\Controllers\Match($this->matchesTable);
		//$predictionController = new \Jrpl\Controllers\Prediction($this->predicitonsTable);
		
		
		// These routes appear in the address bar of the browser
		// They are used to determine which controller and which method ('action') within that controller is called
		// They also use 'login' => true to ensure only specific actions are available to logged in users,
		// and 'permissions' to ensure only specific actions are available to users with appropriate permissions.		
		$routes = [
			'' => [
				'GET' => [
					'controller' => $matchController, 
					'action' => 'home']],
					
			'user/register' => [
				'GET' => [
					'controller' => $userController, 
					'action' => 'registrationForm'],
				'POST' => [
					'controller' => $userController, 
					'action' => 'registerUser']],
									
			'user/success' => [
				'GET' => [
					'controller' => $userController, 
					'action' => 'success']],
					
			'user/permissions' => [
				'GET' => [
					'controller' => $userController, 
					'action' => 'permissions'],
				'POST' => [
					'controller' => $userController, 
					'action' => 'savePermissions'],
				'login' => true,
				'permissions' => \Jrpl\Entity\User::EDIT_USER_ACCESS],
				
			'user/list' => [
				'GET' => [
					'controller' => $userController,
					'action' => 'list'],
				'login' => true,
				'permissions' => \Jrpl\Entity\User::EDIT_USER_ACCESS],
				
			'permissions/error' => [
				'GET' => [
					'controller' => $userController,
					'action' => 'error']],			
			
			'login' => [
				'GET' => [
					'controller' => $loginController,
					'action' => 'loginForm'],
				'POST' => [
					'controller' => $loginController,
					'action' => 'processLogin']],
			
			'login/success' => [
				'GET' => [
					'controller' => $loginController,
					'action' => 'success'],
				'login' => true],
			
			'login/error' => [
				'GET' => [
					'controller' => $loginController,
					'action' => 'error']],
					
			'logout' => [
				'GET' => [
					'controller' => $loginController,
					'action' => 'logout']],
					
			'team/edit' => [
				'POST' => [
					'controller' => $teamController, 
					'action' => 'saveEdit'],
				'GET' => [
					'controller' => $teamController, 
					'action' => 'edit'],
				'login' => true],
			
			'team/delete' => [
				'POST' => [
					'controller' => $teamController, 
					'action' => 'delete'],
				'login' => true],
			
			'team/list' => [
				'GET' => [
					'controller' => $teamController, 
					'action' => 'list']],
						
			'match/edit' => [
				'POST' => [
					'controller' => $matchController, 
					'action' => 'saveEdit'],
				'GET' => [
					'controller' => $matchController, 
					'action' => 'edit'],
				'login' => true,
				'permissions' => \Jrpl\Entity\User::EDIT_MATCHES],
			
			'match/delete' => [
				'POST' => [
					'controller' => $matchController, 
					'action' => 'delete'],
				'login' => true,
				'permissions' => \Jrpl\Entity\User::REMOVE_MATCHES],
				
			'match/list' => [
				'GET' => [
					'controller' => $matchController, 
					'action' => 'list'],
				'login' => true,
				'permissions' => \Jrpl\Entity\User::LIST_MATCHES]
		];	
		
		// Set the output of this function to be $routes
		// This array will contain the appropriate action, depending on the controller it is paired with
		return $routes;		
	}

	// This method returns an authentication object defined by Authentication.php
	// It uses type hinting to ensure it is a Ninja/Authentication object
	public function getAuthentication(): \Ninja\Authentication {
		return $this->authentication;
	}
	
	// This method fetches the current logged-in user and checks if they have a specific permission
	// Check user is defined and their permissions match the relevant permission
	public function checkPermission($permission): bool {
		$user = $this->authentication->getUser();
		if ($user && $user->hasPermission($permission)) {
			return true;
		} else {
			return false;
		}
	}
}