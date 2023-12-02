<?php
session_start();
include "../../../db_conn.php";

$role = $_SESSION['role'];
$username = ucwords($_SESSION['username']);
$restored_by = $username . '(' . $role . ')';

$date_restored = date('Y-m-d H:i:s');

if (filter_has_var(INPUT_POST, 'resident_archive_id')) {
    $clean_resident_archive_id = filter_var($_POST['resident_archive_id'], FILTER_SANITIZE_NUMBER_INT);
    $resident_archive_id = filter_var($clean_resident_archive_id, FILTER_VALIDATE_INT);

    $postPassword = htmlspecialchars(md5($_POST['password']));
}

$userQuery = "SELECT * from users WHERE password = :password";
$userStatement = $pdo->prepare($userQuery);
$userStatement->bindParam(':password', $postPassword);
$userStatement->execute();

$userCount = $userStatement->rowCount();

if ($userCount !== 1) {
    $_SESSION['error'] = 'Incorrect Password';
    header("location: ../view-resident.php?resident_archive_id=$resident_archive_id");
    exit();
}

$residentArchive = "SELECT * FROM `resident_archive` WHERE `resident_archive_id` = :resident_archive_id";

$residentStatement = $pdo->prepare($residentArchive);
$residentStatement->bindParam(':resident_archive_id', $resident_archive_id, PDO::PARAM_INT);
$residentStatement->execute();

$resident = $residentStatement->fetch(PDO::FETCH_ASSOC);

$residentInsert = "INSERT INTO `resident` (
			`resident_id`,
            `first_name`,  
            `mid_name`, 
            `last_name`, 
            `suffix`, 
            `sex`, 
            `date_of_birth`,
            `place_of_birth`,
            `civil_status`,  
            `nationality`,
            `occupation`, 
            `religion`, 
            `blood_type`,
            `fourps_status`, 
            `disability_status`, 
            `type_disability`,
            `senior_status`,
            `educational_attainment`, 
            `purok`, 
            `street`, 
            `lot_number`, 
            `phone_number`, 
            `tel_number`, 
            `email`, 
            `voter_status`,  
            `voter_id`, 
            `precinct_number`, 
            `national_id`, 
            `vaccine_status`,
            `vaccine_1`, 
            `vaccine_date_1`,
            `vaccine_2`,
            `vaccine_date_2`,
            `booster_status`,
            `booster_1`,
            `booster_date_1`,
            `booster_2`,
            `booster_date_2`,
            `emergency_person`, 
            `relationship`, 
            `emergency_address`, 
            `emergency_contact`,
            `img_url`,
            `alien_status`, 
            `deceased_status`,
            `date_of_death`,          
            `created_by`,
            `date_created`,
            `updated_by`,
            `date_updated`,
            `restored_by`,
            `date_restored`
		)  
		VALUES( 
			:resident_id,
            :first_name,  
            :mid_name, 
            :last_name, 
            :suffix, 
            :sex, 
            :date_of_birth,
            :place_of_birth,
            :civil_status,  
            :nationality,
            :occupation, 
            :religion, 
            :blood_type,
            :fourps_status, 
            :disability_status, 
            :type_disability,
            :senior_status,
            :educational_attainment, 
            :purok, 
            :street, 
            :lot_number, 
            :phone_number, 
            :tel_number, 
            :email, 
            :voter_status,  
            :voter_id, 
            :precinct_number, 
            :national_id, 
            :vaccine_status,
            :vaccine_1, 
            :vaccine_date_1,
            :vaccine_2,
            :vaccine_date_2,
            :booster_status,
            :booster_1,
            :booster_date_1,
            :booster_2,
            :booster_date_2,
            :emergency_person, 
            :relationship, 
            :emergency_address, 
            :emergency_contact,
            :img_url,
            :alien_status, 
            :deceased_status,
            :date_of_death,
            :created_by,
            :date_created,
            :updated_by,
            :date_updated,
            :restored_by,
            :date_restored
            )
        ";

