<?php
// All of the methods (functions) in this class are available to instances of this controller created by other files

// namespace is like a folder and gives classes unique names, in case another developed creates an EntryPoint class
namespace Jrpl\Controllers;

// Although we are in Jrpl\Controllers namespace, 
// 'use' tells this file to look in namespaces \Ninja\DatabaseTable and Authentication for classes it can't find in Jrpl\Controllers
use \Ninja\DatabaseTable;
use \Ninja\Authentication;


class Team {
	private $teamsTable;
	private $matchesTable;
	private $predictionsTable;
	private $authentication;
	
	// This constructs TeamController, with the teamsTable and matchesTable 
	// When a TeamController class is created, __construct tells it that 
	// $teamsTable is an input and it must be a DatabaseTable, and
	// $matchesTable is an input and it must be a DatabaseTable, and
	// $predictionsTable is an input and it much be a DatabaseTable, and
	// $authentication is an input and it must be an Authentication object
	
	public function __construct(DatabaseTable $teamsTable, DatabaseTable $matchesTable, DatabaseTable $predictionsTable, Authentication $authentication) {
		$this->teamsTable = $teamsTable;
		$this->matchesTable = $matchesTable;
		$this->predictionsTable = $predictionsTable;
		$this->authentication = $authentication;
	}	

	// This method returns a list of jokes matching the category selected and paginate so there are 10 jokes per page
	// if no category is selected, return all the jokes in the database, ordered by date descending
	public function list() {
		$page = $_GET['page'] ?? 1;
		$offset = ($page-1)*10;
		
		if (isset($_GET['category'])){
			$category = $this->categoriesTable->findById($_GET['category']);
			$jokes = $category->getJokes(10, $offset);
			$totalJokes = $category->getNumJokes();
		} else {
			$jokes = $this->jokesTable->findAll('jokeDate DESC', 10, $offset);
			$totalJokes = $this->jokesTable->total();
			$category = null;
		}
		
		//Set variable 'title'
		$title = 'Joke list';
				
		//Get the currently logged in user
		$user = $this->authentication->getUser();
				
		//These variables are output when this method is used
		//if there is no category it is set to null
		return [
			'template' => 'jokes.html.php', 
			'title' => $title, 
			'variables' => [
				'totalJokes' => $totalJokes, 
				'jokes' => $jokes, 
				'user' => $user, 
				'categories' => $this->categoriesTable->findAll(),
				'currentPage' => $page,
				'currentCategory' => $category 
			]
		];
	}
	
	//This method sends the browser to the home page
	public function home() {
		$title = 'Internet Joke Database';
		return ['template' => 'home.html.php', 'title' => $title];
	}

	//This method deletes joke with matching id and sends the browser to the jokes list page
	public function delete() {
		
		//Set $author to the logged in user
		$author = $this->authentication->getUser();
		
		//Set $joke to the joke in the database matching the id, using findById
		$joke = $this->jokesTable->findById($_POST['id']);
		
		//If the authorId of the joke does not match the author['id'] of the user
		//return leaves this method so that the code below is not executed and the joke is not deleted
		if ($joke->authorId != $author->id && !$author->hasPermission(\Ijdb\Entity\Author::DELETE_JOKES)) {
			return;
		}
		
		//Otherwise, delete the joke from the database (both the joke table and the joke_category table)
		$this->jokesTable->delete($_POST['id']);
		$this->jokeCategoriesTable->deleteWhere('jokeId', $_POST['id']);
		
		//Send the browser to /joke/list
		header('location: /joke/list');
		
		//This stops the current code path because this method does not return a template and title, so
		//when it goes back to EntryPoint.php there is nothing to process in run(), which elicits an error
		//The code path has been taken by the header command above anyhow
		die();
	}
	
	//This method saves changes to the joke database
	public function saveEdit() {
	
		//Set $author to the logged in user
		$author = $this->authentication->getUser();

		//Set $joke to the text posted
 		$joke = $_POST['joke'];
		
		//Convert DateTime objects to a string that MySQL understands
		//DateTime has a '\' in front because we are in Ijdb/Controllers namespace
		//and DateTime is an in-built PHP class, in the global namespace
		//'\' tells it to start from global namespace
		$joke['jokeDate'] = new \DateTime();
		
		//Create a joke entity instance to enable joke categories to be passed back to the database
		//addJoke is defined in Author.php, which uses the save method defined in DatabaseTables, 
		//which creates an entity of the class being saved (in this case, a joke entity)
		//Use the clearCategories method in the joke entity to remove all records from the joke_category table,
		//before using the addCategory method in the joke entity to add the many-many relationships in the joke_category table
		//(this is easier than checking for which need to be unchecked)
		$jokeEntity = $author->addJoke($joke);
		$jokeEntity->clearCategories();
		foreach ($_POST['category'] as $categoryId) {
			$jokeEntity->addCategory($categoryId);
		}		
		
		// Set these to stop PHP compile warning in error log
		$title = '';
		$output = '';
			
		//Send the browser to /joke/list
		header('location: /joke/list');
		
		//This stops the current code path because this method does not return a template and title, so
		//when it goes back to EntryPoint.php there is nothing to process in run(), which elicits an error
		//The code path has been taken by the header command above anyhow
		die();
	}
		
	//When nothing has yet been entered into the text box, this method retrieves the joke to be edited
	//It pastes the text of the joke in the form so it can be edited
	//findById is defined in DatabaseTable.php
	public function edit(){
		
		//Set $author to the logged in user
		$author = $this->authentication->getUser();

		//Use the findAll method (in DatabaseTable) to get a list of categories
		//These are passed to the template
		$categories = $this->categoriesTable->findAll();
		
		if (isset($_GET['id'])) {
			$joke = $this->jokesTable->findById($_GET['id']);
		}
		
		//Set variable 'title'
		$title = 'Edit joke';
		
		return [
			'template' => 'editjoke.html.php', 
			'title' => $title,
			'variables' => [
				'joke' => $joke ?? null,
				'user' => $author,
				'categories' => $categories
			]	
		];
	}
}