<?php
$headerTitle = 'Jobseeker Certificate';
$page = 'Certificate';

require_once "../../includes/header.php";
include "../../includes/preloader.php";

if (filter_has_var(INPUT_GET, 'jobseeker_id')) {
    $clean_jobseeker_id = filter_var($_GET['jobseeker_id'], FILTER_SANITIZE_NUMBER_INT);
    $jobseeker_id = filter_var($clean_jobseeker_id, FILTER_VALIDATE_INT);
}

?>

<main>
    <div class="content" id="content-certificates">
        <section class="certificates__info">
            <div class="card">
                <a class="button button--md back-btn">
                    <?php require "../../includes/back-button.php"; ?>
                </a>

                <?php
                $jobseekerQuery = "SELECT jc.*, r1.last_name, r1.first_name, r1.mid_name, r1.suffix, r2.last_name AS official_lastname, r2.first_name AS official_firstname, r2.mid_name AS official_midname, r2.suffix AS official_suffix, r1.img_url, r1.purok, r1.street, r1.lot_number FROM jobseeker_certificate jc 
                LEFT JOIN resident r1 ON r1.resident_id = jc.resident_id 
                LEFT JOIN official o ON o.official_id = jc.official_id
                LEFT JOIN resident r2 ON r2.resident_id = o.resident_id
                WHERE jc.jobseeker_id = :jobseeker_id ORDER BY jc.date_issued DESC";

                $jobseekerStatement = $pdo->prepare($jobseekerQuery);
                $jobseekerStatement->bindParam(':jobseeker_id', $jobseeker_id, PDO::PARAM_INT);
                $jobseekerStatement->execute();

                $jobseekerCount = $jobseekerStatement->rowCount();

                if ($jobseekerCount === 1) {
                    $jobseeker = $jobseekerStatement->fetch(PDO::FETCH_ASSOC);

                    $purok = $jobseeker['purok'] ? $jobseeker['purok'] . ', ' : '';
                    $street = $jobseeker['street'] ? $jobseeker['street'] . ', ' : '';
                    $lot_number = $jobseeker['lot_number'] ? $jobseeker['lot_number'] . ', ' : '';
                    $issued_by = $jobseeker['issued_by'];
                    $date_issued = $jobseeker['date_issued'];
                    $resident_image = $jobseeker['img_url'];
                ?>

                    <div class="info">
                        <h4><strong>Issued By:</strong></h4>
                        <div>
                            <?php echo $jobseeker['official_lastname'] ?>,
                            <?php echo $jobseeker['official_firstname'] ?>
                            <?php echo $jobseeker['official_midname'] ? mb_substr($jobseeker['official_midname'], 0, 1, 'UTF-8')  . "." : "" ?>
                            <?php echo $jobseeker['official_suffix'] ?>
                        </div>

                        <p><?php echo $issued_by ?></p>
                        <h4><strong>Date Issued:</strong></h4>
                        <p><?php echo date('m-d-Y', strtotime($date_issued)); ?></p>

                        <a class="button button--info button--md modal-trigger" data-modal-id="modal-jobseeker-history">
                            <i class='bx bxs-book-bookmark' data-modal-id="modal-jobseeker-history"></i>
                            HISTORY
                        </a>
                    </div>

                    <div class="card__body">
                        <div class="card__body-content">
                            <div class="profile__img profile__img--change">
                                <img src="../residents/images/<?php echo $resident_image ?>" name="default" alt="">
                            </div>

                            <div class="profile__name profile__name--viewprofile">
                                <?php echo $jobseeker['last_name'] ?>,
                                <?php echo $jobseeker['first_name'] ?>
                                <?php echo $jobseeker['mid_name'] ? mb_substr($jobseeker['mid_name'], 0, 1, 'UTF-8')  . "." : "" ?>
                                <?php echo $jobseeker['suffix'] ?>

                            </div>
                        </div>

                        <div class="row">
                            <div class="action__cert">
                                <?php if ($user_role === 'Administrator' || $user_role === 'Barangay Secretary' || $user_role === 'Barangay Clerk - Generate Clearance') : ?>
                                    <a href="regenerate/regenerate-jobseeker.php?jobseeker_id=<?php echo $jobseeker_id ?>" class="button button--info button--sm" id="regenerate-clearance" data-date-issued="<?php echo $jobseeker['date_issued'] ?>">
                                        <i class='bx bxs-file-blank'></i>
                                        REGENERATE
                                    </a>

                                <?php endif; ?>
                            </div>
                        </div>

                        <br>
                        <br>

                        <div class="certificates-info__content">
                            <section class="certificates-info">
                                <div class="certificates-info__container">
                                    <div class="input__wrapper">
                                        <label>Name</label>
                                        <div class="input__inner">
                                            <input disabled name="address" type="text" class="input--light300 input-viewprofile" value="<?php echo $jobseeker['last_name'] ?>, <?php echo $jobseeker['first_name'] ?> <?php echo $jobseeker['mid_name'] ? mb_substr($jobseeker['mid_name'], 0, 1, 'UTF-8')  . "." : "" ?><?php echo $jobseeker['suffix'] ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="certificates-info__container">
                                    <div class="input__wrapper">
                                        <label>Address</label>
                                        <div class="input__inner">
                                            <input disabled name="address" type="text" class="input--light300 input-viewprofile" value="<?php echo $purok ?> <?php echo $street ?> <?php echo $lot_number ?>Barangay Fatima, General Santos City">
                                        </div>
                                    </div>
                                </div>

                                <div class="certificates-info__container">
                                    <div class="input__wrapper">
                                        <label>Date Issued</label>
                                        <div class="input__inner">
                                            <input name="date_issued" class="input--light300 input-viewprofile" value="<?php echo $date_issued ?>" disabled>
                                        </div>
                                    </div>
                                </div>

                            </section>
                        </div>
                    </div>

                    <?php require './modals/history/jobseeker-history.php'; ?>
                <?php } ?>
            </div>
        </section>
    </div>
</main>
</body>

</html>