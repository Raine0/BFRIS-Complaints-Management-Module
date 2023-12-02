<!-- delete database -->
<?php
session_start();

include "../../../db_conn.php";
$role = $_SESSION['role'];
$username =  ucwords($_SESSION['username']);
$archived_by = $username . '(' . $role . ')';
// Delete function() without archive 
// $id = $_GET['id'];
// mysqli_query($conn, "DELETE FROM `residents` WHERE id = $id");
// header("location:index.php");

//delete resident from residents to archive

if (filter_has_var(INPUT_POST, 'submit')) {
    $clean_resident_id = filter_var($_POST['resident_id'], FILTER_SANITIZE_NUMBER_INT);
    $resident_id = filter_var($clean_resident_id, FILTER_VALIDATE_INT);
    $remarks = htmlspecialchars($_POST['remarks']);
    $hashpass = htmlspecialchars(md5($_POST['password']));
}

$date_archived = date('Y-m-d H:i:s');

$ignoreQuery = "SET FOREIGN_KEY_CHECKS=0";
$ignoreStatement = $pdo->query($ignoreQuery);

$adminQuery = "SELECT * FROM users WHERE username= :username AND password= :hashpass";
$adminStatement = $pdo->prepare($adminQuery);
$adminStatement->bindParam(':username', $username);
$adminStatement->bindParam(':hashpass', $hashpass);
$adminStatement->execute();
$adminCount = $adminStatement->rowCount();

