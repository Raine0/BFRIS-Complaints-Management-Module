<?php
session_start();
require './../../../db_conn.php';

if (filter_has_var(INPUT_GET, 'official_id')) {
    $clean_official_id = filter_var($_GET['official_id'], FILTER_SANITIZE_NUMBER_INT);
    $official_id = filter_var($clean_official_id, FILTER_VALIDATE_INT);

    // Retrieve the updated mediator details from the database
    $officialQuery = "SELECT first_name, mid_name, last_name, suffix, off_position FROM official_view WHERE official_id = :official_id";
    $officialStatement = $pdo->prepare($officialQuery);
    $officialStatement->bindParam(':official_id', $official_id, PDO::PARAM_INT);
    $officialStatement->execute();
    $official = $officialStatement->fetch(PDO::FETCH_ASSOC);


    $last_name = strtoupper($official['last_name']);
    $first_name = strtoupper($official['first_name']);
    $mid_name = strtoupper($official['mid_name'] ? mb_substr($official['mid_name'], 0, 1, 'UTF-8') . "." : " ");
    $suffix = strtoupper(' ' . $official['suffix']);
    $official_name = $first_name . ' ' . $mid_name . ' ' . $last_name . ' ' . $suffix;
    $off_position = $official['off_position'];
}
// Example response data
$response = array(
    'official_id' => $official_id,
    'name' => $official_name,
    'position' => $off_position
);

// Return the mediator details as JSON response
header('Content-Type: application/json');
echo json_encode($response);
