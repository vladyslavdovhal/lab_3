<?php
include('connect.php');

$date = $_GET['date'];

try {
    $sqlSelect = "SELECT c.Name, v.Name
                  FROM cars AS c
                  JOIN vendors AS v ON c.FID_Vendors = v.ID_Vendors
                  WHERE c.ID_Cars NOT IN (
                      SELECT r.FID_Car 
                      FROM rent AS r 
                      WHERE (r.Date_start <= ? AND r.Date_end >= ?) 
                          OR (r.Date_start <= ? AND r.Date_end >= ?)
                          OR (? <= r.Date_start AND ? >= r.Date_end)
                  )";

    $stmt = $dbh->prepare($sqlSelect);
    $stmt->bindValue(1, $date);
    $stmt->bindValue(2, $date);
    $stmt->bindValue(3, $date);
    $stmt->bindValue(4, $date);
    $stmt->bindValue(5, $date);
    $stmt->bindValue(6, $date);
    $stmt->execute();
    $res = $stmt->fetchAll();

    echo "<table border='1'>";
    echo "<thead><tr><th>Car name</th><th>Vendor</th></tr></thead>";
    echo "<tbody>";

    foreach($res as $row)
    {
        echo "<tr><td>$row[0]</td><td>$row[1]</td></tr>";
    }
    
    echo "</tbody>";
    echo "</table>";
}
catch(PDOException $ex) {
    echo $ex->GetMessage();
}

$dbh = null;
?>
