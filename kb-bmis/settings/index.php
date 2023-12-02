<?php
$page = 'Fee Settings';
$headerTitle = 'Fee Settings';

require_once "../../includes/header.php";
include "../../includes/preloader.php";
?>
<main>
    <div class="content">
        <section class="settings">
            <table id="table" class="row-border">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>
                            <?php if ($user_role === 'Administrator' || $user_role === 'Barangay Secretary') : ?>
                                <div class="residents__header-actions">
                                    <a href="create-fee.php" class="button button--primary button--md">
                                        <i class='bx bx-plus'></i>
                                        <p>ADD NEW</p>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $settingQuery = "SELECT * FROM fee_view ORDER BY certificate_type, certificate_purpose";

                    $settingStatement = $pdo->query($settingQuery);
                    $settings = $settingStatement->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($settings as $setting) {

                    ?>
                        <tr>
                            <td>
                                <div class="input__wrapper">
                                    <label><?php echo $setting['certificate_type'] ?> Fee:</label>
                                    <div class="input__inner input__inner--with-leading-icon">
                                        <i class="input__icon input__icon--leading">₱</i>
                                        <input disabled name="barangay_clearance_fee" type="text" class="input--light300 input-viewprofile" value="<?php echo $setting['fee'] ?>" required>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <?php if ($setting['certificate_purpose']) : ?>
                                    <div class="input__wrapper">
                                        <label>Purpose:</label>
                                        <div class="input__inner">
                                            <input disabled name="certificate_purpose" type="text" class="input--light300 input-viewprofile" value="<?php echo $setting['certificate_purpose'] ?>">
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if ($setting['certificate_category']) : ?>
                                    <div class="input__wrapper">
                                        <label>Category:</label>
                                        <div class="input__inner">
                                            <input disabled name="certificate_category" type="text" class="input--light300 input-viewprofile" value="<?php echo $setting['certificate_category'] ?>">
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </td>

                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <?php if ($user_role === 'Administrator' || $user_role === 'Barangay Secretary') : ?>
                                    <div class="table__action-buttons">
                                        <a class="button button--info button--sm modal-trigger" data-modal-id="modal-edit-<?php echo $setting['fee_setting_id'] ?>">
                                            <i class='bx bxs-edit'></i>
                                            EDIT FEE
                                        </a>

                                        <a href="./view-changelog.php?certificate_type_id=<?php echo $setting['certificate_type_id'] ?>" class="button button--green button--sm" id="changelog">
                                            <i class='bx bxs-file'></i>
                                            VIEW CHANGELOG
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <?php require './modal/edit-fee-modal.php'; ?>
                    <?php } ?>
                </tbody>
            </table>
        </section>
    </div>

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

    <?php if (isset($_SESSION['duplicate'])) : ?>
        <!-- ALERT -->
        <div class="alert alert--danger">
            <i class='bx bxs-error alert__icon'></i>
            <div class="alert__message">
                <?php
                $error = $_SESSION['duplicate'];
                // Unset the error message from the GET parameter
                unset($_SESSION['duplicate']);
                // Display the error message
                echo $error;
                ?>
            </div>
        </div>
    <?php endif; ?>
</main>
</body>

</html>