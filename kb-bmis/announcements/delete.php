<?php
include "../../db_conn.php";

if (filter_has_var(INPUT_GET, 'announcement_id')) {
    $clean_announcement_id = filter_var($_GET["announcement_id"], FILTER_SANITIZE_NUMBER_INT);
    $announcement_id = filter_var($clean_announcement_id, FILTER_VALIDATE_INT);


    $annDelete = "DELETE FROM `announcement` WHERE announcement_id = :announcement_id";
    $annStatement = $pdo->prepare($annDelete);
    $annStatement->bindParam(':announcement_id', $announcement_id, PDO::PARAM_INT);
    $annStatement->execute();

    $_SESSION['success'] = "Announcement Deleted Successfully";
    header("location: ./");
}
