<?php
header('Content-Type: application/json');
include "../../../db_conn.php";

//query to get data from the table
$weekQuery = sprintf(
    "SELECT DATE(date_issued) as Date, SUM(fee) as brgyweeksales
    FROM brgy_clearance_view
    WHERE date(date_issued) > DATE_SUB(NOW(), INTERVAL 1 WEEK) AND
    YEAR(date_issued) = YEAR(CURDATE())
    GROUP BY DAYNAME(date_issued) ORDER BY (date_issued)"
);

$weekStatement = $pdo->query($weekQuery);
$weeks = $weekStatement->fetchAll(PDO::FETCH_ASSOC);

//loop through the returned data
$data = array();
foreach ($weeks as $week) {
    $data[] = $week;
}

//free memory associated with result
$weekStatement->closeCursor();

//close connection
$pdo = null;

//now print the data
print json_encode($data);
