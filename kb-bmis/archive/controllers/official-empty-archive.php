<?php
include "../../../db_conn.php";

$id = $_GET['officials_archive_id'];
$squery = mysqli_query($conn, "TRUNCATE TABLE officials_archive");

header("location:../official-archive.php");