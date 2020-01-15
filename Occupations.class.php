<?php
class Occupations
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
    function addOccupation($company, $title, $start, $end)
    {
        $sql = $this->dbconn->prepare("INSERT INTO Occupations (Company, Title, StartDate, EndDate) VALUES (?, ?, ?, ?)");
        $sql->bind_param('ssss', $company, $title, $start, $end);
        $sql->execute();
    }

    function getOccupations()
    {
        $sql = $this->dbconn->prepare("SELECT * FROM Occupations");
        $sql->execute();

        $arr = [];
        $result = $sql->get_result();
        while($row = $result->fetch_assoc())
        {
            $row_arr['ID'] = $row['ID'];
            $row_arr['Company'] = $row['Company'];
            $row_arr['Title'] = $row['Title'];
            $row_arr['StartDate'] = $row['StartDate'];
            $row_arr['EndDate'] = $row['EndDate'];
            array_push($arr, $row_arr);
        }
        return $arr;
    }

    function updateOccupation($id, $company, $title, $start, $end)
    {
        $sql = $this->dbconn->prepare("UPDATE Occupations SET Company = ?, Title = ?, StartDate = ?, StartDate = ? WHERE ID = ?");
        $sql->bind_param('ssssi', $company, $title, $start, $end, $id);
        $sql->execute();
    }

    function deleteOccupation($id)
    {
        $sql = $this->dbconn->prepare("DELETE FROM Occupations WHERE ID = ?");
        $sql->bind_param('i', $id);
        $sql->execute();
    }
}
?>