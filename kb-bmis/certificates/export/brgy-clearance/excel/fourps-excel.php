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
$fileName = "Fatima-Brgy-Clearance-4ps (" . date('Y-m-d') . ").xls";

// Column names 
$fields  = array('ID', 'FULLNAME', 'PURPOSE', 'OFFICIAL RECEIPT NUMBER', 'CEDULA NUMBER', 'CEDULA ISSUED AT', 'CEDULA DATE', 'FEE', 'ISSUED BY', 'DATE ISSUED');

// Display column names as first row 
array_walk($fields, 'filterData');
$excelData = implode("\t", array_values($fields)) . "\n";

// Fetch records from database 
$fourpsQuery = "SELECT * FROM brgy_clearance_view WHERE fourps_status = :fourps_status";

$fourpsStatement = $pdo->prepare($fourpsQuery);
$fourpsStatement->bindValue(':fourps_status', '4Ps');
$fourpsStatement->execute();
$fourpsCount = $fourpsStatement->rowCount();
if ($fourpsCount > 0) {
    // Output each row of the data 
    while ($fourps = $fourpsStatement->fetch(PDO::FETCH_ASSOC)) {
        $lineData = array(
            $fourps['brgy_clearance_id'], 
            $fourps['resident_name'], 
            $fourps['purpose'], 
            $fourps['receipt_number'], 
            $fourps['cedula_number'], 
            $fourps['cedula_issued_at'], 
            date('m-d-Y', strtotime($fourps['cedula_date'])), 
            $fourps['fee'], 
            $fourps['issued_by'], 
            date('m-d-Y h:i:s a', strtotime($fourps['date_issued']))
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
