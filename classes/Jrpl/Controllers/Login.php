<?php

//This file contains methods used for authenticating users or generating an error
//when users try to use restricted functionality
namespace Jrpl\Controllers;

class Login
{
	//Set the input to the class
	private $authentication;
	
	//This creates an authentication object
	public function __construct(\Ninja\Authentication $authentication)
	{
		$this->authentication = $authentication;
	}
	
	//This displays the login form
	public function loginForm() {
		return [
		'template' => 'login.html.php',
		'title' => 'Log in'
		];
	}
	
	//This method uses the login function in authentication to determine if the email and password are valid
	public function processLogin() {
		//If the login works with the email and password then redirect to login/success
		if ($this->authentication->login($_POST['email'], $_POST['password'])) {
			header('location: /login/success');
			
			//This stops the current code path because this branch of the method does not return a template and title, so
			//when it goes back to EntryPoint.php there is nothing to process in run(), which elicits an error
			//The code path has been taken by the header command above anyhow
			die();
		
		}
		//otherwise, use the login.html.php template and display an error message
		else {
			return [
				'template' => 'login.html.php',
				'title' => 'Log In',
				'variables' => ['error' => 'Invalid username/password.']
			];
		}
	}
	
	//This method loads the loginsuccess.html.php file
	public function success() {
		return [
			'template' => 'loginsuccess.html.php',
			'title' => 'Login Successful'
		];
	}
	
	//This sets the template and title when there is an error logging in
	//This is used when a user tries to change the database before they have logged in
	public function error()
	{
		return [ 
			'template' => 'loginerror.html.php', 
			'title' => 'You are not logged in'
			];
	}

	//This function removes data from the current session when a user logs out
	public function logout() {
		session_unset();
		return [
			'template' => 'logout.html.php',
			'title' => 'You have been logged out'];
	}
}