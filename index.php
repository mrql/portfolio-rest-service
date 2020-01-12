<?php
    // Send headers
    header("Content-Type: application/json; charset=UTF-8");
    //header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, DELETE, PUT");

    // Require config-file.
    require_once 'config.php';
    require_once 'Projects.class.php';

    $courses = new Projects($dbhost, $dbuser, $dbpassword, $db); // Establish database connection through the Courses-interface.
    $method = $_SERVER['REQUEST_METHOD'];
    switch ($method){
        case "GET":
            $courses->getProjects();
            break;
            
        case "PUT":
            $input = json_decode(file_get_contents('php://input'), true);
            $courses->updateProject($input['title'], $input['desc'], $input['img'], $input['url'], $input['id']);
            break;

        case "POST":
            $input = json_decode(file_get_contents('php://input'), true);
            $courses->addProject($input['title'], $input['desc'], $input['img'], $input['url']);
            break;
            
        case "DELETE":
            $input = json_decode(file_get_contents('php://input'), true);
            $courses->deleteProject($input['id']);
            break;
    }

    // Print the data in JSON-format.
    echo json_encode($courses->getProject());
?>

