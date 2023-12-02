<?php
session_start();

require './../../../db_conn.php';

if (filter_has_var(INPUT_GET, 'resident_id')) {
    $clean_resident_id = filter_var($_GET['resident_id'], FILTER_SANITIZE_NUMBER_INT);
    $resident_id = filter_var($clean_resident_id, FILTER_VALIDATE_INT);

    // Retrieve the updated respondent details from the database
    $residentQuery = "SELECT CONCAT(last_name, ', ', first_name, ' ', mid_name, ' ', suffix) AS complainant_resident_name, CONCAT(purok, ', ', street, ', ', lot_number) AS complainant_resident_address FROM resident WHERE resident_id = :resident_id";
    $residentStatement = $pdo->prepare($residentQuery);
    $residentStatement->bindParam(':resident_id', $resident_id, PDO::PARAM_INT);
    $residentStatement->execute();
    $resident = $residentStatement->fetch(PDO::FETCH_ASSOC);

    $complainant_resident_name = $resident['complainant_resident_name'];
    $complainant_resident_address = $resident['complainant_resident_address'];
}
// Example response data
$response = array(
    'resident_id' => $resident_id,
    'name' => $complainant_resident_name,
    'address' => $complainant_resident_address
);

// Return the mediator details as JSON response
header('Content-Type: application/json');
echo json_encode($response);
