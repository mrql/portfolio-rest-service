<?php
    // Send headers.
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Origin: https://alpinusdesign.se/index.html");
    header("Access-Control-Allow-Methods: POST");

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $input = json_decode(file_get_contents('php://input'), true)
        $headers = array(
            'From' => "From: $input['name'] <$input['email']>",
            'X-Mailer' => 'PHP/' . phpversion()
        );

        if(mail("list1507@student.miun.se", $input['subject'], $input['message'], $headers))
        {
            $data = array(
                "message" => "Email was successfully delivered!"
            );
            echo json_encode($data);
        }
        else
        {
            $data = array(
                "message" => "Email could not be delivered."
            );
            echo json_encode($data);
        }
    }
?>