<?php
$page = 'Complaints';
$headerTitle = 'View Complaint';
require "./../../includes/header.php";
require "./../../includes/preloader.php";

if (filter_has_var(INPUT_GET, 'case_no')) {
    $clean_case_no = filter_var($_GET['case_no'], FILTER_SANITIZE_NUMBER_INT);
    $case_no = filter_var($clean_case_no, FILTER_VALIDATE_INT);

    $complaintQuery = "SELECT * FROM resident_complaint_view WHERE case_no = :case_no";
    $complaintStatement = $pdo->prepare($complaintQuery);
    $complaintStatement->bindParam(':case_no', $case_no);
    $complaintStatement->execute();

    $complaintCount = $complaintStatement->rowCount();

    if (!$complaintCount === 1) {
        $_SESSION['error'] = "Complaint Record Nor Found";
        header("location: ./../resident-complaint-list.php");
    }
    $complaint = $complaintStatement->fetch(PDO::FETCH_ASSOC);
}
?>

<main>
    <div class="content">
        <form id="form" method="POST" action="" enctype="multipart/form-data" data-parsley-validate="">
            <div>
                <div class="card">
                    <a class="button button--md back-btn">
                        <?php require '../../includes/back-button.php'; ?>
                    </a>

                    <div class="info">
                        <h4><strong>Created By:</strong></h4>
                        <p><?php echo $complaint['created_by']; ?></p>
                        <h4><strong>Date Created:</strong></h4>
                        <p><?php echo date('m-d-Y h:i:s a', strtotime($complaint['date_created'])); ?></p>
                        <?php if ($complaint['updated_by'] != null) : ?>
                            <h4><strong>Updated By:</strong></h4>
                            <p><?php echo $complaint['updated_by']; ?></p>
                            <h4><strong>Date Updated:</strong></h4>
                            <p><?php echo date('m-d-Y h:i:s a', strtotime($complaint['date_updated'])); ?></p>
                        <?php endif; ?>

                        <?php if ($user_role === 'Administrator' || $user_role === 'Barangay Secretary' || $user_role === 'Barangay Clerk - Complaint Admin') : ?>
                        <a class="button button--info button--md modal-trigger" data-modal-id="modal-case-history">
                            <i class='bx bxs-book-bookmark' data-modal-id="modal-case-history"></i>
                            CASE HISTORY
                        </a>
                        <?php endif; ?>

                        <?php if ($user_role === 'Administrator' || $user_role === 'Barangay Secretary' || $user_role === 'Barangay Clerk - Complaint Admin') : ?>
                        <a class="button button--info button--md modal-trigger" data-modal-id="modal-complaint-history">
                            <i class='bx bxs-book-bookmark' data-modal-id="modal-complaint-history"></i>
                            HISTORY
                        </a>
                        <?php endif; ?>
                    </div>

                    <div class="card__body">
                        <div class=" card__body-content">
                            <div class="profile__img profile__img--viewprofile">
                                <img src="./../residents/images/<?php echo $complaint["respondent_image"]; ?>" alt="">
                            </div>

                            <div class="profile__name profile__name--viewprofile">
                                <?php echo $complaint['respondent_name'] ?>
                            </div>

                            <div class="row">
                                <?php if ($user_role === 'Administrator' || $user_role === 'Barangay Secretary' || $user_role === 'Barangay Clerk - Complaint Admin' || $user_role === 'Barangay Clerk - Complaint Encoder') : ?>
                                    <a href="./resident-complaint-update.php?case_no=<?php echo $complaint["case_no"]; ?>" class="button button--primary button--sm">
                                        <i class='bx bxs-edit'></i>
                                        Edit Complaint
                                    </a>
                                <?php endif; ?>

                                <?php if ($user_role == 'Barangay Clerk - Complaint Admin' || $user_role == 'Barangay Secretary' || $user_role == 'Administrator') : ?>
                                    <div class="action__cert">
                                        <button class="button button--info button--sm dropdownBtn" id="action-cert">
                                            <i class='bx bxs-file-blank'></i>
                                            GENERATE INVITATION
                                        </button>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <ul class="profile-info__list">
                                <li class="profile-info__item profile-info__item--active basicInfoTab">
                                    <span>
                                        Basic Information
                                    </span>
                                </li>

                                <li class="profile-info__item statementTab">
                                    <span>
                                        Statement
                                    </span>
                                </li>

                            </ul>

                            <div class="profile-info__content basicInfoTab" style="display: block;">

                                <br>
                                <div class="profile-info__sub-section">
                                    Complainant
                                </div>
                                <br>

                                <section class="profile-info__basic-info">
                                    <div class="profile-info__container">
                                        <div class="input__wrapper">
                                            <label for="complainant">Complainant's Name</label>
                                            <div class="input__inner">
                                                <input type="text" name="complainant" id="complainant" class="input--light300" value="<?php echo $complaint['complainant_name']  ?>" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="profile-info__container">
                                        <div class="input__wrapper">
                                            <label for="complainant-address">Address</label>
                                            <div class="input__inner">
                                                <input type="text" name="complainant_address" id="complainant-address" class="input--light300 input-viewprofile" value="<?php echo $complaint['complainant_address'] ?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                                <br>
                                <div class="profile-info__sub-section">
                                    Respondent
                                </div>
                                <br>

                                <section class="profile-info__basic-info">
                                    <div class="profile-info__container">
                                        <div class="input__wrapper">
                                            <label for="respondent">Respondent's Name</label>
                                            <div class="input__inner">
                                                <input type="text" name="respondent" id="respondent" class="input--light300" value="<?php echo $complaint['respondent_name'] ?>" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="profile-info__container">
                                        <div class="input__wrapper">
                                            <label for="respondent-address">Address</label>
                                            <div class="input__inner">
                                                <input type="text" name="respondent_address" id="respondent-address" class="input--light300 input-viewprofile" value="<?php echo $complaint['respondent_address'] ?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                                <br>
                                <div class="profile-info__sub-section">
                                    Mediator
                                </div>
                                <br>

                                <section class="profile-info__basic-info">
                                    <div class="profile-info__container">
                                        <div class="input__wrapper">
                                            <label for="mediator">Mediator's Name</label>
                                            <div class="input__inner">
                                                <input type="text" name="mediator" id="mediator" class="input--light300" value="<?php echo $complaint['mediator_name'] ?>" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- <div class="profile-info__container">
                                        <div class="input__wrapper">
                                            <label for="off_position">Position</label>
                                            <div class="input__inner">
                                                <input type="text" name="off_position" id="off_position" class="input--light300" value="<?php echo $complaint['off_position'] ?>" disabled>
                                            </div>
                                        </div>
                                    </div> -->
                                </section>

                                <br>
                                <div class="profile-info__sub-section">
                                    Complaint Information
                                </div>
                                <br>

                                <section class="profile-info__basic-info">
                                    <div class="certificates-info__container">
                                        <div class="input__wrapper">
                                            <label>O.R No. <small style="font-style: italic">(i.e. 2342343A) </small></label>
                                            <div class="input__inner">
                                                <input type="text" name="receipt_number" class="input--light300 input-viewprofile" maxlength="8" value="<?php echo $complaint['or_no'] ?>" disabled />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="profile-info__container">
                                        <div class="input__wrapper">
                                            <label for="for">FOR </label>
                                            <div class="input__inner">
                                                <input type="text" name="for" id="for" class="input--light300" value="<?php echo $complaint['reason'] ?>" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Adjust time -->
                                    <div class="profile-info__container">
                                        <div class="input__wrapper">
                                            <label>Date of Hearing </label>
                                            <div class="input__inner">
                                                <input name="date_of_hearing" type="date" class="input--light300 input-viewprofile" value="<?php echo $complaint['date_of_hearing'] ?>" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="profile-info__container">
                                        <div class="input__wrapper">
                                            <label>Time of Hearing </label>
                                            <div class="input__inner">
                                                <input name="time_of_hearing" type="time" class="input--light300 input-viewprofile" value="<?php echo $complaint['time_of_hearing'] ?>" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="profile-info__container">
                                        <div class="input__wrapper">
                                            <label for="status">Status </label>
                                            <div class="input__inner">
                                                <input name="status" id="status" class="input--light300" value="<?php echo $complaint['complaint_status'] ?>" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="profile-info__container">
                                        <div class="input__wrapper">
                                            <label for="action-taken">Action Taken</label>
                                            <div class="input__inner">
                                                <textarea name="action_taken" id="action-taken" class="input--light300" value="<?php echo $complaint['action_taken'] ?>" disabled><?php echo $complaint['action_taken'] ?>
                                                </textarea>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                                <div class="pagination__buttons">
                                    <span class="pagination__button next" data-current-tab="basicInfoTab" data-next-tab="statementTab">Next<i class='bx bx-chevron-right'></i></span>
                                </div>
                            </div>

                            <div class="profile-info__content statementTab">
                                <section class="profile-info__basic-info">
                                    <div class="profile-info__container">
                                        <div class="input__wrapper">
                                            <label for="description">I/WE hereby complaint against the named respondents for violating my/our rights and interest in the following manner.</label>
                                            <div class="input__inner">
                                                <textarea name="description" id="description" class="input--light300" value="<?php echo $complaint['complaint_description'] ?>" disabled><?php echo $complaint['complaint_description'] ?>
                                                </textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="profile-info__container">
                                        <div class="input__wrapper">
                                            <label for="grant">THEREFORE, I/WE pray that the following reliefs be granted on me/us in accordance with law and/or equity.</label>
                                            <div class="input__inner">
                                                <textarea name="grant" id="grant" class="input--light300" disabled>
                                            </textarea>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                                <div class="pagination__buttons">
                                    <span class="pagination__button prev" data-current-tab="statementTab" data-next-tab="basicInfoTab"><i class='bx bx-chevron-left'></i>Prev</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php require './modal/complaint-history.php'; ?>
    <?php require './modal/case-history.php'; ?>
</main>

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
</body>

</html>