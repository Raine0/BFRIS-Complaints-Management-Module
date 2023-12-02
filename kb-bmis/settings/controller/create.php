<?php
session_start();
require './../../../db_conn.php';

$role = $_SESSION['role'];
$username = ucwords($_SESSION['username']);
$created_by = $username . '(' . $role . ')';

if (filter_has_var(INPUT_POST, 'btn_create')) {
    $certificate_type = $_POST['certificate_type'];

    if (filter_has_var(INPUT_POST, 'certificate_purpose')) {
        if ($_POST['certificate_purpose'] !== 'Others') {
            $certificate_purpose = ucwords($_POST['certificate_purpose']);
        } else {
            $certificate_purpose = ucwords(trim($_POST['other_purpose']));
        }
    } else {
        $certificate_purpose = NULL;
    }


    if (!filter_has_var(INPUT_POST, 'certificate_category')) {
        $certificate_category = NULL;
    } else {
        $certificate_category = htmlspecialchars($_POST['certificate_category']);
    }

    $fee = htmlspecialchars($_POST['fee']);
    $remarks = htmlspecialchars($_POST['remarks']);
}

$certificateTypeQuery = "SELECT * FROM certificate_type WHERE certificate_type = :certificate_type";
$certificateTypeStatement = $pdo->prepare($certificateTypeQuery);
$certificateTypeStatement->bindParam(':certificate_type', $certificate_type);
$certificateTypeStatement->execute();

$certificateType = $certificateTypeStatement->fetch(PDO::FETCH_ASSOC);
$certificate_type_id = $certificateType['certificate_type_id'];

$duplicateFeeQuery = "SELECT certificate_type, certificate_purpose, certificate_category 
                    FROM fee_view
                    WHERE certificate_type = :certificate_type AND (certificate_purpose = :certificate_purpose || certificate_purpose IS NULL) AND (certificate_category = :certificate_category ||certificate_category IS NULL)";

$duplicateFeeStatement = $pdo->prepare($duplicateFeeQuery);
$duplicateFeeStatement->bindParam(':certificate_type', $certificate_type);
$duplicateFeeStatement->bindParam(':certificate_purpose', $certificate_purpose);
$duplicateFeeStatement->bindParam(':certificate_category', $certificate_category);
$duplicateFeeStatement->execute();

$feeCount = $duplicateFeeStatement->rowCount();

$certificatePurposeMessage = $certificate_purpose ? '-' . $certificate_purpose : '';

if ($feeCount > 0) {
    $_SESSION['duplicate'] = "Error: $certificate_type $certificatePurposeMessage Fee already exists in the database";
    header("location: ../create-fee.php");
    exit;
}

$insertFee = "INSERT INTO fee_setting (
    certificate_type_id, 
    certificate_purpose,
    certificate_category,
    fee, 
    remarks,
    created_by
    ) 
    VALUES (
    :certificate_type_id,
    :certificate_purpose,
    :certificate_category,
    :fee,
    :remarks,
    :created_by
    )";

$insertFeeStatement = $pdo->prepare($insertFee);
$insertFeeStatement->bindParam(':certificate_type_id', $certificate_type_id);
$insertFeeStatement->bindParam(':certificate_purpose', $certificate_purpose);
$insertFeeStatement->bindParam(':certificate_category', $certificate_category);
$insertFeeStatement->bindParam(':fee', $fee);
$insertFeeStatement->bindParam(':remarks', $remarks);
$insertFeeStatement->bindParam(':created_by', $created_by);
$insertFeeStatement->execute();

$_SESSION['success'] = $certificate_type . ' Successfully Added';
header("location: ./../");
