<?php
    // Send headers
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, DELETE, PUT");

    // Require config-file.
    require_once 'config.php';
    require_once 'Projects.class.php';
    require_once 'Occupations.class.php';
    require_once 'Educations.class.php';

    // Establish database connection through respective dataset-interface.
    $projects = new Projects($dbhost, $dbuser, $dbpassword, $db);
    $occupations = new Occupations($dbhost, $dbuser, $dbpassword, $db);
    $educations = new Educations($dbhost, $dbuser, $dbpassword, $db);
    
    $method = $_SERVER['REQUEST_METHOD'];
    switch ($method){
        case "GET":
            $input = json_decode(file_get_contents('php://input'), true);
            switch($input['dataset'])
            {
                case 'projects':
                    echo json_encode($projects->getProjects());
                    break;

                case 'educations':

                    $data = array(
                        "educations" => $educations->getEducations(),
                        "educationTypes" => $educations->getEducationTypes()
                    );

                    echo json_encode($data);
                    break;

                case 'occupations':
                    echo json_encode($occupations->getOccupations());
                    break;
            }
            break;

        case "POST":
            $input = json_decode(file_get_contents('php://input'), true);
            switch($input['dataset'])
            {
                case 'projects':
                    $projects->addProject($input['title'], $input['description'], $input['url']);
                    break;

                case 'educations':
                
                break;

                case 'occupations':
                    $occupations->addOccupation($input['company'], $input['title'], $input['start'], $input['end']);
                    break;
            }
            break;
            
        case "PUT":
            $input = json_decode(file_get_contents('php://input'), true);
            switch($input['dataset'])
            {
                case 'projects':
                    $projects->updateProject($input['title'], $input['description'], $input['url'], $input['id']);

                case 'educations':
                
                break;

                case 'occupations':
                    $occupations->updateOccupation($input['id'], $input['company'], $input['title'], $input['start'], $input['end']);
                    break;
            }
            break;
            
        case "DELETE":
            $input = json_decode(file_get_contents('php://input'), true);
            switch($input['dataset'])
            {
                case 'projects':
                    $projects->deleteProject($input['id']);

                case 'educations':
                
                break;

                case 'occupations':
                    $occupations->deleteOccupation($input['id']);
                    break;
            }
             break;
    }

    $data = array(
        "projects" => $projects->getProjects(),
        "occupations" => $occupations->getOccupations(),
        "educations" => $educations->getEducations(),
        "educationTypes" => $educations->getEducationTypes()
    );
    echo json_encode($data);
?>

