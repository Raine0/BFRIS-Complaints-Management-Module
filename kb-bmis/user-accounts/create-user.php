<?php
$headerTitle = 'Add New User';
$page = 'User';

require_once "../../includes/header.php";
require "../../includes/preloader.php";
require "../../includes/modal-cancel.php";


if (filter_has_var(INPUT_GET, 'resident_id') && filter_has_var(INPUT_GET, 'official_id')) {
    $sanitize_resident_id = filter_var($_GET['resident_id'], FILTER_SANITIZE_NUMBER_INT);
    $resident_id = filter_var($sanitize_resident_id, FILTER_SANITIZE_NUMBER_INT);

    $sanitize_official_id = filter_var($_GET['official_id'], FILTER_SANITIZE_NUMBER_INT);
    $official_id = filter_var($sanitize_official_id, FILTER_SANITIZE_NUMBER_INT);
}

$officialQuery =  "SELECT o.off_position, r.first_name, r.last_name, r.mid_name, r.suffix, r.img_url FROM official o 
LEFT JOIN resident r ON
o.resident_id = r.resident_id
WHERE o.official_id = :official_id AND r.resident_id= :resident_id";
$officialStatement = $pdo->prepare($officialQuery);
$officialStatement->bindParam(':official_id', $official_id, PDO::PARAM_INT);
$officialStatement->bindParam(':resident_id', $resident_id, PDO::PARAM_INT);
$officialStatement->execute();
$countOfficial = $officialStatement->rowCount();

if ($countOfficial === 1) {
    $official = $officialStatement->fetch(PDO::FETCH_ASSOC);

?>
    <form action="controller/create.php" method="POST" enctype="multipart/form-data" data-parsley-validate="">
        <main>
            <div class="content">
                <div class="card">
                    <a href="#" class="button button--md back-btn modal-trigger" data-modal-id="modal-cancel">
                        <i class='bx bx-left-arrow-circle' data-modal-id="modal-cancel"></i>
                        Back
                    </a>

                    <div class="card__body">
                        <div class="card__body-content">
                            <div class="profile__img profile__img--viewprofile">
                                <img src="../residents/images/<?php echo $official['img_url'] ?>" alt="">
                            </div>

                            <div class="profile__name profile__name--viewprofile">
                                <?php echo $official['last_name'] ?>,
                                <?php echo $official['first_name'] ?>
                                <?php echo $official['mid_name'] ? mb_substr($official['mid_name'], 0, 1, 'UTF-8') . "." : "" ?>
                                <?php echo $official['suffix'] ?>
                            </div>

                            <ul class="profile-info__list viewprofile">
                                <li class="profile-info__item profile-info__item--active">
                                    <span>
                                        Basic Information
                                    </span>
                                </li>
                            </ul>

                            <div class="profile-info__content viewprofile" style="display: block;">
                                <section class="profile-info__basic-info">
                                    <input name="resident_id" type="text" value="<?php echo $resident_id ?>" hidden>

                                    <input name="official_id" type="text" value="<?php echo $official_id ?>" hidden>

                                    <!-- <input name="off_name" type="text" value="<?php echo $resident["last_name"] . ", " . $resident["first_name"] .  " " . $resident["suffix"];  ?>" hidden> -->

                                    <div class="profile-info__container">
                                        <div class="input__wrapper">
                                            <label for="official-position">Position</label>
                                            <div class="input__inner">
                                                <input type="text" value="<?php echo $official['off_position'] ?>" class="input--light300" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="profile-info__container">
                                        <div class="input__wrapper">
                                            <label for="official-role">Official Role</label>
                                            <div class="input__inner">
                                                <div class="select__wrapper">
                                                    <select name="role" id="official-role" class="select select--resident-profile input-viewprofile" required>
                                                        <option hidden disabled value="" selected>Select</option>
                                                        <?php if ($official['off_position'] !== 'Barangay Clerk') : ?>
                                                            <option value="Barangay Chairman">Barangay Chairman</option>
                                                            <option value="Barangay Secretary">Barangay Secretary</option>
                                                        <?php elseif ($official['off_position'] === 'Barangay Clerk') : ?>
                                                            <option value="Barangay Clerk - Resident Admin">Barangay Clerk - Resident Admin</option>
                                                            <option value="Barangay Clerk - Resident Encoder">Barangay Clerk - Resident Encoder</option>
                                                            <option value="Barangay Clerk - Generate Clearance">Barangay Clerk - Generate Clearance</option>
                                                            <option value="Barangay Clerk - Complaint Admin">Barangay Clerk - Complaint Admin</option>
                                                            <option value="Barangay Clerk - Complaint Encoder">Barangay Clerk - Complaint Encoder</option>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="profile-info__container">
                                        <div class="input__wrapper">
                                            <label for="username">Username</label>
                                            <div class="input__inner">
                                                <input type="text" name="username" id="username" class="input--light300" requried>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="profile-info__container">
                                        <div class="input__wrapper">
                                            <label for="password">Password</label>
                                            <div class="input__inner">
                                                <input type="password" name="password" id="password" class="input--light300" required>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card__footer">
                    <div class="card__footer-content">
                        <div class="card__footer-content--right">
                            <button class="button button--primary button--md" name="btn_save">SAVE</button>
                            <a class="button button--dark button--md modal-trigger" data-modal-id="modal-cancel">CANCEL</a>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </main>
    </form>

<?php } ?>

<?php if (isset($_SESSION['error'])) { ?>
    <!-- ALERT -->
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

</body>

</html>