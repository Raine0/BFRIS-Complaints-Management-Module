<?php
session_start();
include '../../../db_conn.php';


if (filter_has_var(INPUT_POST, 'submit')) {
    $clean_resident_id = filter_var($_POST['resident_id'], FILTER_SANITIZE_NUMBER_INT);
    $resident_id = filter_var($clean_resident_id, FILTER_VALIDATE_INT);

    $clean_official_id = filter_var($_POST['official_id'], FILTER_SANITIZE_NUMBER_INT);
    $official_id = filter_var($clean_official_id, FILTER_VALIDATE_INT);

    $clean_fee_id = filter_var($_POST['fee_setting_id'], FILTER_SANITIZE_NUMBER_INT);
    $fee_setting_id = filter_var($clean_fee_id, FILTER_VALIDATE_INT);

    $purpose = htmlspecialchars(ucwords($_POST['purpose']));
    $date_of_residency = $_POST['date_of_residency'];
    $issued_by = $_SESSION['role'];
}

$lowIncomeQuery = "INSERT INTO low_income_certificate (
        resident_id,
        official_id,
        fee_setting_id,
        purpose,
        date_of_residency,
        issued_by
    )
    VALUES(
        :resident_id,
        :official_id,
        :fee_setting_id,
        :purpose,
        :date_of_residency,
        :issued_by
    )";

$lowIncomeStatement = $pdo->prepare($lowIncomeQuery);
$lowIncomeStatement->bindParam(':resident_id', $resident_id);
$lowIncomeStatement->bindParam(':official_id', $official_id);
$lowIncomeStatement->bindParam(':fee_setting_id', $fee_setting_id);
$lowIncomeStatement->bindParam(':purpose', $purpose);
$lowIncomeStatement->bindParam(':date_of_residency', $date_of_residency);
$lowIncomeStatement->bindParam(':issued_by', $issued_by);
$lowIncomeStatement->execute();

$SESSION['success'] = "Low Income Certificate Successfully Created";
header('location: ../low-income-list.php');
