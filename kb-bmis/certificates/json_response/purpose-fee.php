<?php

session_start();
require './../../../db_conn.php';

if (filter_has_var(INPUT_GET, 'purpose')) {
    $purpose = $_GET['purpose'];

    if (!filter_has_var(INPUT_GET, 'certificate_category')) {
        $clearancePriceQuery = "SELECT fee_setting_id, fee FROM fee_view WHERE certificate_purpose = :purpose";
        $clearancePriceStatement = $pdo->prepare($clearancePriceQuery);
        $clearancePriceStatement->bindParam(':purpose', $purpose);
    } else {
        $category = $_GET['certificate_category'];

        $clearancePriceQuery = "SELECT fee_setting_id, fee FROM fee_view WHERE certificate_purpose = :purpose AND certificate_category = :category";
        $clearancePriceStatement = $pdo->prepare($clearancePriceQuery);
        $clearancePriceStatement->bindParam(':purpose', $purpose);
        $clearancePriceStatement->bindParam(':category', $category);
    }

    $clearancePriceStatement->execute();
    $clearanceFeeRowCount = $clearancePriceStatement->rowCount();
    $clearanceFee = $clearancePriceStatement->fetch(PDO::FETCH_ASSOC);

    if ($clearanceFeeRowCount > 0) {
        $fee_setting_id = $clearanceFee['fee_setting_id'];
        $fee = $clearanceFee['fee'];
    } else {
        $fee_setting_id = 0;
        $fee = 'No Fee Recorded';
    }
}

// Example response data
$response = array(
    'fee_setting_id' => $fee_setting_id,
    'fee' => $fee
);

// Return the mediator details as JSON response
header('Content-Type: application/json');
echo json_encode($response);
