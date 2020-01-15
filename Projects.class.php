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

    /* - CRUD-methods - */
    function addProject($title, $desc, $url)
    {
        $sql = $this->dbconn->prepare("INSERT INTO Projects (Title, Description, URL) VALUES (?, ?, ?)");
        $sql->bind_param('sss', $title, $desc, $url);
        $sql->execute();
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
            $row_arr['URL'] = $row['URL'];
            array_push($arr, $row_arr);
        }
        return $arr;
    }

    function updateProject($title, $desc, $url, $id)
    {
        $sql = $this->dbconn->prepare("UPDATE Projects SET Title = ?, Description = ?, URL = ? WHERE ID = ?");
        $sql->bind_param('sssi', $title, $desc, $url, $id);
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