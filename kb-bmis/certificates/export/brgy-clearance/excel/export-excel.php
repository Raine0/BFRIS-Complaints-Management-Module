<?php
// Load the database configuration file 
include "./../../../../../db_conn.php";


// Filter the excel data 
function filterData(&$str)
{
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}

// Excel file name for download 
$fileName = "Fatima-Brgy-Clearance (" . date('Y-m-d') . ").xls";

// Column names 
$fields  = array('ID', 'FULLNAME', 'PURPOSE', 'OFFICIAL RECEIPT NUMBER', 'CEDULA NUMBER', 'CEDULA ISSUED AT', 'CEDULA DATE', 'FEE', 'ISSUED BY', 'DATE ISSUED');

// Display column names as first row 
array_walk($fields, 'filterData');
$excelData = implode("\t", array_values($fields)) . "\n";

// Fetch records from database 
$clearanceQuery = "SELECT * FROM brgy_clearance_view";

$clearanceStatement = $pdo->query($clearanceQuery);
$clearances = $clearanceStatement->fetchAll(PDO::FETCH_ASSOC);
$clearanceCount = $clearanceStatement->rowCount();
if ($clearanceCount > 0) {
    // Output each row of the data 
    foreach ($clearances as $clearance) {
        $lineData = array(
            $clearance['brgy_clearance_id'], 
            $clearance['resident_name'],
            $clearance['purpose'], 
            $clearance['receipt_number'], 
            $clearance['cedula_number'], 
            $clearance['cedula_issued_at'], 
            date('m-d-Y', strtotime($clearance['cedula_date'])),
            $clearance['fee'], 
            $clearance['issued_by'], 
            date('m-d-Y h:i:s a', strtotime($clearance['date_issued']))
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
