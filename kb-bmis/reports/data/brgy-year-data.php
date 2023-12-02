<?php
header('Content-Type: application/json');
include "../../../db_conn.php";

//query to get data from the table
$yearQuery = sprintf(
    "SELECT SUM(fee) as brgyyearsales, YEAR(date_issued) as brgyyear
    FROM brgy_clearance_view
    GROUP BY YEAR(date_issued) ORDER BY (date_issued)"
);

$yearStatement = $pdo->query($yearQuery);
$years = $yearStatement->fetchAll(PDO::FETCH_ASSOC);

//loop through the returned data
$data = array();
foreach ($years as $year) {
    $data[] = $year;
}

//free memory associated with result
$yearStatement->closeCursor();

//close connection
$pdo = null;

//now print the data
print json_encode($data);
