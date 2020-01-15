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
        /* - Create - */
        case "POST":
            $input = json_decode(file_get_contents('php://input'), true);
            switch($input['dataset'])
            {
                /* - Projects - */
                case 'projects':
                    $projects->addProject($input['title'], $input['description'], $input['url']);
                    break;

                /* - Educations - */
                case 'educations':
                    $educations->addEducation($input['name'], $input['school'], $input['start'], $input['end'], $input['typeID']);            
                    break;

                /* - Occupations - */
                case 'occupations':
                    $occupations->addOccupation($input['company'], $input['title'], $input['start'], $input['end']);
                    break;
            }
            break;

        /* - Read - */
        case "GET":
            $input = json_decode(file_get_contents('php://input'), true);
            switch($input['dataset'])
            {
                /* - Projects - */
                case 'projects':
                    echo json_encode($projects->getProjects());
                    break;

                /* - Educations - */
                case 'educations':
                    $data = array(
                        "educations" => $educations->getEducations(),
                        "educationTypes" => $educations->getEducationTypes()
                    );
                    echo json_encode($data);
                    break;

                /* - Occupations - */
                case 'occupations':
                    echo json_encode($occupations->getOccupations());
                    break;
            }
            break;

        /* - Update - */
        case "PUT":
            $input = json_decode(file_get_contents('php://input'), true);
            switch($input['dataset'])
            {
                /* - Projects - */
                case 'projects':
                    $projects->updateProject($input['title'], $input['description'], $input['url'], $input['id']);
                    break;
                    
                /* - Educations - */
                case 'educations':
                    $educations->updateEducation($input['id'], $input['name'], $input['school'], $input['start'], $input['end'], $input['typeID']);
                    break;

                /* - Occupations - */
                case 'occupations':
                    $occupations->updateOccupation($input['id'], $input['company'], $input['title'], $input['start'], $input['end']);
                    break;
            }
            break;
        
        /* - Delete - */
        case "DELETE":
            $input = json_decode(file_get_contents('php://input'), true);
            switch($input['dataset'])
            {
                /* - Projects - */
                case 'projects':
                    $projects->deleteProject($input['id']);
                    break;

                /* - Educations - */
                case 'educations':
                    $educations->deleteEducation($input['id']);
                    break;
                    
                /* - Occupations - */
                case 'occupations':
                    $occupations->deleteOccupation($input['id']);
                    break;
            }
            break;
    }

    // Print all projects, occupations, educations and education types in JSON-format.
    $data = array(
        "projects" => $projects->getProjects(),
        "occupations" => $occupations->getOccupations(),
        "educations" => $educations->getEducations(),
        "educationTypes" => $educations->getEducationTypes()
    );
    echo json_encode($data);
?>

