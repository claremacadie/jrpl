<?php
//This file contains specific code for accessing the joke database
//DatabaseConnection.php sets up the connection to the database
//DatabaseTable.php contains functions to manipulate databases, including insert record, edit record and find record
//Authentication contains functions for users logging into the website

//namespace is like a folder and gives classes unique names, in case another developer creates an JrplRoutes class
namespace Jrpl;

//Implements the type hinting defined in Routes.php
//This ensures the correct formats are used as inputs
class JrplRoutes implements \Ninja\Routes {	
	private $usersTable;
	private $jokesTable;
	private $categoriesTable;
	private $jokeCategoriesTable;
	private $authentication;
	
	public function __construct() {
		include __DIR__ . '/../../includes/DatabaseConnection.php';

		//Create instances of DatabaseTables for the joke, user and joke category tables
		$this->jokesTable = new \Ninja\DatabaseTable($pdo, 'joke', 'jokeId', '\Jrpl\Entity\Joke', [&$this->usersTable, &$this->jokeCategoriesTable]);
		$this->usersTable = new \Ninja\DatabaseTable($pdo, 'user', 'id', '\Jrpl\Entity\user', [&$this->jokesTable]);
		$this->categoriesTable = new \Ninja\DatabaseTable($pdo, 'category', 'categoryId', '\Jrpl\Entity\Category', [&$this->jokesTable, &$this->jokeCategoriesTable]);
		
		//Create instance of DatabaseTables for the joke_category table, 
		//which stores the many-many relationships between jokes and categories
		$this->jokeCategoriesTable = new \Ninja\DatabaseTable($pdo, 'joke_category', 'categoryId');	
			
		//Create an instance of the Authentication class
		$this->authentication = new \Ninja\Authentication($this->usersTable, 'email', 'password');		
	}

	//This method creates $routes to enable URLs and request methods (_GET or _POST) to determine which method of which controller will be run
	//It uses type hinting to ensure it is array
	public function getRoutes(): array {
		//Create instance of controllers
		$jokeController = new \Jrpl\Controllers\Joke($this->jokesTable, $this->usersTable, $this->categoriesTable, $this->jokeCategoriesTable, $this->authentication);
		$userController = new \Jrpl\Controllers\Register($this->usersTable);
		$loginController = new \Jrpl\Controllers\Login($this->authentication);
		$categoryController = new \Jrpl\Controllers\Category($this->categoriesTable);
		
		//These routes appear in the address bar of the browser
		//They are used to determine which controller and which method ('action') within that controller is called
		//They also use 'login' => true to ensure only specific actions are available to logged in users,
		//and 'permissions' to ensure only specific actions are available to users with appropriate permissions.		
		$routes = [
			'joke/edit' => [
				'POST' => [
					'controller' => $jokeController, 
					'action' => 'saveEdit'],
				'GET' => [
					'controller' => $jokeController, 
					'action' => 'edit'],
				'login' => true],
			
			'joke/delete' => [
				'POST' => [
					'controller' => $jokeController, 
					'action' => 'delete'],
				'login' => true],
			
			'joke/list' => [
				'GET' => [
					'controller' => $jokeController, 
					'action' => 'list']],
						
			'' => [
				'GET' => [
					'controller' => $jokeController, 
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
					
			'category/edit' => [
				'POST' => [
					'controller' => $categoryController, 
					'action' => 'saveEdit'],
				'GET' => [
					'controller' => $categoryController, 
					'action' => 'edit'],
				'login' => true,
				'permissions' => \Jrpl\Entity\user::EDIT_CATEGORIES],
			
			'category/delete' => [
				'POST' => [
					'controller' => $categoryController, 
					'action' => 'delete'],
				'login' => true,
				'permissions' => \Jrpl\Entity\user::REMOVE_CATEGORIES],
				
			'category/list' => [
				'GET' => [
					'controller' => $categoryController, 
					'action' => 'list'],
				'login' => true,
				'permissions' => \Jrpl\Entity\user::LIST_CATEGORIES],
					
			'user/permissions' => [
				'GET' => [
					'controller' => $userController, 
					'action' => 'permissions'],
				'POST' => [
					'controller' => $userController, 
					'action' => 'savePermissions'],
				'login' => true,
				'permissions' => \Jrpl\Entity\user::EDIT_USER_ACCESS],
				
			'user/list' => [
				'GET' => [
					'controller' => $userController,
					'action' => 'list'],
				'login' => true,
				'permissions' => \Jrpl\Entity\user::EDIT_USER_ACCESS],
				
			'permissions/error' => [
				'GET' => [
					'controller' => $userController,
					'action' => 'error']]
		];	
		
		//Set the output of this function to be $routes
		//This array will contain the appropriate action, depending on the controller it is paired with
		return $routes;		
	}

	//This method returns an authentication object defined by Authentication.php
	//It uses type hinting to ensure it is a Ninja/Authentication object
	public function getAuthentication(): \Ninja\Authentication {
		return $this->authentication;
	}
	
	//This method fetches the current logged-in user and checks if they have a specific permission
	//Check user is defined and their permissions match the relevant permission
	public function checkPermission($permission): bool {
		$user = $this->authentication->getUser();
		if ($user && $user->hasPermission($permission)) {
			return true;
		} else {
			return false;
		}
	}
}