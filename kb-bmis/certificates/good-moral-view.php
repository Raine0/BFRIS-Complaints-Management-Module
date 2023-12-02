<?php
$headerTitle = 'Good Moral Certificate';
$page = 'Certificate';

require_once "../../includes/header.php";
include "../../includes/preloader.php";

if (filter_has_var(INPUT_GET, 'good_moral_id')) {
    $clean_goodmoral_id = filter_var($_GET['good_moral_id'], FILTER_SANITIZE_NUMBER_INT);
    $good_moral_id = filter_var($clean_goodmoral_id, FILTER_VALIDATE_INT);
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
                $goodmoralQuery = "SELECT good_moral_certificate_view.*, resident_id, resident_name, official_name, address, resident_image FROM good_moral_certificate_view
                WHERE good_moral_id = :good_moral_id ORDER BY date_issued DESC";

                $goodmoralStatement = $pdo->prepare($goodmoralQuery);
                $goodmoralStatement->bindParam(':good_moral_id', $good_moral_id, PDO::PARAM_INT);
                $goodmoralStatement->execute();

                $goodmoralCount = $goodmoralStatement->rowCount();

                if ($goodmoralCount === 1) {
                    $goodmoral = $goodmoralStatement->fetch(PDO::FETCH_ASSOC);

                    $good_moral_id = $goodmoral['good_moral_id'];
                    $resident_name = $goodmoral['resident_name'];
                    $official_name = $goodmoral['official_name'];
                    $address = $goodmoral['address'];
                    $purpose = $goodmoral['purpose'];
                    $issued_by = $goodmoral['issued_by'];
                    $date_issued = $goodmoral['date_issued'];
                    $resident_image = $goodmoral['resident_image'];
                ?>

                    <div class="info">
                        <h4><strong>Issued By:</strong></h4>
                        <div>
                            <?php echo $official_name ?>
                        </div>
                        <p><?php echo $issued_by ?></p>
                        <h4><strong>Date Issued:</strong></h4>
                        <p><?php echo date('m-d-Y', strtotime($date_issued)); ?></p>

                        <a class="button button--info button--md modal-trigger" data-modal-id="modal-good-moral-history">
                            <i class='bx bxs-book-bookmark' data-modal-id="modal-good-moral-history"></i>
                            HISTORY
                        </a>
                    </div>

                    <div class="card__body">
                        <div class="card__body-content">
                            <div class="profile__img profile__img--change">
                                <img src="../residents/images/<?php echo $resident_image ?>" name="default" alt="">
                            </div>

                            <div class="profile__name profile__name--viewprofile">
                                <?php echo $resident_name ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="action__cert">
                                <?php if ($user_role === 'Administrator' || $user_role === 'Barangay Secretary' || $user_role === 'Barangay Clerk - Generate Clearance') : ?>
                                    <a href="regenerate/regenerate-good-moral.php?good_moral_id=<?php echo $good_moral_id ?>" class="button button--info button--sm" id="regenerate-clearance" data-date-issued="<?php echo $goodmoral['date_issued'] ?>">
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
                                            <input disabled name="address" type="text" class="input--light300 input-viewprofile" value="<?php echo $resident_name ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="certificates-info__container">
                                    <div class="input__wrapper">
                                        <label>Address</label>
                                        <div class="input__inner">
                                            <input disabled name="address" type="text" class="input--light300 input-viewprofile" value="<?php echo $address ?>">
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

                                <div class="certificates-info__container">
                                    <div class="input__wrapper">
                                        <label>Purpose </label>
                                        <div class="input__inner">
                                            <input name="purpose" type="text" class="input--light300 input-viewprofile" value="<?php echo $purpose ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>

                    <?php require './modals/history/good-moral-history.php'; ?>
                <?php } ?>
            </div>
        </section>
    </div>
</main>
</body>

</html>