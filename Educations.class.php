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
    function addEducation($name, $school, $start, $end, $typeID)
    {
        $sql = $this->dbconn->prepare("INSERT INTO Educations (Name, School, StartDate, EndDate, TypeID) VALUES (?, ?, ?, ?, ?)");
        $sql->bind_param('ssssi', $name, $school, $start, $end, $typeID);
        $sql->execute();
    }

    function getEducations()
    {
        
        $sql = $this->dbconn->prepare("SELECT Educations.ID, Educations.Name, Educations.School, Educations.StartDate, Educations.EndDate, EducationTypes.Type FROM Educations INNER JOIN EducationTypes ON EducationTypes.ID = Educations.TypeID");
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

    function updateEducation($id, $name, $school, $start, $end, $typeID)
    {
        $sql = $this->dbconn->prepare("UPDATE Educations SET Name = ?, School = ?, StartDate = ?, StartDate = ?, TypeID = ? WHERE ID = ?");
        $sql->bind_param('ssssii', $name, $school, $start, $end, $typeID, $id);
        $sql->execute();
    }

    function deleteEducation($id)
    {
        $sql = $this->dbconn->prepare("DELETE FROM Educations WHERE ID = ?");
        $sql->bind_param('i', $id);
        $sql->execute();
    }
}
?>