if ($adminCount === 1) {

    $userQuery = "DELETE FROM `users` WHERE `resident_id` = :resident_id";
    $userStatement = $pdo->prepare($userQuery);
    $userStatement->bindParam(':resident_id', $resident_id, PDO::PARAM_INT);
    $userStatement->execute();

    $officialQuery = "SELECT * FROM official WHERE resident_id = :resident_id";
    $officialStatement = $pdo->prepare($officialQuery);
    $officialStatement->bindParam(':resident_id', $resident_id, PDO::PARAM_INT);

    if ($officialStatement->execute()) {

        $officialCount = $officialStatement->rowCount();

        if ($officialCount === 1) {

            $official = $officialStatement->fetch(PDO::FETCH_ASSOC);
            $term = $official['term'];
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
                )
            ";

            $officialarchiveStatement = $pdo->prepare($officialArchive);
            $officialarchiveStatement->bindParam(':official_id', $official['official_id']);
            $officialarchiveStatement->bindParam(':resident_id', $official['resident_id']);
            $officialarchiveStatement->bindParam(':off_position', $official['off_position']);
            $officialarchiveStatement->bindParam(':term', $term);
            $officialarchiveStatement->bindParam(':first_term_start', $first_term_start);
            $officialarchiveStatement->bindParam(':first_term_end', $first_term_end);
            $officialarchiveStatement->bindParam(':second_term_start', $second_term_start);
            $officialarchiveStatement->bindParam(':second_term_end', $second_term_end);
            $officialarchiveStatement->bindParam(':third_term_start', $third_term_start);
            $officialarchiveStatement->bindParam(':third_term_end', $third_term_end);
            $officialarchiveStatement->bindParam(':created_by', $official['created_by']);
            $officialarchiveStatement->bindParam(':date_created', $official['date_created']);
            $officialarchiveStatement->bindParam(':updated_by', $official['updated_by']);
            $officialarchiveStatement->bindParam(':date_updated', $official['date_updated']);
            $officialarchiveStatement->bindParam(':remarks', $remarks);
            $officialarchiveStatement->bindParam(':archived_by', $archived_by);
            $officialarchiveStatement->bindParam(':date_archived', $date_archived);
            $officialarchiveStatement->execute();



            $officialDelete = "DELETE FROM `official` WHERE official_id = :official_id AND resident_id = :resident_id";
            $officialdeleteStatement = $pdo->prepare($officialDelete);
            $officialdeleteStatement->bindParam(':official_id', $official['official_id'], PDO::PARAM_INT);
            $officialdeleteStatement->bindParam(':resident_id', $resident_id, PDO::PARAM_INT);
            $officialdeleteStatement->execute();
        }
    } else {
        $_SESSION['error'] = "No Data Found.";
        header("location: ../view-resident.php?resident_id=$resident_id");
    }

    $residentQuery = "SELECT * FROM `resident` WHERE `resident_id` = :resident_id";
    $residentStatement = $pdo->prepare($residentQuery);
    $residentStatement->bindParam(':resident_id', $resident_id, PDO::PARAM_INT);
    $residentStatement->execute();
    $residentCount = $residentStatement->rowCount();
    $resident = $residentStatement->fetch(PDO::FETCH_ASSOC);

    if ($residentCount === 1) {
        $residentArchive = "INSERT INTO `resident_archive` (
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
            `remarks`,
            `archived_by`,
            `date_archived`
        )  
        VALUES ( 
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
            :remarks,
            :archived_by,    
            :date_archived     
        )";

        $residentarchiveStatement = $pdo->prepare($residentArchive);
        $residentarchiveStatement->bindParam(':resident_id', $resident['resident_id'], PDO::PARAM_INT);
        $residentarchiveStatement->bindParam(':first_name', $resident['first_name']);
        $residentarchiveStatement->bindParam(':mid_name', $resident['mid_name']);
        $residentarchiveStatement->bindParam(':last_name', $resident['last_name']);
        $residentarchiveStatement->bindParam(':suffix', $resident['suffix']);
        $residentarchiveStatement->bindParam(':sex', $resident['sex']);
        $residentarchiveStatement->bindParam(':date_of_birth', $resident['date_of_birth']);
        $residentarchiveStatement->bindParam(':place_of_birth', $resident['place_of_birth']);
        $residentarchiveStatement->bindParam(':civil_status', $resident['civil_status']);
        $residentarchiveStatement->bindParam(':nationality', $resident['nationality']);
        $residentarchiveStatement->bindParam(':occupation', $resident['occupation']);
        $residentarchiveStatement->bindParam(':religion', $resident['religion']);
        $residentarchiveStatement->bindParam(':blood_type', $resident['blood_type']);
        $residentarchiveStatement->bindParam(':fourps_status', $resident['fourps_status']);
        $residentarchiveStatement->bindParam(':disability_status', $resident['disability_status']);
        $residentarchiveStatement->bindParam(':type_disability', $resident['type_disability']);
        $residentarchiveStatement->bindParam(':senior_status', $resident['senior_status']);
        $residentarchiveStatement->bindParam(':educational_attainment', $resident['educational_attainment']);
        $residentarchiveStatement->bindParam(':purok', $resident['purok']);
        $residentarchiveStatement->bindParam(':street', $resident['street']);
        $residentarchiveStatement->bindParam(':lot_number', $resident['lot_number']);
        $residentarchiveStatement->bindParam(':phone_number', $resident['phone_number']);
        $residentarchiveStatement->bindParam(':tel_number', $resident['tel_number']);
        $residentarchiveStatement->bindParam(':email', $resident['email']);
        $residentarchiveStatement->bindParam(':voter_status', $resident['voter_status']);
        $residentarchiveStatement->bindParam(':voter_id', $resident['voter_id']);
        $residentarchiveStatement->bindParam(':precinct_number', $resident['precinct_number']);
        $residentarchiveStatement->bindParam(':national_id', $resident['national_id']);
        $residentarchiveStatement->bindParam(':vaccine_status', $resident['vaccine_status']);
        $residentarchiveStatement->bindParam(':vaccine_1', $resident['vaccine_1']);
        $residentarchiveStatement->bindParam(':vaccine_date_1', $resident['vaccine_date_1']);
        $residentarchiveStatement->bindParam(':vaccine_2', $resident['vaccine_2']);
        $residentarchiveStatement->bindParam(':vaccine_date_2', $resident['vaccine_date_2']);
        $residentarchiveStatement->bindParam(':booster_status', $resident['booster_status']);
        $residentarchiveStatement->bindParam(':booster_1', $resident['booster_1']);
        $residentarchiveStatement->bindParam(':booster_date_1', $resident['booster_date_1']);
        $residentarchiveStatement->bindParam(':booster_2', $resident['booster_2']);
        $residentarchiveStatement->bindParam(':booster_date_2', $resident['booster_date_2']);
        $residentarchiveStatement->bindParam(':emergency_person', $resident['emergency_person']);
        $residentarchiveStatement->bindParam(':relationship', $resident['relationship']);
        $residentarchiveStatement->bindParam(':emergency_address', $resident['emergency_address']);
        $residentarchiveStatement->bindParam(':emergency_contact', $resident['emergency_contact']);
        $residentarchiveStatement->bindParam(':img_url', $resident['img_url']);
        $residentarchiveStatement->bindParam(':alien_status', $resident['alien_status']);
        $residentarchiveStatement->bindParam(':deceased_status', $resident['deceased_status']);
        $residentarchiveStatement->bindParam(':date_of_death', $resident['date_of_death']);
        $residentarchiveStatement->bindParam(':created_by', $resident['created_by']);
        $residentarchiveStatement->bindParam(':date_created', $resident['date_created']);
        $residentarchiveStatement->bindParam(':updated_by', $resident['updated_by']);
        $residentarchiveStatement->bindParam(':date_updated', $resident['date_updated']);
        $residentarchiveStatement->bindParam(':remarks', $remarks);
        $residentarchiveStatement->bindParam(':archived_by', $archived_by);
        $residentarchiveStatement->bindParam(':date_archived', $date_archived);
        $residentarchiveStatement->execute();


        $residentDelete = "DELETE FROM `resident` WHERE `resident_id` = :resident_id";
        $residentdeleteStatement = $pdo->prepare($residentDelete);
        $residentdeleteStatement->bindParam(":resident_id", $resident_id, PDO::PARAM_INT);
        $residentdeleteStatement->execute();

        $_SESSION['success'] = "Resident Profile Archived Successfully";
        header("location: ../");
    }

    // $fetchImage = $fetch["img_url"];
    // /* Path of source file */
    // $filePath = 'images/' . $fetchImage;

    // $directory = '../archive/images/';
    // $destinationFilePath = '../archive/images/' . $fetchImage;

    // if (!is_dir($directory)) {
    //     /* Directory does not exist, so lets create it. */
    //     mkdir($directory, 0755);
    // }

    // !rename($filePath, $destinationFilePath);
    // mysqli_query($conn, "SET FOREIGN_KEY_CHECKS=0");


} else {
    $_SESSION['error'] = "Incorrect password.";
    header("location: ../view-resident.php?resident_id=$resident_id");
}
