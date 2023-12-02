<?php
session_start();
include "./../../../db_conn.php";

$role = $_SESSION['role'];
$username = $_SESSION['username'];
$updated_by = ucwords($username) . '(' . $role . ')';
$date_updated = date('Y-m-d H:i:s');

// var_dump($_POST);
// exit;

if (filter_has_var(INPUT_POST, 'fee_setting_id')) {

    $clean_fee_setting_id = filter_var($_POST['fee_setting_id'], FILTER_SANITIZE_NUMBER_INT);
    $fee_setting_id = filter_var($clean_fee_setting_id, FILTER_VALIDATE_INT);

    $certificate_type = htmlspecialchars($_POST['certificate_type']);

    if ($_POST['certificate_purpose']) {
        if ($_POST['certificate_purpose'] !== 'Others') {
            $certificate_purpose = ucwords($_POST['certificate_purpose']);
        } else {
            $certificate_purpose = ucwords(trim($_POST['other_purpose']));
        }
    } else {
        $certificate_purpose = NULL;
    }

    if ($_POST['certificate_category']) {
        $certificate_category = htmlspecialchars($_POST['certificate_category']);
    } else {
        $certificate_category = NULL;
    }

    $fee = htmlspecialchars($_POST['fee']);
    $remarks = htmlspecialchars($_POST['remarks']);

    $certificateTypeQuery = "SELECT * FROM certificate_type WHERE certificate_type = :certificate_type";
    $certificateTypeStatement = $pdo->prepare($certificateTypeQuery);
    $certificateTypeStatement->bindParam(':certificate_type', $certificate_type);
    $certificateTypeStatement->execute();

    $certificateType = $certificateTypeStatement->fetch(PDO::FETCH_ASSOC);
    $certificate_type_id = $certificateType['certificate_type_id'];


    // CHECK FEE DUPLICATION
    $duplicateFeeQuery = "SELECT certificate_type, certificate_purpose, certificate_category 
                    FROM fee_view
                    WHERE fee_setting_id != :fee_setting_id AND certificate_type = :certificate_type AND (certificate_purpose = :certificate_purpose || certificate_purpose IS NULL) AND (certificate_category = :certificate_category ||certificate_category IS NULL)";

    $duplicateFeeStatement = $pdo->prepare($duplicateFeeQuery);
    $duplicateFeeStatement->bindParam(':fee_setting_id', $fee_setting_id);
    $duplicateFeeStatement->bindParam(':certificate_type', $certificate_type);
    $duplicateFeeStatement->bindParam(':certificate_purpose', $certificate_purpose);
    $duplicateFeeStatement->bindParam(':certificate_category', $certificate_category);
    $duplicateFeeStatement->execute();

    $feeCount = $duplicateFeeStatement->rowCount();

    $certificatePurposeMessage = $certificate_purpose ? '-' . $certificate_purpose : '';

    if ($feeCount > 0) {
        $_SESSION['duplicate'] = "Error: $certificate_type $certificatePurposeMessage Fee already exists in the database";
        header("location: ../");
        exit;
    }


    $updateSetting = "UPDATE fee_setting SET
        certificate_type_id = :certificate_type_id,  
        certificate_purpose = :certificate_purpose,
        certificate_category = :certificate_category,
        fee = :fee, 
        remarks = :remarks,  
        updated_by = :updated_by,
        date_updated = :date_updated
        WHERE fee_setting_id = :fee_setting_id
    ";

    $settingStatement = $pdo->prepare($updateSetting);
    $settingStatement->bindParam(':fee_setting_id', $fee_setting_id);
    $settingStatement->bindParam(':certificate_type_id', $certificate_type_id);
    $settingStatement->bindParam(':certificate_purpose', $certificate_purpose);
    $settingStatement->bindParam(':certificate_category', $certificate_category);
    $settingStatement->bindParam(':fee', $fee);
    $settingStatement->bindParam(':remarks', $remarks);
    $settingStatement->bindParam(':updated_by', $updated_by);
    $settingStatement->bindParam(':date_updated', $date_updated);
    $settingStatement->execute();

    $_SESSION['success'] = "Changes saved.";
    header("location:./../");
}
