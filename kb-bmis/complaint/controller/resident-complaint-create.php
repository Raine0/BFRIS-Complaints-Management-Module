<?php
session_start();

require '../../../db_conn.php';

$role = $_SESSION['role'];
$username = ucwords($_SESSION['username']);
$created_by = $username . '(' . $role . ')';

if (!filter_has_var(INPUT_POST, 'submit')) {
    header("location: ./../resident-complaint-create.php");
    exit();
}

$clean_complainant_resident_id = filter_var($_POST['complainant-id'], FILTER_SANITIZE_NUMBER_INT);
$complainant_resident_id = filter_var($clean_complainant_resident_id, FILTER_VALIDATE_INT);

$clean_respondent_resident_id = filter_var($_POST['respondent-id'], FILTER_SANITIZE_NUMBER_INT);
$respondent_resident_id = filter_var($clean_respondent_resident_id, FILTER_VALIDATE_INT);

$clean_mediator_official_id = filter_var($_POST['mediator-id'], FILTER_SANITIZE_NUMBER_INT);
$mediator_official_id = filter_var($clean_mediator_official_id, FILTER_VALIDATE_INT);

$clean_mediator_resident_id = filter_var($_POST['official-resident-id'], FILTER_SANITIZE_NUMBER_INT);
$mediator_resident_id = filter_var($clean_mediator_resident_id, FILTER_VALIDATE_INT);

$or_no = htmlspecialchars($_POST['receipt_number']);
$for = htmlspecialchars(ucfirst(trim($_POST['for'])));
$complaint_description = htmlspecialchars(ucfirst(trim($_POST['description'])));
$date_of_hearing = htmlspecialchars($_POST['date_of_hearing']);
$time_of_hearing = htmlspecialchars($_POST['time_of_hearing']);
$status = htmlspecialchars($_POST['status']);
$action_taken = htmlspecialchars(ucfirst(trim($_POST['action_taken'])));
$is_complainant_resident = 1;



//INSERT COMPLAINANT
$insertcomplainantQuery = "INSERT INTO complainant (
    resident_id
    )
    VALUES (
    :resident_id
)";

$complainantStatement = $pdo->prepare($insertcomplainantQuery);
$complainantStatement->bindParam(':resident_id', $complainant_resident_id, PDO::PARAM_INT);
$complainantStatement->execute();
$complainant_id = $pdo->lastInsertId();

//INSERT RESPONDENT
$insertrespondentQuery = "INSERT INTO respondent (
    resident_id
    )
    VALUES (
    :resident_id
)";

$respondentStatement = $pdo->prepare($insertrespondentQuery);
$respondentStatement->bindParam(':resident_id', $respondent_resident_id, PDO::PARAM_INT);
$respondentStatement->execute();
$respondent_id = $pdo->lastInsertId();


//INSERT MEDIATOR
$insertmediatorQuery = "INSERT INTO mediator (
    resident_id,
    official_id
    )
    VALUES (
    :resident_id,
    :official_id
)";

$mediatorStatement = $pdo->prepare($insertmediatorQuery);
$mediatorStatement->bindParam(':resident_id', $mediator_resident_id);
$mediatorStatement->bindParam(':official_id', $mediator_official_id);
$mediatorStatement->execute();
$mediator_id = $pdo->lastInsertId();


//INSERT COMPLAINT
$insertcomplaintQuery = "INSERT INTO complaint (
    complainant_id,
    respondent_id,
    mediator_id,
    or_no,
    reason,
    complaint_description,
    date_of_hearing,
    time_of_hearing,
    action_taken,
    complaint_status,
    is_complainant_resident,
    created_by
    )
    VALUES (
    :complainant_id,
    :respondent_id,
    :mediator_id,
    :or_no,
    :reason,
    :complaint_description,
    :date_of_hearing,
    :time_of_hearing,
    :action_taken,
    :complaint_status,
    :is_complainant_resident,
    :created_by
)";

$complaintStatement = $pdo->prepare($insertcomplaintQuery);
$complaintStatement->bindParam(':complainant_id', $complainant_id, PDO::PARAM_INT);
$complaintStatement->bindParam(':respondent_id', $respondent_id, PDO::PARAM_INT);
$complaintStatement->bindParam(':mediator_id', $mediator_id, PDO::PARAM_INT);
$complaintStatement->bindParam(':or_no', $or_no);
$complaintStatement->bindParam(':reason', $for);
$complaintStatement->bindParam(':complaint_description', $complaint_description);
$complaintStatement->bindParam(':date_of_hearing', $date_of_hearing);
$complaintStatement->bindParam(':time_of_hearing', $time_of_hearing);
$complaintStatement->bindParam(':action_taken', $action_taken);
$complaintStatement->bindParam(':complaint_status', $status);
$complaintStatement->bindParam(':is_complainant_resident', $is_complainant_resident);
$complaintStatement->bindParam(':created_by', $created_by);
$complaintStatement->execute();
$case_no = $pdo->lastInsertId();

$_SESSION['success'] = "Resident Complaint Created Successfully";
header("location: ./../resident-complaint-list.php?case_no=$case_no");
