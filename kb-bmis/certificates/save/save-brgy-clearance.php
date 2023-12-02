<?php
include "../../../db_conn.php";

session_start();

if (filter_has_var(INPUT_POST, 'submit')) {
    $clean_resident_id = filter_var($_POST['resident_id'], FILTER_SANITIZE_NUMBER_INT);
    $resident_id = filter_var($clean_resident_id, FILTER_VALIDATE_INT);
    $clean_official_id = filter_var($_POST['official_id'], FILTER_SANITIZE_NUMBER_INT);
    $official_id = filter_var($clean_official_id, FILTER_VALIDATE_INT);
    $clean_fee_id = filter_var($_POST['fee_setting_id'], FILTER_SANITIZE_NUMBER_INT);
    $fee_setting_id = filter_var($clean_fee_id, FILTER_VALIDATE_INT);
    $purpose = ucwords($_POST['purpose']);
    $category = ucwords($_POST['category']);
    $receipt_number = $_POST['receipt_number'];
    $cedula_number = $_POST['cedula_number'];
    $cedula_issued_at = ucwords($_POST['cedula_issued_at']);
    $cedula_date = $_POST['cedula_date'];
    $issued_by = $_SESSION['role'];

    $clearanceQuery = "INSERT INTO `barangay_clearance`( 
        `resident_id`,  
        `official_id`,
        `fee_setting_id`,
        `purpose`, 
        `category`,
        `receipt_number`,
        `cedula_number`, 
        `cedula_issued_at`, 
        `cedula_date`, 
        `issued_by` 
        ) 
        VALUES (
        :resident_id,
        :official_id,
        :fee_setting_id,
        :purpose,
        :category,
        :receipt_number,
        :cedula_number,
        :cedula_issued_at,
        :cedula_date,
        :issued_by
    )";

    $clearanceStatement = $pdo->prepare($clearanceQuery);
    $clearanceStatement->bindParam(':resident_id', $resident_id, PDO::PARAM_INT);
    $clearanceStatement->bindParam(':official_id', $official_id, PDO::PARAM_INT);
    $clearanceStatement->bindParam(':fee_setting_id', $fee_setting_id, PDO::PARAM_INT);
    $clearanceStatement->bindParam(':purpose', $purpose);
    $clearanceStatement->bindParam(':category', $category);
    $clearanceStatement->bindParam(':receipt_number', $receipt_number);
    $clearanceStatement->bindParam(':cedula_number', $cedula_number);
    $clearanceStatement->bindParam(':cedula_issued_at', $cedula_issued_at);
    $clearanceStatement->bindParam(':cedula_date', $cedula_date);
    $clearanceStatement->bindParam(':issued_by', $issued_by);

    $clearanceStatement->execute();
    $_SESSION['success'] = "Barangay Clearance Generated Successfully";
    header("location:../brgy-clearance-list.php");
}
