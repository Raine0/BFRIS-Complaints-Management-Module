<?php
header('Content-Type: application/json');
include "../../../db_conn.php";


//query to get data from the table
$query = sprintf("SELECT SUM(fee) as bsyearsales,YEAR(date_issued) as bsyear
FROM business_clearance
GROUP BY YEAR(date_issued) ORDER BY (date_issued)");

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