$residentinsertStatement = $pdo->prepare($residentInsert);
$residentinsertStatement->bindParam(':resident_id', $resident['resident_id']);
$residentinsertStatement->bindParam(':first_name', $resident['first_name']);
$residentinsertStatement->bindParam(':mid_name', $resident['mid_name']);
$residentinsertStatement->bindParam(':last_name', $resident['last_name']);
$residentinsertStatement->bindParam(':suffix', $resident['suffix']);
$residentinsertStatement->bindParam(':sex', $resident['sex']);
$residentinsertStatement->bindParam(':date_of_birth', $resident['date_of_birth']);
$residentinsertStatement->bindParam(':place_of_birth', $resident['place_of_birth']);
$residentinsertStatement->bindParam(':civil_status', $resident['civil_status']);
$residentinsertStatement->bindParam(':nationality', $resident['nationality']);
$residentinsertStatement->bindParam(':occupation', $resident['occupation']);
$residentinsertStatement->bindParam(':religion', $resident['religion']);
$residentinsertStatement->bindParam(':blood_type', $resident['blood_type']);
$residentinsertStatement->bindParam(':fourps_status', $resident['fourps_status']);
$residentinsertStatement->bindParam(':disability_status', $resident['disability_status']);
$residentinsertStatement->bindParam(':type_disability', $resident['type_disability']);
$residentinsertStatement->bindParam(':senior_status', $resident['senior_status']);
$residentinsertStatement->bindParam(':educational_attainment', $resident['educational_attainment']);
$residentinsertStatement->bindParam(':purok', $resident['purok']);
$residentinsertStatement->bindParam(':street', $resident['street']);
$residentinsertStatement->bindParam(':lot_number', $resident['lot_number']);
$residentinsertStatement->bindParam(':phone_number', $resident['resident_id']);
$residentinsertStatement->bindParam(':tel_number', $resident['tel_number']);
$residentinsertStatement->bindParam(':email', $resident['email']);
$residentinsertStatement->bindParam(':voter_status', $resident['voter_status']);
$residentinsertStatement->bindParam(':voter_id', $resident['voter_id']);
$residentinsertStatement->bindParam(':precinct_number', $resident['precinct_number']);
$residentinsertStatement->bindParam(':national_id', $resident['national_id']);
$residentinsertStatement->bindParam(':vaccine_status', $resident['vaccine_status']);
$residentinsertStatement->bindParam(':vaccine_1', $resident['vaccine_1']);
$residentinsertStatement->bindParam(':vaccine_date_1', $resident['vaccine_date_1']);
$residentinsertStatement->bindParam(':vaccine_2', $resident['vaccine_2']);
$residentinsertStatement->bindParam(':vaccine_date_2', $resident['vaccine_date_2']);
$residentinsertStatement->bindParam(':booster_status', $resident['booster_status']);
$residentinsertStatement->bindParam(':booster_1', $resident['booster_1']);
$residentinsertStatement->bindParam(':booster_date_1', $resident['booster_date_1']);
$residentinsertStatement->bindParam(':booster_2', $resident['booster_2']);
$residentinsertStatement->bindParam(':booster_date_2', $resident['booster_date_2']);
$residentinsertStatement->bindParam(':emergency_person', $resident['emergency_person']);
$residentinsertStatement->bindParam(':relationship', $resident['relationship']);
$residentinsertStatement->bindParam(':emergency_address', $resident['emergency_address']);
$residentinsertStatement->bindParam(':emergency_contact', $resident['emergency_contact']);
$residentinsertStatement->bindParam(':img_url', $resident['img_url']);
$residentinsertStatement->bindParam(':alien_status', $resident['alien_status']);
$residentinsertStatement->bindParam(':deceased_status', $resident['deceased_status']);
$residentinsertStatement->bindParam(':date_of_death', $resident['date_of_death']);
$residentinsertStatement->bindParam(':created_by', $resident['created_by']);
$residentinsertStatement->bindParam(':date_created', $resident['date_created']);
$residentinsertStatement->bindParam(':updated_by', $resident['updated_by']);
$residentinsertStatement->bindParam(':date_updated', $resident['date_updated']);
$residentinsertStatement->bindParam(':restored_by', $restored_by);
$residentinsertStatement->bindParam(':date_restored', $date_restored);
$residentinsertStatement->execute();

if ($resident['occupation'] == 'Barangay Chairman' || $resident['occupation'] == 'Barangay Secretary' || $resident['occupation'] == 'Barangay Treasurer' || $resident['occupation'] == 'Barangay Clerk' || $resident['occupation'] == 'Barangay Councilor' || $resident['occupation'] == 'SK Chairperson' || $resident['occupation'] == 'SK Councilor') {

    $residentUpdate = "UPDATE `resident` SET `occupation`= :empty WHERE `resident_id` = :resident_id";
    $residentupdateStatement = $pdo->prepare($residentUpdate);
    $residentupdateStatement->bindValue(':empty', '');
    $residentupdateStatement->bindValue(':resident_id', $resident['resident_id'], PDO::PARAM_INT);
    $residentupdateStatement->execute();
}

$fetchImage = $row["img_url"];
/* Path of source file */
$filePath = '../images/' . $fetchImage;

$directory = '../../residents/images/';
$destinationFilePath = $directory . $fetchImage;

if (!is_dir($directory)) {
    /* Directory does not exist, so lets create it. */
    mkdir($directory, 0755);
}

!rename($filePath, $destinationFilePath);


$residentDelete = "DELETE FROM `resident_archive` WHERE `resident_archive_id` = :resident_archive_id";
$residentdeleteStatement = $pdo->prepare($residentDelete);
$residentdeleteStatement->bindParam(':resident_archive_id', $resident_archive_id, PDO::PARAM_INT);
$residentdeleteStatement->execute();

$_SESSION['success'] = "Resident Profile Restored Successfully";
header('location:../resident-archive.php');
