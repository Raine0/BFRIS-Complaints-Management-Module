<?php
ob_start();
$page = 'Fee Settings';
$headerTitle = 'Edit Fee Settings';
require_once "../../includes/header.php";
include "../../includes/preloader.php";

$role = $_SESSION['role'];
$username = $_SESSION['username'];

$updated_by = ucwords($username) . '(' . $role . ')';

if (filter_has_var(INPUT_POST, 'password') && filter_has_var(INPUT_POST, 'fee_setting_id')) {
    $password = htmlspecialchars(md5($_POST['password']));
    $clean_fee_setting_id = filter_var($_POST['fee_setting_id'], FILTER_SANITIZE_NUMBER_INT);
    $fee_setting_id = filter_var($clean_fee_setting_id, FILTER_VALIDATE_INT);
}

$adminQuery = "SELECT * FROM users WHERE username = :username AND password = :password";
$adminStatement = $pdo->prepare($adminQuery);
$adminStatement->bindParam(':username', $username);
$adminStatement->bindParam(':password', $password);
$adminStatement->execute();
$adminCount = $adminStatement->rowCount();


if ($adminCount !== 1) {
    $_SESSION['error'] = "Incorrect password.";
    header("location: ./");
    exit;
}

$feeQuery = "SELECT * FROM fee_view WHERE fee_setting_id = :fee_setting_id";
$feeStatement = $pdo->prepare($feeQuery);
$feeStatement->bindParam(':fee_setting_id', $fee_setting_id);
$feeStatement->execute();
$fee = $feeStatement->fetch(PDO::FETCH_ASSOC);

$clearancePurposes = array(
    "Motorcycle Loan",
    "Pag-asa Loan",
    "Asa Loan",
    "Mediatrix Loan",
    "Light Micro Loan",
    "Application Loan",
    "Employment",
    "Postal ID",
    "Water Connection",
    "DepEd Requirement",
    "Identification",
    "SSS Requirement",
    "BIR Requirement",
    "Driver's License",
    "Security License",
    "Others"
);

$residencyPurposes = array(
    "Identification",
    "Water Connection",
    "PC",
    "Loan",
    "Co-maker",
    "Bailbond",
    "DSWD Financial Assistance",
    "4PS Requirement",
    "CHED Scholarship",
    "DOST Scholarship",
    "UNIFAST Scholarship",
    "GSIS Scholarship",
    "Others"
);

?>

