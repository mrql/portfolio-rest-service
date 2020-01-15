<?php
class Educations
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
    function addEducations($name, $school, $start, $end, $type)
    {
        $sql = $this->dbconn->prepare("INSERT INTO Educations (Name, School, Start date, End date, TypeID) VALUES (?, ?, ?, ?, ?)");
        $sql->bind_param('ssssi', $name, $school, $start, $end, $type);
        $sql->execute();
    }

    function getEducations()
    {
        // Get the educations-rows.
        $sql = $this->dbconn->prepare("SELECT Educations.ID, Educations.Name, Educations.School, Educations.StartDate, Educations.EndDate, EducationTypes.Type FROM Educations INNER JOIN EducationTypes ON EducationTypes.ID = Educations.ID");
        $sql->execute();

        $arr = [];
        $result = $sql->get_result();
        while($row = $result->fetch_assoc())
        {
            $row_arr['ID'] = $row['ID'];
            $row_arr['Name'] = $row['Name'];
            $row_arr['School'] = $row['School'];
            $row_arr['StartDate'] = $row['StartDate'];
            $row_arr['EndDate'] = $row['EndDate'];
            $row_arr['Type'] = $row['Type'];
            array_push($arr, $row_arr);
        }

        return $arr;
    }

    function getEducationTypes()
    {
        // Get the education type-rows.
        $sql = $this->dbconn->prepare("SELECT ID, Type FROM EducationTypes");
        $sql->execute();

        $arr = [];
        $result = $sql->get_result();
        while($row = $result->fetch_assoc())
        {
            $row_arr['ID'] = $row['ID'];
            $row_arr['Type'] = $row['Type'];
            array_push($arr, $row_arr);
        }

        return $arr;
    }

    function updateEducations($company, $title, $start, $end, $id)
    {
        $sql = $this->dbconn->prepare("UPDATE Educations SET Name = ?, School = ?, Start date = ?, Start date = ?, Type = ? WHERE ID = ?");
        $sql->bind_param('ssssi', $name, $school, $start, $end, $type, $id);
        $sql->execute();
    }

    function deleteEducations($id)
    {
        $sql = $this->dbconn->prepare("DELETE FROM Educations WHERE ID = ?");
        $sql->bind_param('i', $id);
        $sql->execute();
    }
}
?>