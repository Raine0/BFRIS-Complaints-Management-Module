<?php
$page = 'Fee Settings';
$headerTitle = 'Add Certificate Fee';

require_once "../../includes/header.php";
include "../../includes/preloader.php";

?>

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

<main>
    <div class="content">
        <section class="residents">
            <form action="controller/create.php" method="POST" enctype="multipart/form-data" data-parsley-validate="">

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
                                                    <select name="certificate_type" id="certificate-type" class="select select--resident-profile" onchange="showCertificatePurpose('certificate-type')" required autofocus>

                                                        <option selected disabled hidden value="">Select</option>

                                                        <?php
                                                        foreach ($certificates as $certificate) :
                                                        ?>

                                                            <option value="<?php echo $certificate['certificate_type'] ?>"><?php echo $certificate['certificate_type'] ?></option>

                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="profile-info__container" id="clearance-purpose-container" style="display: none;">
                                        <div class="input__wrapper">
                                            <label>Purpose <strong style="color:red;">*</strong></label>
                                            <div class="input__inner">
                                                <div class="select__wrapper">
                                                    <select disabled name="certificate_purpose" id="brgy-certificate-purpose" class="select select--resident-profile" onchange="showInput('brgy-certificate-purpose', 'other_purpose', 'other-purpose'); showClearanceCategory('brgy-certificate-purpose', 'category-container', 'certificate-category');">
                                                        <option selected disabled hidden value="">Select</option>
                                                        <option value="Motorcycle Loan">Motorcycle Loan</option>
                                                        <option value="Pag-asa Loan">Pag-asa Loan</option>
                                                        <option value="Asa Loan">Asa Loan</option>
                                                        <option value="Mediatrix Loan">Mediatrix Loan</option>
                                                        <option value="Light Micro Loan">Light Micro Loan</option>
                                                        <option value="Application Loan">Application Loan</option>

                                                        <option value="Employment">Employment</option>
                                                        <option value="Postal ID">Postal ID</option>
                                                        <option value="Water Connection">Water Connection</option>
                                                        <option value="DepEd Requirement">DepEd Requirement</option>
                                                        <option value="Identification">Identification</option>
                                                        <option value="SSS Requirement">SSS Requirement</option>
                                                        <option value="BIR Requirement">BIR Requirement</option>
                                                        <option value="Driver's License">Driver's License</option>
                                                        <option value="Security License">Security License</option>
                                                        <option value="Others">Others</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="profile-info__container" id="residency-purpose-container" style="display: none;">
                                        <div class="input__wrapper">
                                            <label>Purpose <strong style="color:red;">*</strong></label>
                                            <div class="input__inner">
                                                <div class="select__wrapper">
                                                    <select disabled name="certificate_purpose" id="residency-purpose" class="select select--resident-profile" onchange="showInput('residency-purpose', 'other_purpose', 'other-purpose')">
                                                        <option selected disabled hidden value="">Select</option>
                                                        <option value="Identification">Identification</option>
                                                        <option value="Water Connection">Water Connection</option>
                                                        <option value="Pc">PC</option>
                                                        <option value="Loan">Loan</option>
                                                        <option value="Co-maker">Co-maker</option>
                                                        <option value="Bailbond">Bailbond</option>
                                                        <option value="DSWD Financial Assistance">DSWD Financial Assistance</option>
                                                        <option value="4PS Requirement">4PS Requirement</option>
                                                        <option value="CHED Scholarship">CHED Scholarship</option>
                                                        <option value="DOST Scholarship">DOST Scholarship</option>
                                                        <option value="UNIFAST Scholarship">UNIFAST Scholarship</option>
                                                        <option value="GSIS Scholarship">GSIS Scholarship</option>
                                                        <option value="Others">Others</option>
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

                                    <div class="profile-info__container" id="category-container" style="display: none;">
                                        <div class="input__wrapper">
                                            <label>Certificate Category <strong style="color:red;">*</strong></label>
                                            <div class="input__inner">
                                                <div class="select__wrapper">
                                                    <select name="certificate_category" id="certificate-category" class="select select--resident-profile" disabled>
                                                        <option selected disabled hidden value="">Select</option>
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
                                                <input type="number" name="fee" id="fee" class="input--light300" step="0.01" placeholder="00.00" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="profile-info__container">
                                        <div class="input__wrapper">
                                            <label for="remarks">Remarks <strong style="color:red;">*</strong></label>
                                            <div class="input__inner">
                                                <input type="text" name="remarks" id="remarks" class="input--light300" required>
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
                            <button class="button button--primary button--md" name="btn_create">CREATE</button>
                            <a class="button button--dark button--md modal-trigger" data-modal-id="modal-cancel">CANCEL</a>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
</main>

<!--=============== MODALS ===============-->
<?php
require './../../includes/modal-cancel.php';
?>

</body>

</html>