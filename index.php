<?php

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "taskdb";

// Get Request URI and remove query parameters for use later if needed for custom use
$uri = explode('?', $_SERVER['REQUEST_URI']);

// Remove Base path from uri path
$base_path = dirname($_SERVER['SCRIPT_NAME']);
$uri = str_replace($base_path, '', $uri[0]);

// Start try catch instead for easier error reporting and redirect
try {
    // Get the segments to use for routing and requests
    // Note: used array_values to reset the segment.
    $segments = array_values(array_filter(explode('/', $uri)));
    // check if a segment exists. Throw 404 since a module is required.
    if (!$segments) {
        throw new Exception("Module not found", 404);
    }

    // Setting Controller name for use in file check and class instance
    $controller = ucwords($segments[0]) . 'Controller';

    // Create a connection to the database
    // TODO: Relocate later
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check for connection errors
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if file exists in Controller Location
    $file = __DIR__ . '/Controller/' . $controller . '.php';
    $exists = file_exists($file);
    if (!$exists) {
        throw new Exception("Module not found", 404);
    }

    // require class and create new instance for use by routing below
    require_once $file;
    $class = new $controller();

    // Handle different HTTP methods, check if method for request is allowed
    $method = $_SERVER['REQUEST_METHOD'];

    // check if an id/index is used in slug
    $id = @$segments[1] ?: false;
    $params = $_POST;

    switch ($method) {
        case 'GET':
            $class->get($id);
            break;
        case 'POST':
            $class->post($params);
            break;
        case 'PUT':
            $class->put($id, $params);
            break;
        case 'DELETE':
            $class->delete($id);
            break;
        default:
            // Method not allowed
            throw new Exception("Method not allowed", 405);
            break;
    }
} catch (Exception $error) {
    var_dump($error->getMessage());
} finally {
    // close connections here ??
}