<main>
    <div class="content">
        <section class="residents">
            <form action="./controller/update.php" method="POST" enctype="multipart/form-data" data-parsley-validate="">

                <div class="card">
                    <a href="#" class="button button--md back-btn modal-trigger" data-modal-id="modal-cancel">
                        <i class='bx bx-left-arrow-circle' data-modal-id="modal-cancel"></i>
                        Back
                    </a>

                    <div class="card__body" style="margin-top: 50px;">
                        <div class="card__body-content">
                            <div class="profile-info__content viewprofile" style="display: block;">
                                <section class="profile-info__basic-info">
                                    <div class="profile-info__container">

                                        <?php
                                        $certificateTypeQuery = "SELECT * FROM certificate_type";
                                        $certificateTypeStatement = $pdo->query($certificateTypeQuery);

                                        $certificates = $certificateTypeStatement->fetchAll(PDO::FETCH_ASSOC);

                                        ?>

                                        <div class="input__wrapper">
                                            <label for="certificate-type">Type Of Certificate <strong style="color:red;">*</strong></label>
                                            <div class="input__inner">
                                                <div class="select__wrapper">
                                                    <select name="certificate_type" id="certificate-type" class="select select--resident-profile" onchange="showCertificatePurpose('certificate-type', 'certificates')" required autofocus>

                                                        <?php
                                                        foreach ($certificates as $certificate) :
                                                        ?>

                                                            <option <?php if ($fee['certificate_type'] === $certificate['certificate_type']) : ?> selected <?php endif; ?> value="<?php echo $certificate['certificate_type'] ?>"><?php echo $certificate['certificate_type'] ?></option>

                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="profile-info__container" id="clearance-purpose-container" <?php if ($fee['certificate_type'] !== 'Barangay Clearance') : ?> style="display: none;" <?php endif; ?>>
                                        <div class="input__wrapper">
                                            <label>Purpose <strong style="color:red;">*</strong></label>
                                            <div class="input__inner">
                                                <div class="select__wrapper">
                                                    <select name="certificate_purpose" id="brgy-certificate-purpose" class="select select--resident-profile" onchange="showInput('brgy-certificate-purpose', 'other_purpose', 'other-purpose'); showClearanceCategory('brgy-certificate-purpose', 'category-container', 'certificate-category');" <?php if ($fee['certificate_type'] !== 'Barangay Clearance') : ?> disabled <?php endif; ?>>

                                                        <?php foreach ($clearancePurposes as $clearancePurpose) : ?>
                                                            <option <?php if ($fee['certificate_purpose'] === $clearancePurpose) : ?> selected <?php endif; ?> value="<?php echo $clearancePurpose ?>"><?php echo $clearancePurpose ?></option>

                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="text" hidden name="fee_setting_id" value="<?php echo $fee['fee_setting_id'] ?>">

                                    <div class="profile-info__container" id="residency-purpose-container" <?php if ($fee['certificate_type'] !== 'Residency Certificate') : ?> style="display: none;" <?php endif; ?>>
                                        <div class="input__wrapper">
                                            <label>Purpose <strong style="color:red;">*</strong></label>
                                            <div class="input__inner">
                                                <div class="select__wrapper">
                                                    <select name="certificate_purpose" id="residency-purpose" class="select select--resident-profile" onchange="showInput('residency-purpose', 'other_purpose', 'other-purpose')" <?php if ($fee['certificate_type'] !== 'Residency Certificate') : ?> disabled <?php endif; ?>>

                                                        <?php foreach ($residencyPurposes as $residencyPurpose) : ?>
                                                            <option <?php if ($fee['certificate_purpose'] === $residencyPurpose) : ?> selected <?php endif; ?> value="<?php echo $residencyPurpose ?>"><?php echo $residencyPurpose ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="profile-info__container" id="other_purpose" style="display:none">
                                        <div class="input__wrapper">
                                            <label for="other-purpose">If Others, Please Specify <strong style="color:red;">*</strong></label>
                                            <div class="input__inner">
                                                <input type="text" name="other_purpose" id="other-purpose" title="Numbers and Special Characters are not allowed." class="input--light300" pattern="[a-zA-Z ,-.]+" disabled>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="profile-info__container" id="category-container" <?php if ($fee['certificate_type'] !== 'Barangay Clearance' && ($fee['certificate_purpose'] !== 'Employment' || $fee['certificate_purpose'] !== 'Driver\'s License' || $fee['certificate_purpose'] !== 'Security License')) : ?> style="display: none;" <?php endif; ?>>
                                        <div class="input__wrapper">
                                            <label>Certificate Category <strong style=" color:red;">*</strong></label>
                                            <div class="input__inner">
                                                <div class="select__wrapper">
                                                    <select name="certificate_category" id="certificate-category" class="select select--resident-profile">
                                                        <option selected hidden value="<?php echo $fee['certificate_category'] ?>"><?php echo $fee['certificate_category'] ?></option>
                                                        <option value="New">New</option>
                                                        <option value="Renewal">Renewal</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="profile-info__container">
                                        <div class="input__wrapper">
                                            <label for="fee">Fee <strong style="color:red;">*</strong></label>
                                            <div class="input__inner input__inner--with-leading-icon">
                                                <i class="input__icon input__icon--leading">₱</i>
                                                <input type="number" name="fee" id="fee" class="input--light300" step="0.01" placeholder="00.00" value="<?php echo $fee['fee'] ?>" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="profile-info__container">
                                        <div class="input__wrapper">
                                            <label for="remarks">Remarks <strong style="color:red;">*</strong></label>
                                            <div class="input__inner">
                                                <input type="text" name="remarks" id="remarks" class="input--light300" value="<?php echo $fee['remarks'] ?>" required>
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
                            <button class="button button--primary button--md" name="submit">SAVE CHANGES</button>
                            <a class="button button--dark button--md modal-trigger" data-modal-id="modal-cancel">CANCEL</a>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
</main>

<!--=============== MODALS ===============-->
<?php require './../../includes/modal-cancel.php'; ?>
</body>

</html>