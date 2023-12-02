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
    $issued_by = $_SESSION['role'];
}

$goodmoralQuery = "INSERT INTO good_moral_certificate (
        resident_id,
        official_id,
        fee_setting_id,
        purpose,
        issued_by
    )
    VALUES(
        :resident_id,
        :official_id,
        :fee_setting_id,
        :purpose,
        :issued_by
    )";

$goodmoralStatement = $pdo->prepare($goodmoralQuery);
$goodmoralStatement->bindParam(':resident_id', $resident_id);
$goodmoralStatement->bindParam(':official_id', $official_id);
$goodmoralStatement->bindParam(':fee_setting_id', $fee_setting_id);
$goodmoralStatement->bindParam(':purpose', $purpose);
$goodmoralStatement->bindParam(':issued_by', $issued_by);
$goodmoralStatement->execute();

$SESSION['success'] = "Good Moral Certificate Successfully Created";
header('location: ../good-moral-list.php');
