<?php
include "../../../db_conn.php";
session_start();
if (!isset($_SESSION['user_id'])) {
    header("location: ../../../");
    exit();
}

$role = $_SESSION['role'];
$username = ucwords($_SESSION['username']);
$updated_by = $username . '(' . $role . ')';

if (filter_has_var(INPUT_POST, 'btn_save')) {
    $clean_resident_id = filter_var($_POST['resident_id'], FILTER_SANITIZE_NUMBER_INT);
    $resident_id = filter_var($clean_resident_id, FILTER_VALIDATE_INT);
    $clean_official_id = filter_var($_POST['official_id'], FILTER_SANITIZE_NUMBER_INT);
    $official_id = filter_var($clean_official_id, FILTER_VALIDATE_INT);
    // terms
    $off_position = htmlspecialchars(ucwords($_POST['off_position']));
    $term = $_POST['term'];
    $first_term_start = $_POST['first_start'];
    $first_term_end = $_POST['second_start'];
    $second_term_start = $_POST['second_start'];


    if (!empty($_POST['second_term']) && $term === "1st Term") {
        $term = $_POST['second_term'];
    }
    if (!empty($_POST['third_term']) && $term === "2nd Term") {
        $term = $_POST['third_term'];
        $second_term_end = $_POST['third_start'];
        $third_term_start = $_POST['third_start'];
    } else {
        $second_term_end = $_POST['second_end'];
        $third_term_start = $_POST['third_start'];
    }


    $updateOfficial = "UPDATE `official` SET 
        `first_term_start`= :first_term_start,
        `first_term_end`= :first_term_end,
        `second_term_start`= :second_term_start,
        `second_term_end`= :second_term_end,
        `third_term_start`= :third_term_start,
        `term`= :term, 
        `off_position` = :off_position,
        `updated_by`= :updated_by
         WHERE `official_id` =  :official_id
";
    $officialStatement = $pdo->prepare($updateOfficial);
    $officialStatement->bindParam(':official_id', $official_id, PDO::PARAM_INT);
    $officialStatement->bindParam(':off_position', $off_position);
    $officialStatement->bindParam(':first_term_start', $first_term_start);
    $officialStatement->bindParam(':first_term_end', $first_term_end);
    $officialStatement->bindParam(':second_term_start', $second_term_start);
    $officialStatement->bindParam(':second_term_end', $second_term_end);
    $officialStatement->bindParam(':third_term_start', $third_term_start);
    $officialStatement->bindParam(':term', $term);
    $officialStatement->bindParam(':updated_by', $updated_by);
    $officialStatement->execute();

    $_SESSION['success'] = "Official Profile Updated Successfully";
    header("location: ../view-official.php?official_id=$official_id&resident_id=$resident_id");
}
