<?php
session_start();

require './../../../db_conn.php';

$role = $_SESSION['role'];
$username = ucwords($_SESSION['username']);
$created_by = $username . '(' . $role . ')';

if (!filter_has_var(INPUT_POST, 'submit')) {
    header("location: ./../resident-complaint-create.php");
    exit();
}

$clean_respondent_resident_id = filter_var($_POST['respondent-id'], FILTER_SANITIZE_NUMBER_INT);
$respondent_resident_id = filter_var($clean_respondent_resident_id, FILTER_VALIDATE_INT);

$clean_mediator_official_id = filter_var($_POST['mediator-id'], FILTER_SANITIZE_NUMBER_INT);
$mediator_official_id = filter_var($clean_mediator_official_id, FILTER_VALIDATE_INT);

$clean_mediator_resident_id = filter_var($_POST['official-resident-id'], FILTER_SANITIZE_NUMBER_INT);
$mediator_resident_id = filter_var($clean_mediator_resident_id, FILTER_VALIDATE_INT);

$first_name = htmlspecialchars(ucwords(trim($_POST['first_name'])));
$mid_name = htmlspecialchars(ucwords(trim($_POST['mid_name'])));
$last_name = htmlspecialchars(ucwords(trim($_POST['last_name'])));
$suffix = htmlspecialchars(ucwords(trim($_POST['suffix'])));
$purok = htmlspecialchars(ucwords(trim($_POST['purok'])));
$barangay = htmlspecialchars(ucwords(trim($_POST['barangay'])));
$city = htmlspecialchars(trim(ucwords($_POST['city'])));
$province = htmlspecialchars(ucwords(trim($_POST['province'])));
$or_no = htmlspecialchars($_POST['receipt_number']);
$for = htmlspecialchars(ucfirst(trim($_POST['for'])));
$complaint_description = htmlspecialchars(ucfirst(trim($_POST['description'])));
$date_of_hearing = htmlspecialchars($_POST['date_of_hearing']);
$time_of_hearing = htmlspecialchars($_POST['time_of_hearing']);
$action_taken = htmlspecialchars(ucfirst(trim($_POST['action_taken'])));
$status = htmlspecialchars($_POST['status']);
$is_complainant_resident = 0;


//INSERT NON-RESIDENT
$nonresidentQuery = "INSERT INTO non_resident (
    first_name,
    mid_name,
    last_name,
    suffix,
    purok,
    barangay,
    city,
    province,
    created_by
    )
    VALUES (
    :first_name,
    :mid_name,
    :last_name,
    :suffix,
    :purok,
    :barangay,
    :city,
    :province,
    :created_by
)";

$nonResidentStatement = $pdo->prepare($nonresidentQuery);
$nonResidentStatement->bindParam(':first_name', $first_name);
$nonResidentStatement->bindParam(':mid_name', $mid_name);
$nonResidentStatement->bindParam(':last_name', $last_name);
$nonResidentStatement->bindParam(':suffix', $suffix);
$nonResidentStatement->bindParam(':purok', $purok);
$nonResidentStatement->bindParam(':city', $city);
$nonResidentStatement->bindParam(':barangay', $barangay);
$nonResidentStatement->bindParam(':province', $province);
$nonResidentStatement->bindParam(':created_by', $created_by);
$nonResidentStatement->execute();
$non_resident_id = $pdo->lastInsertId();


//INSERT COMPLAINANT
$insertcomplainantQuery = "INSERT INTO complainant (
    non_resident_id
    )
    VALUES (
    :non_resident_id
)";

$complainantStatement = $pdo->prepare($insertcomplainantQuery);
$complainantStatement->bindParam(':non_resident_id', $non_resident_id, PDO::PARAM_INT);
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
    )
";

$complaintStatement = $pdo->prepare($insertcomplaintQuery);
$complaintStatement->bindParam('complainant_id', $complainant_id, PDO::PARAM_INT);
$complaintStatement->bindParam('respondent_id', $respondent_id, PDO::PARAM_INT);
$complaintStatement->bindParam('mediator_id', $mediator_id, PDO::PARAM_INT);
$complaintStatement->bindParam('or_no', $or_no);
$complaintStatement->bindParam('reason', $for);
$complaintStatement->bindParam('complaint_description', $complaint_description);
$complaintStatement->bindParam('date_of_hearing', $date_of_hearing);
$complaintStatement->bindParam('time_of_hearing', $time_of_hearing);
$complaintStatement->bindParam('action_taken', $action_taken);
$complaintStatement->bindParam('complaint_status', $status);
$complaintStatement->bindParam('is_complainant_resident', $is_complainant_resident);
$complaintStatement->bindParam('created_by', $created_by);
$complaintStatement->execute();
$case_no = $pdo->lastInsertId();

$_SESSION['success'] = "Complaint Created Successfully";
header("location: ./../non-resident-complaint-view.php?case_no=$case_no");
