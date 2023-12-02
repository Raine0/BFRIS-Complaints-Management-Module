<?php

include "../../../db_conn.php";

$clean_official_archive_id = filter_var($_GET['officials_archive_id'], FILTER_SANITIZE_NUMBER_INT);
$official_archive_id = filter_var($clean_official_archive_id, FILTER_SANITIZE_NUMBER_INT);

$deleteOfficial = "DELETE FROM `official_archive` WHERE `officials_archive_id` = :official_archive_id";

$deleteStatement = $pdo->prepare($deleteOfficial);
$deleteStatement->bindParam(':official_archive_id', $official_archive_id);
$deleteStatement->execute();

header("location:../official-archive.php");
