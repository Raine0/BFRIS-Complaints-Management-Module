<?php
header('Content-Type: application/json');
include "../../../db_conn.php";

//query to get data from the table
$query = sprintf("SELECT DATE(date_issued) as bsDate, SUM(fee) as bsweeksales
FROM business_clearance
WHERE date(date_issued) > DATE_SUB(NOW(), INTERVAL 1 WEEK) AND
YEAR(date_issued) = YEAR(CURDATE())
GROUP BY DAYNAME(date_issued) ORDER BY (date_issued)");

//execute query
$result = $conn->query($query);

//loop through the returned data
$data = array();
foreach ($result as $row) {
    $data[] = $row;
}

//free memory associated with result
$result->close();

//close connection
$conn->close();

//now print the data
print json_encode($data);
