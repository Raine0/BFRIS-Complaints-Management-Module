 <!-- add resident to database -->
 <?php
        session_start();

        include "../../../db_conn.php";

        $role = $_SESSION['role'];
        $username = ucwords($_SESSION['username']);
        $created_by = $username . '(' . $role . ')';

        function calculateAge($birthdate)
        {
                $today = new DateTime('today');
                $birthdate = new DateTime($birthdate);
                $age = $today->diff($birthdate)->y;

                return $age;
        }

        if (filter_has_var(INPUT_POST, 'btn_save')) {
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

                if (calculateAge($date_of_birth) >= 60) {
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
                        if (!in_array($image_extension, $allowed_imagetype)) {
                                $_SESSION['error'] = "Only JPEG, JPG, and PNG files are allowed.";
                        } elseif ($image_size >= $max_size) {
                                $_SESSION['error'] = "File size must be less than 1MB.";
                        } else {
                                $upload = $fileName;
                                move_uploaded_file($temp_name, $folderPath . $upload);
                                $img_url = $upload;
                        }

                        // Redirect to the form file with an error message
                        if (isset($_SESSION['error'])) {
                                header("Location: ../create-resident.php");
                                exit();
                        }
                } else if (!empty($img)) {
                        $file = $folderPath . $fileName;
                        file_put_contents($file, $image_base64);
                        $img_url = $fileName;
                } else if (empty($name && $img)) {
                        $img_url = $_POST['default'];
                }

                $duplicateResident = "SELECT first_name, mid_name, last_name, date_of_birth FROM resident WHERE first_name = :first_name AND mid_name = :mid_name AND last_name = :last_name AND date_of_birth = :date_of_birth";

                $duplicateStatement = $pdo->prepare($duplicateResident);
                $duplicateStatement->bindParam(':first_name', $first_name);
                $duplicateStatement->bindParam(':mid_name', $mid_name);
                $duplicateStatement->bindParam(':last_name', $last_name);
                $duplicateStatement->bindParam(':date_of_birth', $date_of_birth);
                $duplicateStatement->execute();

                $residentCount = $duplicateStatement->rowCount();

                if ($residentCount > 0) {
                        $_SESSION['duplicate'] = "Error: This person's data already exists in the database";
                        header("location: ../create-resident.php");
                } else {
                        $residentInsert = "INSERT INTO `resident`(
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
                                `created_by`
                                ) 
                
                                VALUES(
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
                                :created_by
                                )";

                        $insertStatement = $pdo->prepare($residentInsert);
                        $insertStatement->bindParam(':first_name', $first_name);
                        $insertStatement->bindParam(':mid_name', $mid_name);
                        $insertStatement->bindParam(':last_name', $last_name);
                        $insertStatement->bindParam(':suffix', $suffix);
                        $insertStatement->bindParam(':sex', $sex);
                        $insertStatement->bindParam(':date_of_birth', $date_of_birth);
                        $insertStatement->bindParam(':place_of_birth', $place_of_birth);
                        $insertStatement->bindParam(':civil_status', $civil_status);
                        $insertStatement->bindParam(':nationality', $nationality);
                        $insertStatement->bindParam(':occupation', $occupation);
                        $insertStatement->bindParam(':religion', $religion);
                        $insertStatement->bindParam(':blood_type', $blood_type);
                        $insertStatement->bindParam(':fourps_status', $fourps_status);
                        $insertStatement->bindParam(':disability_status', $disability_status);
                        $insertStatement->bindParam(':type_disability', $type_disability);
                        $insertStatement->bindParam(':senior_status', $senior_status);
                        $insertStatement->bindParam(':educational_attainment', $educational_attainment);
                        $insertStatement->bindParam(':purok', $purok);
                        $insertStatement->bindParam(':street', $street);
                        $insertStatement->bindParam(':lot_number', $lot_number);
                        $insertStatement->bindParam(':phone_number', $phone_number);
                        $insertStatement->bindParam(':tel_number', $tel_number);
                        $insertStatement->bindParam(':email', $email);
                        $insertStatement->bindParam(':voter_status', $voter_status);
                        $insertStatement->bindParam(':voter_id', $voter_id);
                        $insertStatement->bindParam(':precinct_number', $precinct_number);
                        $insertStatement->bindParam(':national_id', $national_id);
                        $insertStatement->bindParam(':vaccine_status', $vaccine_status);
                        $insertStatement->bindParam(':vaccine_1', $vaccine_1);
                        $insertStatement->bindParam(':vaccine_date_1', $vaccine_date_1);
                        $insertStatement->bindParam(':vaccine_2', $vaccine_2);
                        $insertStatement->bindParam(':vaccine_date_2', $vaccine_date_2);
                        $insertStatement->bindParam(':booster_status', $booster_status);
                        $insertStatement->bindParam(':booster_1', $booster_1);
                        $insertStatement->bindParam(':booster_date_1', $booster_date_1);
                        $insertStatement->bindParam(':booster_2', $booster_2);
                        $insertStatement->bindParam(':booster_date_2', $booster_date_2);
                        $insertStatement->bindParam(':emergency_person', $emergency_person);
                        $insertStatement->bindParam(':relationship', $relationship);
                        $insertStatement->bindParam(':emergency_address', $emergency_address);
                        $insertStatement->bindParam(':emergency_contact', $emergency_contact);
                        $insertStatement->bindParam(':img_url', $img_url);
                        $insertStatement->bindParam(':alien_status', $alien_status);
                        $insertStatement->bindParam(':created_by', $created_by);
                        $insertStatement->execute();

                        $_SESSION['success'] = "Resident Profile Created Succesfully";
                        header("location: ../");
                }
        }
