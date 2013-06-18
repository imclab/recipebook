<?php
/**
 * Step 1: Require the Slim Framework
 *
 * If you are not using Composer, you need to require the
 * Slim Framework and register its PSR-0 autoloader.
 *
 * If you are using Composer, you can skip this step.
 */
require 'Slim/Slim.php';
require 'Slim/Database.php';
require 'Slim/Middleware.php';
require 'Slim/Middleware/HttpBasicAuth.php';

\Slim\Slim::registerAutoloader();

/**
 * Step 2: Instantiate a Slim application
 *
 * This example instantiates a Slim application using
 * its default settings. However, you will usually configure
 * your Slim application now by passing an associative array
 * of setting names and values into the application constructor.
 */
$app = new \Slim\Slim();
$app->add(new \HttpBasicAuth());

/**
 * Step 3: Define the Slim application routes
 *
 * Here we define several Slim application routes that respond
 * to appropriate HTTP request methods. In this example, the second
 * argument for `Slim::get`, `Slim::post`, `Slim::put`, and `Slim::delete`
 * is an anonymous function.
 */

// HOME route
$app->get('/', function () use ($app) {
    
	
});


// GET route
$app->get('/recipes', function () use ($app) {
    
	$request = (array) json_decode($app->request()->getBody());
	$db = new Database('localhost', 'RecipeBook', 'root', '');
	$items = $db->get_all_items('recipes');
	
	$results = array();
	
	if($items) {
	
		// get all results
		foreach($items as $row) {
		
			$itemArray = array(
				'id' => $row['id'],
				'name' => $row['recipe_name'],
			);
			array_push($results, $itemArray);
		}
	
		$app->response()->header('Content-Type', 'application/json');
		echo json_encode($results);
	}
	else {
		$app->response()->status(500);
	}
	
	
});

// GET route
$app->get('/recipes/:id', function () use ($app) {
    
	// GET with parameter
	
});

// POST route
$app->post('/recipes', function () use ($app) {

	$request = (array) json_decode($app->request()->getBody());
	$app->response()->header('Content-Type', 'application/json');
	echo json_encode($request);
	
});

// PUT route
$app->put('/recipes/:id', function () use ($app) {
    echo 'This is a PUT route';
});

// DELETE route
$app->delete('/delete/:id', function () use ($app) {
    echo 'This is a DELETE route';
});

/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This executes the Slim application
 * and returns the HTTP response to the HTTP client.
 */
$app->run();
