<?php
include('connect.php');

$date = $_GET['date'];

try {
    $sqlSelect = "SELECT SUM(rent.Cost) 
                  FROM rent 
                  WHERE rent.Date_start <= ? AND rent.Date_end >= ?";

    $stmt = $dbh->prepare($sqlSelect);

    $stmt->bindValue(1, $date);
    $stmt->bindValue(2, $date);
    $stmt->execute();
    $res = $stmt->fetch();

    echo "<table border='1'>";
    echo "<thead><tr><th>Доход</th></tr></thead>";
    echo "<tbody>";
    echo "<tr><td>$res[0]</td></tr>";
    echo "</tbody>";
    echo "</table>";
}
catch(PDOException $ex) {
    echo $ex->GetMessage();
}

$dbh = null;
?>
