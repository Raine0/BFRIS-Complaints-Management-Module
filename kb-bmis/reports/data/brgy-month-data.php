<?php
header('Content-Type: application/json');
include "../../../db_conn.php";


//query to get data from the table
$monthQuery = sprintf(
    "SELECT COUNT(brgy_clearance_id) AS MonthlyBrgyClearanceTotal, SUM(fee) AS brgymonthSales, MONTHNAME(date_issued) AS MonthName
    FROM brgy_clearance_view WHERE YEAR(date_issued) = YEAR(CURDATE())
    GROUP BY MonthName
    ORDER BY MonthName"
);

$monthStatement = $pdo->query($monthQuery);
$months = $monthStatement->fetchAll(PDO::FETCH_ASSOC);

//loop through the returned data
$data = array();
foreach ($months as $month) {
    $data[] = $month;
}

$monthStatement->closeCursor();

//close connection
$pdo = null;

//now print the data
print json_encode($data);
