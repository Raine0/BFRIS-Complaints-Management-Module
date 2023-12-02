<?php

$page = 'Complaints';
$headerTitle = 'Non-Resident Complaints';

require "../../includes/header.php";
require "../../includes/preloader.php";

// include "filter.php";
// include "modal.php";

if (isset($_SESSION['user_id'])) {
    $user_role = $_SESSION['role'];
}

?>

<?php if (isset($_SESSION['success'])) { ?>

    <!-- ALERT -->`
    <div class="alert alert--success">
        <i class='bx bxs-check-square alert__icon'></i>
        <div class="alert__message">
            <?php
            $success = $_SESSION['success'];
            unset($_SESSION['success']);
            echo $success;
            ?>
        </div>
    </div>
<?php } ?>


<?php if (isset($_SESSION['error'])) { ?>
    <div class="alert alert--danger">
        <i class='bx bxs-error alert__icon'></i>
        <div class="alert__message">
            <?php
            $error = $_SESSION['error'];
            unset($_SESSION['error']);
            echo $error;
            ?>
        </div>
    </div>
<?php } ?>

<main>
    <div class="content">
        <section class="residents">

            <?php require '../../includes/back-button.php'; ?>

            <table id="table" class="row-border">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th>
                            <div class="residents__header-actions">

                                <button class="button button--warning button--md modal-trigger filter-btn" data-modal-id="modal-filter">
                                    <i class='bx bxs-filter-alt' data-modal-id="modal-filter"></i>
                                    <span>FILTER</span>
                                </button>

                                <?php if ($user_role === 'Barangay Clerk - Complaint Admin' || $user_role === 'Barangay Clerk - Complaint Encoder' || $user_role === 'Barangay Secretary' || $user_role === 'Administrator') : ?>
                                    <a class="button button--primary button--md certificates__button modal-trigger" data-modal-id="modal-respondent" id="add-non-resident-complaint">
                                        <i class='bx bx-plus' data-modal-id="modal-respondent"></i>
                                        <p data-modal-id="modal-respondent">ADD NEW</p>
                                    </a>
                                <?php endif; ?>

                                <?php if ($user_role === 'Barangay Clerk - Complaint Admin' || $user_role === 'Barangay Secretary' || $user_role === 'Administrator') : ?>

                                    <a class="button button--info button--md" id="export-resident">
                                        <i class='bx bxs-file-export'></i>
                                        <p>EXPORT</p>
                                    </a>
                                <?php endif; ?>

                                <div class="dropdown dropdown--export dropdown">
                                    <ul>
                                        <li class="dropdown__item">
                                            <a href="export/export-excel.php">
                                                <i class='bx bxs-spreadsheet'></i>
                                                Excel
                                            </a>
                                        </li>

                                        <li class="dropdown__item">
                                            <a href="export/export-landscape.php">
                                                <i class='bx bxs-file-pdf'></i>
                                                PDF Landscape
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $complaintQuery = "SELECT case_no, respondent_name, respondent_image FROM non_resident_complaint_view ORDER BY case_no DESC";

                    // $where_conditions = [];
                    // $where_conditions[] = $condition;
                    // // if filters are applied, add them to the where conditions
                    // if (empty($where_condition)) {

                    //     $residentQuery .= " ORDER BY complaint_id DESC";
                    // } else {
                    //     $where_clause = "WHERE " . implode(" ", $where_conditions);
                    //     $residentQuery .= " $where_clause";
                    // }

                    $complaintStatement = $pdo->query($complaintQuery);
                    $complaints = $complaintStatement->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($complaints as $complaint) {

                    ?>
                        <tr>
                            <td>
                                <a <?php if ($user_role === 'Administrator' || $user_role === 'Barangay Chairman' || $user_role === 'Barangay Secretary' || $user_role === 'Barangay Clerk - Complaint Admin' || $user_role === 'Barangay Clerk - Complaint Encoder') : ?> href="non-resident-complaint-view.php?case_no=<?php echo $complaint['case_no'] ?>" <?php endif; ?>>
                                    <div class="table__row-img">
                                        <img src="./../residents/images/<?php echo $complaint['respondent_image'] ?>" alt="">
                                    </div>
                                </a>
                            </td>
                            <td>
                                <a <?php if ($user_role === 'Administrator' || $user_role === 'Barangay Chairman' || $user_role === 'Barangay Secretary' || $user_role === 'Barangay Clerk - Complaint Admin' || $user_role === 'Barangay Clerk - Complaint Encoder') : ?> href="non-resident-complaint-view.php?case_no=<?php echo $complaint['case_no'] ?>" <?php endif; ?>>
                                    <div class="table__row-text">
                                        <div class="table__row-name">
                                            Respodent: <?php echo $complaint['respondent_name'] ?>
                                        </div>

                                        <div class="table__row-sub">
                                            <div>Case No: <?php echo $complaint['case_no'] ?></div>
                                        </div>
                                    </div>
                                </a>
                            </td>
                            <td>

                                <div class="table__action-buttons">
                                    <?php if ($user_role === 'Administrator' || $user_role === 'Barangay Chairman' || $user_role === 'Barangay Secretary' || $user_role === 'Barangay Clerk - Complaint Admin' || $user_role === 'Barangay Clerk - Complaint Encoder') : ?>

                                        <a href="non-resident-complaint-view.php?case_no=<?php echo $complaint['case_no'] ?>" class="button button--green button--sm action__view" id="action-view">
                                            <i class='bx bxs-show'></i>
                                            <p>VIEW COMPLAINT</p>

                                        </a>
                                    <?php endif; ?>

                                    <?php if ($user_role === 'Administrator'| $user_role === 'Barangay Secretary' || $user_role === 'Barangay Clerk - Complaint Admin' || $user_role === 'Barangay Clerk - Complaint Encoder') : ?>
                                        <a href="non-resident-complaint-update.php?case_no=<?php echo $complaint["case_no"]; ?>" class="button button--primary button--sm modal-trigger">
                                            <i class='bx bxs-edit'></i>
                                            EDIT COMPLAINT
                                        </a>
                                    <?php endif; ?>

                                    <?php if ($user_role === 'Administrator' || $user_role === 'Barangay Secretary' || $user_role === 'Barangay Clerk - Resident Admin') : ?>
                                        <div class="action__cert">
                                            <button class="button button--info button--sm dropdownBtn" id="action-cert">
                                                <i class='bx bxs-file-blank'></i>
                                                GENERATE INVITATION
                                            </button>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </section>
    </div>
</main>

<?php
require "modal/mediator.php";
require "modal/respondent.php";
?>

</body>

</html>