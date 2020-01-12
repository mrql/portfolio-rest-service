<?php
class Projects
{
    private $dbconn;

    function __construct($dbhost, $dbuser, $dbpassword, $db)
    {
        // Establish database connection.
        $this->dbconn = new mysqli($dbhost, $dbuser, $dbpassword, $db);
        if ($this->dbconn->connect_errno)
        {
            die("Failed to establish a database connection: " . $dbconn->connect_errno);
        }
    }

    function getProjects()
    {
        $sql = $this->dbconn->prepare("SELECT * FROM Projects");
        $sql->execute();

        $arr = [];
        $result = $sql->get_result();
        while($row = $result->fetch_assoc())
        {
            $row_arr['ID'] = $row['ID'];
            $row_arr['Title'] = $row['Title'];
            $row_arr['Description'] = $row['Description'];
            $row_arr['Image'] = $row['Image'];
            $row_arr['URL'] = $row['URL'];
            array_push($arr, $row_arr);
        }
        return $arr;
    }

    function addProject($title, $desc, $img, $url)
    {
        $sql = $this->dbconn->prepare("INSERT INTO Projects (Title, Description, Image, URL) VALUES (?, ?, ?, ?)");
        $sql->bind_param('ssss', $title, $desc, $img, $url);
        $sql->execute();
    }

    function updateProject($title, $desc, $img, $url, $id)
    {
        $sql = $this->dbconn->prepare("UPDATE Projects SET Title = ?, Description = ?, Image = ?, URL = ? WHERE Code = id");
        $sql->bind_param('ssssi', $title, $desc, $img, $url);
        $sql->execute();
    }

    function deleteProject($id)
    {
        $sql = $this->dbconn->prepare("DELETE FROM Projects WHERE ID = ?");
        $sql->bind_param('i', $id);
        $sql->execute();
    }
}
?>