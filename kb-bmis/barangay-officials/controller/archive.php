<!-- delete database -->

<?php
session_start();
include "../../../db_conn.php";

if (!isset($_SESSION['user_id'])) {
    header("location: ../../../");
    exit();
}


$archived_by = ucwords($username) . '(' . $role . ')';
$date_archived = date('Y-m-d H:i:s');

$role = $_SESSION['role'];
$username =  $_SESSION['username'];

if (filter_has_var(INPUT_POST, 'submit')) {
    $password = htmlspecialchars(md5($_POST['password']));

    $clean_resident_id = filter_var($_POST['resident_id'], FILTER_SANITIZE_NUMBER_INT);
    $resident_id = filter_var($clean_resident_id, FILTER_VALIDATE_INT);

    $clean_official_id = filter_var($_POST['official_id'], FILTER_SANITIZE_NUMBER_INT);
    $official_id = filter_var($clean_official_id, FILTER_VALIDATE_INT);

    $position = htmlspecialchars($_POST['off_position']);
    $term = htmlspecialchars($_POST['term']);
    $remarks = htmlspecialchars($_POST['remarks']);
}

$adminQuery = "SELECT username, password FROM user_view WHERE username= :username AND password= :password";
$adminStatement = $pdo->prepare($adminQuery);
$adminStatement->bindParam(':username', $username);
$adminStatement->bindParam(':password', $password);
$adminStatement->execute();

$rowCount = $adminStatement->rowCount();

if ($rowCount === 1) {
    $officialQuery = "SELECT * FROM official_view WHERE official_id = :official_id AND resident_id = :resident_id";
    $officialStatement = $pdo->prepare($officialQuery);
    $officialStatement->bindParam(':official_id', $official_id, PDO::PARAM_INT);
    $officialStatement->bindParam(':resident_id', $resident_id, PDO::PARAM_INT);
    $officialStatement->execute();

    $official = $officialStatement->fetch(PDO::FETCH_ASSOC);
    // terms
    $first_term_start = $official['first_term_start'];
    $first_term_end = $official['first_term_end'];
    $second_term_start = $official['second_term_start'];
    $second_term_end = $official['second_term_end'];
    $third_term_start = $official['third_term_start'];

    if ($term == "1st Term") {
        $first_term_end = $date_archived;
    } else if ($term == "2nd Term") {
        $second_term_end = $date_archived;
    } else if ($term == "3rd Term") {
        $third_term_end = $date_archived;
    }

    $officialArchive = "INSERT INTO `official_archive` ( 
        `official_id`,
        `resident_id`,
        `off_position`,
        `term`,
        `first_term_start`,
        `first_term_end`,
        `second_term_start`,
        `second_term_end`,
        `third_term_start`,
        `third_term_end`,
        `created_by`, 
        `date_created`,
        `updated_by`, 
        `date_updated`,
        `remarks`,
        `archived_by`,
        `date_archived`
        )
        VALUES (
        :official_id,
        :resident_id,
        :off_position,
        :term,
        :first_term_start,
        :first_term_end,
        :second_term_start,
        :second_term_end,
        :third_term_start,
        :third_term_end,
        :created_by,
        :date_created,
        :updated_by,
        :date_updated,
        :remarks,
        :archived_by,
        :date_archived 
        )";

    $officialStatement2 = $pdo->prepare($officialArchive);
    $officialStatement2->bindParam(':official_id', $official['official_id'], PDO::PARAM_INT);
    $officialStatement2->bindParam(':resident_id', $official['resident_id'], PDO::PARAM_INT);
    $officialStatement2->bindParam(':off_position', $official['off_position']);
    $officialStatement2->bindParam(':term', $term);
    $officialStatement2->bindParam(':first_term_start', $first_term_start);
    $officialStatement2->bindParam(':first_term_end', $first_term_end);

    $officialStatement2->bindParam(':second_term_start', $second_term_start);
    $officialStatement2->bindParam(':second_term_end', $second_term_end);
    $officialStatement2->bindParam(':third_term_start', $third_term_start);
    $officialStatement2->bindParam(':third_term_end', $third_term_end);
    $officialStatement2->bindParam(':created_by', $official['created_by']);
    $officialStatement2->bindParam(':date_created', $official['date_created']);
    $officialStatement2->bindParam(':updated_by', $official['updated_by']);
    $officialStatement2->bindParam(':date_updated', $official['date_updated']);
    $officialStatement2->bindParam(':remarks', $remarks);
    $officialStatement2->bindParam(':archived_by', $archived_by);
    $officialStatement2->bindParam(':date_archived', $date_archived);
    $officialStatement2->execute();

    $occupationUpdate = "UPDATE `resident` SET `occupation`=' ' WHERE `resident_id` = :resident_id";
    $occupationStatement = $pdo->prepare($occupationUpdate);
    $occupationStatement->bindParam(':resident_id', $resident_id, PDO::PARAM_INT);
    $occupationStatement->execute();

    $userDelete =  "DELETE FROM `users` WHERE official_id = :official_id AND resident_id = :resident_id";
    $userStatement = $pdo->prepare($userDelete);
    $userStatement->bindParam(':official_id', $official_id, PDO::PARAM_INT);
    $userStatement->bindParam(':resident_id', $resident_id, PDO::PARAM_INT);
    $userStatement->execute();


    $ignoreQuery = "SET FOREIGN_KEY_CHECKS=0";
    $ignoreStatement = $pdo->query($ignoreQuery);
    // Delete function() without archive 
    // mysqli_query($conn, "DELETE FROM `officials` WHERE `id` = '$id'");
    $officialDelete = "DELETE FROM `official` WHERE official_id = :official_id AND resident_id = :resident_id";
    $officialStatement2 = $pdo->prepare($officialDelete);
    $officialStatement2->bindParam(':official_id', $official['official_id'], PDO::PARAM_INT);
    $officialStatement2->bindParam(':resident_id', $official['resident_id'], PDO::PARAM_INT);
    $officialStatement2->execute();

    $_SESSION['success'] = "{$official['off_position']} Profile Archived Successfully";
    header("location: ../");
    // add pa ug archive}
} else {
    $_SESSION['error'] = "Incorrect password";
    header("location: ../view-official.php?official_id=$official_id&resident_id=$resident_id");
}
