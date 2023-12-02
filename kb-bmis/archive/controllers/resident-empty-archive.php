<?php
include "../../../db_conn.php";

$id = $_GET['resident_archive_id'];
$squery = mysqli_query($conn, "TRUNCATE TABLE residents_archive");


$folderName = '../images/';

removeFolder($folderName);

function removeFolder($folderName)
{
    if (is_dir($folderName))
        $folderHandle = opendir($folderName);

    if (!$folderHandle)
        return false;

    while ($file = readdir($folderHandle)) {
        if ($file != "." && $file != "..") {
            if (!is_dir($folderName . "/" . $file))
                unlink($folderName . "/" . $file);
            else
                removeFolder($folderName . '/' . $file);
        }
    }

    closedir($folderHandle);
    rmdir($folderName);
    return true;
}


header("location:../resident-archive.php");
