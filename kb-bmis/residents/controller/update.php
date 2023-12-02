 <!-- add resident to database -->
 <?php
    session_start();

    include "../../../db_conn.php";
    $role = $_SESSION['role'];
    $username = ucwords($_SESSION['username']);
    $updated_by = $username . '(' . $role . ')';


    if (filter_has_var(INPUT_POST, 'submit')) {

        $clean_resident_id = filter_var($_POST['resident_id'], FILTER_SANITIZE_NUMBER_INT);
        $resident_id = filter_var($clean_resident_id, FILTER_VALIDATE_INT);

        $first_name = htmlspecialchars(ucwords(strtolower(trim($_POST['first_name']))));
        $mid_name = htmlspecialchars(ucwords(strtolower(trim($_POST['mid_name']))));
        $last_name = htmlspecialchars(ucwords(strtolower(trim($_POST['last_name']))));
        $suffix = htmlspecialchars(ucwords(strtolower(trim($_POST['suffix']))));
        $sex = htmlspecialchars(ucwords($_POST['sex']));
        $date_of_birth = htmlspecialchars($_POST['date_of_birth']);
        $place_of_birth = htmlspecialchars(ucwords(strtolower(trim($_POST['place_of_birth']))));

        if ($_POST['civil_status'] !== 'Others') {
            $civil_status = htmlspecialchars(ucwords($_POST['civil_status']));
        } else {
            $civil_status = htmlspecialchars(ucwords(strtolower(trim($_POST['other_civil_status']))));
        }

        $nationality = htmlspecialchars(ucwords(strtolower(trim($_POST['nationality']))));
        $occupation = htmlspecialchars(ucwords(strtolower(trim($_POST['occupation']))));

        if ($_POST['religion'] !== 'Others') {
            $religion = htmlspecialchars(ucwords($_POST['religion']));
        } else {
            $religion = htmlspecialchars(ucwords(strtolower(trim($_POST['other_religion']))));
        }

        $blood_type = htmlspecialchars(ucwords($_POST['blood_type']));
        $fourps_status = htmlspecialchars(ucwords($_POST['fourps_status']));
        $disability_status = htmlspecialchars(ucwords($_POST['disability_status']));

        if ($_POST['type_disability'] !== 'Others') {
            $type_disability = htmlspecialchars(ucwords($_POST['type_disability']));
        } else {
            $type_disability = htmlspecialchars(ucwords(strtolower(trim($_POST['other_disability']))));
        }
        $clean_age = filter_var($_POST['age'], FILTER_SANITIZE_NUMBER_INT);
        $age = filter_var($clean_age, FILTER_VALIDATE_INT);
        if ($age >= 60) {
            $senior_status = "Senior Citizen";
        } else {
            $senior_status = "";
        }

        if ($_POST['educational_attainment'] !== 'Others') {
            $educational_attainment = htmlspecialchars(ucwords($_POST['educational_attainment']));
        } else {
            $educational_attainment = htmlspecialchars($_POST['other_educational_attainment']);
        }

        $purok = htmlspecialchars(ucwords($_POST['purok']));
        $street = htmlspecialchars(ucwords(strtolower(trim($_POST['street']))));
        $lot_number = htmlspecialchars(ucwords(strtolower(trim($_POST['lot_number']))));
        $phone_number = htmlspecialchars($_POST['phone_number']);
        $tel_number = htmlspecialchars($_POST['tel_number']);
        $clean_email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $email = strtolower(trim(filter_var($clean_email, FILTER_VALIDATE_EMAIL)));
        $voter_status = htmlspecialchars(ucwords($_POST['voter_status']));
        $voter_id = htmlspecialchars($_POST['voter_id']);
        $precinct_number = htmlspecialchars($_POST['precinct_number']);
        $national_id = htmlspecialchars($_POST['national_id']);
        $vaccine_status = htmlspecialchars(ucwords($_POST['vaccine_status']));
        $vaccine_1 = htmlspecialchars(ucwords($_POST['vaccine_1']));
        $vaccine_date_1 = $_POST['vaccine_date_1'];
        $vaccine_2 = htmlspecialchars(ucwords($_POST['vaccine_2']));
        $vaccine_date_2 = $_POST['vaccine_date_2'];
        $booster_status = htmlspecialchars(ucwords($_POST['booster_status']));
        $booster_1 = htmlspecialchars(ucwords($_POST['booster_1']));
        $booster_date_1 = $_POST['booster_date_1'];
        $booster_2 = htmlspecialchars(ucwords($_POST['booster_2']));
        $booster_date_2 = $_POST['booster_date_2'];
        $emergency_person = htmlspecialchars(ucwords(strtolower(trim($_POST['emergency_person']))));

        if ($_POST['relationship'] !== 'others') {
            $relationship = htmlspecialchars(ucwords($_POST['relationship']));
        } else {
            $relationship = htmlspecialchars(ucwords(strtolower(trim($_POST['other_relationship']))));
        }

        $emergency_address = htmlspecialchars(ucwords(strtolower(trim($_POST['emergency_address']))));
        $emergency_contact = htmlspecialchars($_POST['emergency_contact']);
        $alien_status = htmlspecialchars(ucwords($_POST['alien_status']));
        $deceased_status = htmlspecialchars(ucwords($_POST['deceased_status']));
        $date_of_death = $_POST['date_of_death'];
        $orig_img = $_POST['orig_img'];

        //webcam
        $img = $_POST['image'];
        $folderPath = "../images/";
        $owner_pic = trim($last_name . '_' . $first_name);
        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $fileName =  $owner_pic . '.png';

        //upload
        $name = basename($_FILES['upload']['name']);
        $temp_name = $_FILES['upload']['tmp_name'];

        $image_extension = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        $allowed_imagetype = ['jpeg', 'jpg', 'png'];

        $image_size = $_FILES['upload']['size'];
        $max_size = 1024 * 1024;


        if ($name) {
            if (!in_array($image_extension, $allowed_imagetype) && $image_size >= $max_size) {
                $_SESSION['error'] = "File size must be less than 1MB and only JPEG, JPG, and PNG files are allowed.";
            } else if (!in_array($image_extension, $allowed_imagetype)) {
                $_SESSION['error'] = "Only JPEG, JPG, and PNG files are allowed.";
            } else if ($image_size >= $max_size) {
                $_SESSION['error'] = "File size must be less than 1MB.";
            } else {
                $upload = $fileName;
                move_uploaded_file($temp_name, $folderPath . $upload);
                $img_url = $upload;
            }

            // Redirect to the form file with an error message
            if (isset($_SESSION['error'])) {
                header("Location: ../update-resident.php?resident_id='$resident_id'");
                exit();
            }
        } else if (!empty($img)) {
            $file = $folderPath . $fileName;
            file_put_contents($file, $image_base64);
            $img_url = $fileName;
        } else if (empty($fileName && $upload)) {
            $img_url = $orig_img;
        }



        $duplicateResident = "SELECT first_name, mid_name, last_name, date_of_birth FROM resident WHERE first_name = :first_name AND mid_name = :mid_name AND last_name = :last_name AND date_of_birth = :date_of_birth AND resident_id != :resident_id";

        $duplicateStatement = $pdo->prepare($duplicateResident);
        $duplicateStatement->bindParam(':resident_id', $resident_id, PDO::PARAM_INT);
        $duplicateStatement->bindParam(':first_name', $first_name);
        $duplicateStatement->bindParam(':mid_name', $mid_name);
        $duplicateStatement->bindParam(':last_name', $last_name);
        $duplicateStatement->bindParam(':date_of_birth', $date_of_birth);
        $duplicateStatement->execute();

        $residentCount = $duplicateStatement->rowCount();

        if ($residentCount > 0) {
            $_SESSION['duplicate'] = "Error: This person's data already exists in the database";
            header("location: ../update-resident.php?resident_id='$resident_id'");
        } else if ($deceased_status === 'Deceased' || $alien_status === 'Changed Residency') {

            if (!empty($deceased_status) && !empty($alien_status)) {
                $remarks = "{$deceased_status} and {$alien_status}";
            } else if (!empty($deceased_status)) {
                $remarks = "{$deceased_status}";
            } else {
                $remarks = "{$alien_status}";
            }
            $created_by = htmlspecialchars($_POST['created_by']);
            $date_created = htmlspecialchars($_POST['date_created']);
            $date_archived = date('Y-m-d H:i:s');

            $ignoreQuery = "SET FOREIGN_KEY_CHECKS=0";
            $ignoreStatement = $pdo->query($ignoreQuery);

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
            $residentarchiveStatement->bindParam(':resident_id', $resident_id, PDO::PARAM_INT);
            $residentarchiveStatement->bindParam(':first_name', $first_name);
            $residentarchiveStatement->bindParam(':mid_name', $mid_name);
            $residentarchiveStatement->bindParam(':last_name', $last_name);
            $residentarchiveStatement->bindParam(':suffix', $suffix);
            $residentarchiveStatement->bindParam(':sex', $sex);
            $residentarchiveStatement->bindParam(':date_of_birth', $date_of_birth);
            $residentarchiveStatement->bindParam(':place_of_birth', $place_of_birth);
            $residentarchiveStatement->bindParam(':civil_status', $civil_status);
            $residentarchiveStatement->bindParam(':nationality', $nationality);
            $residentarchiveStatement->bindParam(':occupation', $occupation);
            $residentarchiveStatement->bindParam(':religion', $religion);
            $residentarchiveStatement->bindParam(':blood_type', $blood_type);
            $residentarchiveStatement->bindParam(':fourps_status', $fourps_status);
            $residentarchiveStatement->bindParam(':disability_status', $disability_status);
            $residentarchiveStatement->bindParam(':type_disability', $type_disability);
            $residentarchiveStatement->bindParam(':senior_status', $senior_status);
            $residentarchiveStatement->bindParam(':educational_attainment', $educational_attainment);
            $residentarchiveStatement->bindParam(':purok', $purok);
            $residentarchiveStatement->bindParam(':street', $street);
            $residentarchiveStatement->bindParam(':lot_number', $lot_number);
            $residentarchiveStatement->bindParam(':phone_number', $phone_number);
            $residentarchiveStatement->bindParam(':tel_number', $tel_number);
            $residentarchiveStatement->bindParam(':email', $email);
            $residentarchiveStatement->bindParam(':voter_status', $voter_status);
            $residentarchiveStatement->bindParam(':voter_id', $voter_id);
            $residentarchiveStatement->bindParam(':precinct_number', $precinct_number);
            $residentarchiveStatement->bindParam(':national_id', $national_id);
            $residentarchiveStatement->bindParam(':vaccine_status', $vaccine_status);
            $residentarchiveStatement->bindParam(':vaccine_1', $vaccine_1);
            $residentarchiveStatement->bindParam(':vaccine_date_1', $vaccine_date_1);
            $residentarchiveStatement->bindParam(':vaccine_2', $vaccine_2);
            $residentarchiveStatement->bindParam(':vaccine_date_2', $vaccine_date_2);
            $residentarchiveStatement->bindParam(':booster_status', $booster_status);
            $residentarchiveStatement->bindParam(':booster_1', $booster_1);
            $residentarchiveStatement->bindParam(':booster_date_1', $booster_date_1);
            $residentarchiveStatement->bindParam(':booster_2', $booster_2);
            $residentarchiveStatement->bindParam(':booster_date_2', $booster_date_2);
            $residentarchiveStatement->bindParam(':emergency_person', $emergency_person);
            $residentarchiveStatement->bindParam(':relationship', $relationship);
            $residentarchiveStatement->bindParam(':emergency_address', $emergency_address);
            $residentarchiveStatement->bindParam(':emergency_contact', $emergency_contact);
            $residentarchiveStatement->bindParam(':img_url', $img_url);
            $residentarchiveStatement->bindParam(':alien_status', $alien_status);
            $residentarchiveStatement->bindParam(':deceased_status', $deceased_status);
            $residentarchiveStatement->bindParam(':date_of_death', $date_of_death);
            $residentarchiveStatement->bindParam(':created_by', $created_by);
            $residentarchiveStatement->bindParam(':date_created', $date_created);
            $residentarchiveStatement->bindParam(':updated_by', $updated_by);
            $residentarchiveStatement->bindParam(':date_updated', $date_archived);
            $residentarchiveStatement->bindParam(':remarks', $remarks);
            $residentarchiveStatement->bindParam(':archived_by', $updated_by);
            $residentarchiveStatement->bindParam(':date_archived', $date_archived);
            $residentarchiveStatement->execute();


            $residentDelete = "DELETE FROM `resident` WHERE `resident_id` = :resident_id";
            $residentdeleteStatement = $pdo->prepare($residentDelete);
            $residentdeleteStatement->bindParam(":resident_id", $resident_id, PDO::PARAM_INT);
            $residentdeleteStatement->execute();

            $_SESSION['success'] = "Resident Profile Archived Successfully";
            header("location: ../");
        } else {

            $residentQuery = "UPDATE `resident` SET
                `first_name` = :first_name,
                `mid_name` = :mid_name,
                `last_name` = :last_name, 
                `suffix` = :suffix,
                `sex` = :sex,
                `date_of_birth` = :date_of_birth,
                `place_of_birth` = :place_of_birth,
                `civil_status` = :civil_status,
                `nationality` = :nationality, 
                `occupation` = :occupation, 
                `religion` = :religion,
                `blood_type` = :blood_type,
                `fourps_status` = :fourps_status, 
                `disability_status` = :disability_status, 
                `type_disability` = :type_disability,
                `senior_status` = :senior_status,
                `educational_attainment` = :educational_attainment, 
                `purok` = :purok,
                `street` = :street,
                `lot_number` = :lot_number,
                `phone_number` = :phone_number,
                `tel_number` = :tel_number,
                `email` = :email,
                `voter_status` = :voter_status, 
                `voter_id` = :voter_id,
                `precinct_number` = :precinct_number, 
                `national_id` = :national_id,
                `vaccine_status` = :vaccine_status,
                `vaccine_1` = :vaccine_1,
                `vaccine_date_1` = :vaccine_date_1,
                `vaccine_2` = :vaccine_2,
                `vaccine_date_2` = :vaccine_date_2,
                `booster_status` = :booster_status,
                `booster_1` = :booster_1,
                `booster_date_1` = :booster_date_1,
                `booster_2` = :booster_2,
                `booster_date_2` = :booster_date_2,
                `emergency_person` = :emergency_person,
                `relationship` = :relationship, 
                `emergency_address` = :emergency_address, 
                `emergency_contact` = :emergency_contact,
                `img_url` = :img_url,
                `alien_status` = :alien_status,
                `deceased_status` = :deceased_status,
                `date_of_death` = :date_of_death,
                `updated_by` = :updated_by
                WHERE `resident_id` = :resident_id
                ";

            $residentStatement = $pdo->prepare($residentQuery);

            $residentStatement->bindParam(':resident_id', $resident_id, PDO::PARAM_INT);
            $residentStatement->bindParam(':first_name', $first_name);
            $residentStatement->bindParam(':mid_name', $mid_name);
            $residentStatement->bindParam(':last_name', $last_name);
            $residentStatement->bindParam(':suffix', $suffix);
            $residentStatement->bindParam(':sex', $sex);
            $residentStatement->bindParam(':date_of_birth', $date_of_birth);
            $residentStatement->bindParam(':place_of_birth', $place_of_birth);
            $residentStatement->bindParam(':civil_status', $civil_status);
            $residentStatement->bindParam(':nationality', $nationality);
            $residentStatement->bindParam(':occupation', $occupation);
            $residentStatement->bindParam(':religion', $religion);
            $residentStatement->bindParam(':blood_type', $blood_type);
            $residentStatement->bindParam(':fourps_status', $fourps_status);
            $residentStatement->bindParam(':disability_status', $disability_status);
            $residentStatement->bindParam(':type_disability', $type_disability);
            $residentStatement->bindParam(':senior_status', $senior_status);
            $residentStatement->bindParam(':educational_attainment', $educational_attainment);
            $residentStatement->bindParam(':purok', $purok);
            $residentStatement->bindParam(':street', $street);
            $residentStatement->bindParam(':lot_number', $lot_number);
            $residentStatement->bindParam(':phone_number', $phone_number);
            $residentStatement->bindParam(':tel_number', $tel_number);
            $residentStatement->bindParam(':email', $email);
            $residentStatement->bindParam(':voter_status', $voter_status);
            $residentStatement->bindParam(':voter_id', $voter_id);
            $residentStatement->bindParam(':precinct_number', $precinct_number);
            $residentStatement->bindParam(':national_id', $national_id);
            $residentStatement->bindParam(':vaccine_status', $vaccine_status);
            $residentStatement->bindParam(':vaccine_1', $vaccine_1);
            $residentStatement->bindParam(':vaccine_date_1', $vaccine_date_1);
            $residentStatement->bindParam(':vaccine_2', $vaccine_2);
            $residentStatement->bindParam(':vaccine_date_2', $vaccine_date_2);
            $residentStatement->bindParam(':booster_status', $booster_status);
            $residentStatement->bindParam(':booster_1', $booster_1);
            $residentStatement->bindParam(':booster_date_1', $booster_date_1);
            $residentStatement->bindParam(':booster_2', $booster_2);
            $residentStatement->bindParam(':booster_date_2', $booster_date_2);
            $residentStatement->bindParam(':emergency_person', $emergency_person);
            $residentStatement->bindParam(':relationship', $relationship);
            $residentStatement->bindParam(':emergency_address', $emergency_address);
            $residentStatement->bindParam(':emergency_contact', $emergency_contact);
            $residentStatement->bindParam(':img_url', $img_url);
            $residentStatement->bindParam(':alien_status', $alien_status);
            $residentStatement->bindParam(':deceased_status', $deceased_status);
            $residentStatement->bindParam(':date_of_death', $date_of_death);
            $residentStatement->bindParam(':updated_by', $updated_by);

            $residentStatement->execute();
            $_SESSION['success'] = "Resident Profile Updated Successfully";
            header("location: ../");
        }
    }
