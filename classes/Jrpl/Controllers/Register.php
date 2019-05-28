<?php
//This file creates the Register class
//This class displays a form for users to input their details and display a 'registration successful' page

//namespace is like a folder and gives classes unique names, in case another developed creates an EntryPoint class
namespace Jrpl\Controllers;

//Although we are in Jrpl\Controllers namespace, 
//'use' tells this file to look in namespace \Ninja\DatabaseTable for classes it can't find in Jrpl\Controllers
use \Ninja\DatabaseTable;

//Create Register class with $usersTable as an input
class Register {
	private $usersTable;
	
	//When a register class is created, __construct tells it that 
	//$usersTable is an input and it must be a DatabaseTable
	public function __construct(DatabaseTable $usersTable) {
		$this->usersTable= $usersTable;
	}
	
	//This method creates a registration form using register.html.php
	public function registrationForm() {
		return ['template' => 'register.html.php', 'title' => 'Register an account'];
	}
	
	//This method displays the registration successful page using registersuccess.html.php
	public function success() {
		return ['template' => 'registersuccess.html.php', 'title' => 'Registration Successful'];
	}
	
	//This method registers users and displays the successful registration page
	//This contains validation that the fields are not left blank
	//Validation also includes that a valid email address has been entered that is not already in the database
	public function registerUser() {	
		$user = $_POST['user'];
		
		//Assume the data is valid to begin with
		$valid = true;
			
		//Create an array to store a list of error messages
		$errors = [];		
			
		// But if any of the fields have been left blank set $valid to false
		// $errors[] = means each error will be added to the end of the errors array so
		// all the error messages will be stored in $errors
		// 'userName' is the column name in the database
		if (empty($user['userName'])) {
			$valid = false;
			$errors[] = 'Name cannot be blank';
		}
		
		if (empty($user['email'])) {
			$valid = false;
			$errors[] = 'Email cannot be blank';
		}	
		
		//This check uses an inbuilt function to check for valid email addresses
		else if (filter_var($user['email'], FILTER_VALIDATE_EMAIL) == false) {
			$valid = false;
			$errors[] = 'Invalid email address';
		}
		
		//This checks for dupicate email addresses already in the database
		else {
			//convert the email to lowercase
			$user['email'] = strtolower($user['email']);
			
			//Search for the lowercase version of the email using method 'find' (defined in DatabaseTable.php)
			if (count($this->usersTable->find('email', $user['email'])) > 0) {
				$valid = false;
				$errors[] = 'That email address is already registered';
			}
		}
		
		if (empty($user['password'])) {
			$valid = false;
			$errors[] = 'Password cannot be blank';
		}
		
		//Store passwords encrypted using PASSWORD_DEFAULT method for hashing
		if ($valid == true) {
			
			//Hash the password before saving it in the database
			$user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);
			
			//When submitted, the $user variable now contains a lowercase value for email and a hashed password
			$this->usersTable->save($user);
				
			header('Location: /user/success');
			
			//This stops the current code path because this branch of the method does not return a template and title, so
			//when it goes back to EntryPoint.php there is nothing to process in run(), which elicits an error
			//The code path has been taken by the header command above anyhow
			die();
		}
		
		else {
			//If the data is not valid, display the errors and show the form again
			return [
				'template' => 'register.html.php', 
				'title' => 'Register an account',
				'variables' => ['errors' => $errors,'user' => $user]
			];
		}
	}
	
	//This method fetches a list of all the registered users and passes them to the template
	public function list() {
		$users = $this->usersTable->findAll();
		return [
			'template' => 'userlist.html.php',
			'title' => 'user list',
			'variables' => [
				'users' => $users
			]
		];
	}
	
	//This method enables the list of checkboxes for user permissions to be passed to the template
	//ReflectionClass enables all the variables, methods and constants of a class to be read
	//getConstants is an in-built php function for reflection classes
	public function permissions() {
		$user = $this->usersTable->findById($_GET['id']);
		$reflected = new \ReflectionClass('\Jrpl\Entity\user');
		$constants = $reflected->getConstants();
		return [
			'template' => 'permissions.html.php',
			'title' => 'Edit Permissions',
			'variables' => [
				'user' => $user,
				'permissions' => $constants
			]
		];
	}
	
	//This method saves the user's permissions in the database
	//array_sum adds all the values from the $_POST array, 
	//if no boxes are ticked it is set to an empty array
	public function savePermissions() {
		$user = [
			'id' => $_GET['id'],
			'permissions' => array_sum($_POST['permissions'] ?? [])
		];
		
		$this->usersTable->save($user);
		
		header('location: /user/list');
		die();
	}
	
	//This method sets the template and title when there is an error with users accessing pages they do not have permission to access
	public function error() {
		return [ 
			'template' => 'permissionserror.html.php', 
			'title' => 'You do not have permission'
			];
	}
}