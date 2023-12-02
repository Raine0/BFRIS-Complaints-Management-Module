<?php
include '../../../db_conn.php';

// Include the autoloader file for Spout
require '../../../vendors/excel-csv/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


// Check if files were uploaded
if (isset($_FILES['importFiles']['name'])) {

  $filename = $_FILES['importFiles']['name'];
  $allowedTypes = ['xls', 'xlsx', 'csv'];

  // Check if the file type is allowed
  $fileType = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

  if (in_array($fileType, $allowedTypes)) {

    $tmpFile = $_FILES['importFiles']['tmp_name'];
    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($tmpFile);
    $data = $spreadsheet->getActivesheet()->toArray();

    $count = 0;
    // Loop through the rows and columns of the worksheet
    foreach ($data as $row) {

      $count++;

      if ($count === 1) continue;

      // Save the row data to variable
      $id = uniqid();
      $first_name = htmlspecialchars(ucwords($row[0] ?? ''));
      $mid_name = htmlspecialchars(ucwords($row[1] ?? ''));
      $last_name = htmlspecialchars(ucwords($row[2] ?? ''));
      $suffix = htmlspecialchars(ucwords($row[3] ?? ''));
      $sex = htmlspecialchars($row[4] ?? '');
      $date_of_birth = htmlspecialchars($row[5] ?? '');
      $house_number = htmlspecialchars($row[6] ?? '');
      $street = htmlspecialchars(ucwords($row[7] ?? ''));
      $purok = htmlspecialchars(ucwords($row[8] ?? ''));
      $occupation = htmlspecialchars($row[9] ?? '');
      $citizenship = htmlspecialchars(ucwords($row[10] ?? ''));
      $civil_status = htmlspecialchars(ucwords($row[11] ?? ''));
      $voter_status = htmlspecialchars(ucwords($row[12] ?? ''));
      $phone_number = htmlspecialchars($row[13] ?? '');
      $tel_number = htmlspecialchars($row[14] ?? '');
      $sanitize_email = filter_var($row[15] ?? '', FILTER_SANITIZE_EMAIL);
      $email = filter_var($sanitize_email, FILTER_VALIDATE_EMAIL);
      $img_url = htmlspecialchars($row[16] ?? 'default-img.svg');
      $alien_status = htmlspecialchars(ucwords($row[17] ?? ''));
      $senior_status = htmlspecialchars(ucwords($row[18] ?? ''));
      $disability_status = htmlspecialchars(ucwords($row[19] ?? ''));
      $type_disability = htmlspecialchars($row[20] ?? '');
      $fourps_status = htmlspecialchars($row[21] ?? '');
      $deceased_status = htmlspecialchars($row[22] ?? '');
      $voter_id = htmlspecialchars($row[23] ?? '');
      $precinct_number = htmlspecialchars($row[24] ?? '');
      $national_id = htmlspecialchars($row[25] ?? '');
      $vaccine_status = htmlspecialchars(ucwords($row[26] ?? ''));
      $vaccine_1 = htmlspecialchars($row[27] ?? '');
      $vaccine_date_1 = htmlspecialchars($row[28] ?? '');
      $vaccine_2 = htmlspecialchars($row[29] ?? '');
      $vaccine_date_2 = htmlspecialchars($row[30] ?? '');
      $booster_status = htmlspecialchars(ucwords($row[31] ?? ''));
      $booster_1 = htmlspecialchars($row[32] ?? '');
      $booster_date_1 = htmlspecialchars($row[33] ?? '');
      $booster_2 = htmlspecialchars($row[34] ?? '');
      $booster_date_2 = htmlspecialchars($row[35] ?? '');
      $emergency_person = htmlspecialchars(ucwords($row[36] ?? ''));
      $relationship = htmlspecialchars(ucwords($row[37] ?? ''));
      $emergency_address = htmlspecialchars(ucwords($row[38] ?? ''));
      $emergency_contact = htmlspecialchars($row[39] ?? '');
      $date_of_death = htmlspecialchars($row[40] ?? '');
      $education_status = htmlspecialchars(ucwords($row[41] ?? ''));
      $place_of_birth = htmlspecialchars(ucwords($row[42] ?? ''));
      $religion = htmlspecialchars(ucwords($row[43] ?? ''));
      $blood_type = htmlspecialchars($row[44] ?? '');
      $date_created = htmlspecialchars($row[45] ?? '');
      $created_by = htmlspecialchars(ucwords($row[46] ?? ''));
      $date_updated = htmlspecialchars($row[47] ?? '');
      $updated_by = htmlspecialchars(ucwords($row[48] ?? ''));

      // Save the row data to the database
      $sql = "INSERT INTO residents (
            id, 
            first_name, 
            mid_name, 
            last_name,
            suffix, 
            sex, 
            date_of_birth, 
            house_number, 
            street,
            purok, 
            occupation,
            citizenship,
            civil_status,
            voter_status,
            phone_number,
            tel_number,
            email,
            img_url,
            alien_status,
            senior_status,
            disability_status,
            type_disability,
            4ps_status,
            deceased_status,
            voter_id,
            precinct_number,
            national_id,
            vaccine_status,
            vaccine_1,
            vaccine_date_1,
            vaccine_2,
            vaccine_date_2,
            booster_status,
            booster_1,
            booster_date_1,
            booster_2,
            booster_date_2,
            emergency_person,
            relationship,
            emergency_address,
            emergency_contact,
            date_of_death,
            education_status,
            place_of_birth,
            religion,
            blood_type,
            date_created,
            created_by,
            date_updated,
            updated_by
             ) VALUES (
              '$id',
              '$first_name',
              '$mid_name',
              '$last_name',
              '$suffix', 
              '$sex',
              '$date_of_birth',
              '$house_number',
              '$street',
              '$purok',
              '$occupation',
              '$citizenship',
              '$civil_status',
              '$voter_status',
              '$phone_number',
              '$tel_number',
              '$email',
              '$img_url',
              '$alien_status',
              '$senior_status',
              '$disability_status',
              '$type_disability',
              '$fourps_status',
              '$deceased_status',
              '$voter_id',
              '$precinct_number',
              '$national_id',
              '$vaccine_status',
              '$vaccine_1',
              '$vaccine_date_1',
              '$vaccine_2',
              '$vaccine_date_2',
              '$booster_status',
              '$booster_1',
              '$booster_date_1',
              '$booster_2',
              '$booster_date_2',
              '$emergency_person',
              '$relationship',
              '$emergency_address',
              '$emergency_contact',
              '$date_of_death',
              '$education_status',
              '$place_of_birth',
              '$religion',
              '$blood_type',
              '$date_created',
              '$created_by',
              '$date_updated',
              '$updated_by' 
           )";

      $res = mysqli_query($conn, $sql);


      if ($res) {
        header('location:../index.php?msg=File Successfully Imported');
      } else {
        header('location: ../index.php?error=Failed to Import File');
      }
    }
  } else {
    header('location: ../index.php?error=Invalid File Type');
  }
}
