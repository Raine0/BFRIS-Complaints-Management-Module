<?php
// Load the database configuration file 
include "../../../../db_conn.php";

// Filter the excel data 
function filterData(&$str)
{
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}

// Excel file name for download 
$fileName = "Fatima-Residents (" . date('m-d-Y') . ").xls";

// Column names 
$fields  = array('ID', 'FULLNAME', 'GENDER', 'DATE OF BIRTH', 'ADDRESS', 'PHONE NUMBER', 'EMAIL',  'OCCUPATION');

// Display column names as first row 
array_walk($fields, 'filterData');
$excelData = implode("\t", array_values($fields)) . "\n";

// Fetch records from database 
$residentQuery = "SELECT * FROM resident";
$residentStatement = $pdo->query($residentQuery);
$residentCount = $residentStatement->rowCount();
if ($residentCount > 0) {
    // Output each row of the data 
    $residents = $residentStatement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($residents as $resident) {
        $fullname = $resident['last_name'] . ', ' . $resident['first_name'] . ' ' . $resident['mid_name'] ?: '' . $resident['suffix'];
        $address  = $resident['purok'] . ", " . $resident['street'] . " , " . $resident['lot_number'];
        $lineData = array(
            $resident['resident_id'],
            $fullname,
            $resident['sex'],
            date('m-d-Y', strtotime($resident['date_of_birth'])),
            $address,
            $resident['phone_number'],
            $resident['email'],
            $resident['occupation']
        );
        array_walk($lineData, 'filterData');
        $excelData .= implode("\t", array_values($lineData)) . "\n";
    }
} else {
    $excelData .= 'No records found...' . "\n";
}

// Headers for download 
header("Pragma: no-cache");
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$fileName\"");

// Render excel data 
echo $excelData;

exit;
