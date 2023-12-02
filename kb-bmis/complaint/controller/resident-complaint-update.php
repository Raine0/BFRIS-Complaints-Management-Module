<?php
session_start();

require './../../../db_conn.php';

$role = $_SESSION['role'];
$username = ucwords($_SESSION['username']);
$updated_by = $username . '(' . $role . ')';

if (filter_has_var(INPUT_POST, 'case_no')) {

    $clean_case_no = filter_var($_POST['case_no'], FILTER_SANITIZE_NUMBER_INT);
    $case_no = filter_var($clean_case_no, FILTER_VALIDATE_INT);

    $clean_complainant_id = filter_var($_POST['complainant_id'], FILTER_SANITIZE_NUMBER_INT);
    $complainant_id = filter_var($clean_complainant_id, FILTER_VALIDATE_INT);

    $clean_respondent_id = filter_var($_POST['respondent_id'], FILTER_SANITIZE_NUMBER_INT);
    $respondent_id = filter_var($clean_respondent_id, FILTER_VALIDATE_INT);

    $clean_mediator_id = filter_var($_POST['mediator_id'], FILTER_SANITIZE_NUMBER_INT);
    $mediator_id = filter_var($clean_mediator_id, FILTER_VALIDATE_INT);

    $clean_complainant_resident_id = filter_var($_POST['complainant_resident_id'], FILTER_SANITIZE_NUMBER_INT);
    $complainant_resident_id = filter_var($clean_complainant_resident_id, FILTER_VALIDATE_INT);

    $clean_respondent_resident_id = filter_var($_POST['respondent_resident_id'], FILTER_SANITIZE_NUMBER_INT);
    $respondent_resident_id = filter_var($clean_respondent_resident_id, FILTER_VALIDATE_INT);

    $clean_mediator_official_id = filter_var($_POST['mediator_official_id'], FILTER_SANITIZE_NUMBER_INT);
    $mediator_official_id = filter_var($clean_mediator_official_id, FILTER_VALIDATE_INT);

    $or_no = htmlspecialchars($_POST['receipt_number']);
    $for = htmlspecialchars(ucfirst(trim($_POST['for'])));
    $complaint_description = htmlspecialchars(ucfirst(trim($_POST['description'])));
    $date_of_hearing = htmlspecialchars($_POST['date_of_hearing']);
    $time_of_hearing = htmlspecialchars($_POST['time_of_hearing']);
    $action_taken = htmlspecialchars(ucfirst(trim($_POST['action_taken'])));
    $status = htmlspecialchars($_POST['status']);
}



// UPDATE COMPLAINANT
if ($complainant_resident_id) {
    $complainantQuery = "UPDATE complainant SET
    resident_id = :complainant_resident_id
    WHERE complainant_id = :complainant_id";

    $complainantStatement = $pdo->prepare($complainantQuery);
    $complainantStatement->bindParam(':complainant_resident_id', $complainant_resident_id);
    $complainantStatement->bindParam(':complainant_id', $complainant_id);
    $complainantStatement->execute();
}

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

$_SESSION['success'] = "Resident Complaint Updated Successfully";
header("location: ./../resident-complaint-view.php?case_no=$case_no");
