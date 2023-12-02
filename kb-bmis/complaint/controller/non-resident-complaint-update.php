<?php
session_start();

require './../../../db_conn.php';

$role = $_SESSION['role'];
$username = ucwords($_SESSION['username']);
$updated_by = $username . '(' . $role . ')';

if (filter_has_var(INPUT_POST, 'case_no')) {

    $clean_case_no = filter_var($_POST['case_no'], FILTER_SANITIZE_NUMBER_INT);
    $case_no = filter_var($clean_case_no, FILTER_VALIDATE_INT);

    $clean_respondent_id = filter_var($_POST['respondent_id'], FILTER_SANITIZE_NUMBER_INT);
    $respondent_id = filter_var($clean_respondent_id, FILTER_VALIDATE_INT);

    $clean_mediator_id = filter_var($_POST['mediator_id'], FILTER_SANITIZE_NUMBER_INT);
    $mediator_id = filter_var($clean_mediator_id, FILTER_VALIDATE_INT);

    $clean_respondent_resident_id = filter_var($_POST['respondent_resident_id'], FILTER_SANITIZE_NUMBER_INT);
    $respondent_resident_id = filter_var($clean_respondent_resident_id, FILTER_VALIDATE_INT);

    $clean_non_resident_id = filter_var($_POST['non_resident_id'], FILTER_SANITIZE_NUMBER_INT);
    $non_resident_id = filter_var($clean_non_resident_id, FILTER_VALIDATE_INT);

    $clean_mediator_official_id = filter_var($_POST['mediator_official_id'], FILTER_SANITIZE_NUMBER_INT);
    $mediator_official_id = filter_var($clean_mediator_official_id, FILTER_VALIDATE_INT);


    $first_name = htmlspecialchars(ucwords(trim($_POST['first_name'])));
    $mid_name = htmlspecialchars(ucwords(trim($_POST['mid_name'])));
    $last_name = htmlspecialchars(ucwords(trim($_POST['last_name'])));
    $suffix = htmlspecialchars(ucwords(trim($_POST['suffix'])));
    $purok = htmlspecialchars(ucwords(trim($_POST['purok'])));
    $barangay = htmlspecialchars(ucwords(trim($_POST['barangay'])));
    $city = htmlspecialchars(ucwords(trim($_POST['city'])));
    $province = htmlspecialchars(ucwords(trim($_POST['province'])));
    $or_no = htmlspecialchars($_POST['receipt_number']);
    $for = htmlspecialchars(ucfirst(trim($_POST['for'])));
    $complaint_description = htmlspecialchars(ucfirst(trim($_POST['description'])));
    $date_of_hearing = htmlspecialchars($_POST['date_of_hearing']);
    $time_of_hearing = htmlspecialchars($_POST['time_of_hearing']);
    $action_taken = htmlspecialchars(ucfirst(trim($_POST['action_taken'])));
    $status = htmlspecialchars($_POST['status']);
}

//UPDATE NON-RESIDENT
$nonresidentQuery = "UPDATE non_resident SET 
    first_name = :first_name,
    mid_name = :mid_name,
    last_name = :last_name,
    suffix = :suffix,
    purok = :purok,
    barangay = :barangay,
    city = :city,
    province = :province,
    updated_by = :updated_by
    WHERE non_resident_id = :non_resident_id
";

$nonResidentStatement = $pdo->prepare($nonresidentQuery);
$nonResidentStatement->bindParam(':non_resident_id', $non_resident_id, PDO::PARAM_INT);
$nonResidentStatement->bindParam(':first_name', $first_name);
$nonResidentStatement->bindParam(':mid_name', $mid_name);
$nonResidentStatement->bindParam(':last_name', $last_name);
$nonResidentStatement->bindParam(':suffix', $suffix);
$nonResidentStatement->bindParam(':purok', $purok);
$nonResidentStatement->bindParam(':barangay', $barangay);
$nonResidentStatement->bindParam(':city', $city);
$nonResidentStatement->bindParam(':province', $province);
$nonResidentStatement->bindParam(':updated_by', $updated_by);
$nonResidentStatement->execute();


// UPDATE RESPONDENT
if ($respondent_resident_id) {
    $respondentQuery = "UPDATE respondent SET
    resident_id = :respondent_resident_id
    WHERE respondent_id = :respondent_id";

    $respondentStatement = $pdo->prepare($respondentQuery);
    $respondentStatement->bindParam(':respondent_resident_id', $respondent_resident_id);
    $respondentStatement->bindParam(':respondent_id', $respondent_id);
    $respondentStatement->execute();
}


// UPDATE MEDIATOR

if ($mediator_official_id) {
    $mediatorQuery = "UPDATE mediator SET
    official_id = :mediator_official_id
    WHERE mediator_id = :mediator_id";

    $mediatorStatement = $pdo->prepare($mediatorQuery);
    $mediatorStatement->bindParam(':mediator_id', $mediator_id);
    $mediatorStatement->bindParam(':mediator_official_id', $mediator_official_id);
    $mediatorStatement->execute();
}

//UPDATE COMPLAINT

$insertcomplaintQuery = "UPDATE complaint SET
or_no = :or_no,
reason = :reason,
complaint_description = :complaint_description,
date_of_hearing = :date_of_hearing,
time_of_hearing = :time_of_hearing,
action_taken = :action_taken,
complaint_status = :complaint_status,
updated_by = :updated_by
WHERE case_no = :case_no
";
$complaintStatement = $pdo->prepare($insertcomplaintQuery);
$complaintStatement->bindParam('case_no', $case_no, PDO::PARAM_INT);
$complaintStatement->bindParam('or_no', $or_no);
$complaintStatement->bindParam('reason', $for);
$complaintStatement->bindParam('complaint_description', $complaint_description);
$complaintStatement->bindParam('date_of_hearing', $date_of_hearing);
$complaintStatement->bindParam('time_of_hearing', $time_of_hearing);
$complaintStatement->bindParam('action_taken', $action_taken);
$complaintStatement->bindParam('complaint_status', $status);
$complaintStatement->bindParam('updated_by', $updated_by);
$complaintStatement->execute();

$_SESSION['success'] = "Complaint Updated Successfully";
header("location: ./../non-resident-complaint-view.php?case_no=$case_no");
