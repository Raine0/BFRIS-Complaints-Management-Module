<?php

$page = 'Certificates';
$headerTitle = 'Barangay Clearance';

require_once "../../includes/header.php";
include "../../includes/preloader.php";
require "modals/generate/generate-brgy-clearance.php";


if (isset($_SESSION['user_id'])) {
    $user_role = $_SESSION['role'];
}
?>

<main>
    <div class="content">
        <section class="brgy-clearance">
            <?php require '../../includes/back-button.php'; ?>
            <table id="table" class="row-border">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th>
                            <div class="residents__header-actions">

                                <?php if ($user_role === 'Administrator' || $user_role === 'Barangay Secretary' || $user_role === 'Barangay Clerk - Generate Clearance') : ?>
                                    <button class="button button--primary button--md certificates__button modal-trigger" data-modal-id="modal-brgyclearance">
                                        <i class='bx bx-file' data-modal-id="modal-brgyclearance"></i>
                                        <p data-modal-id="modal-brgyclearance">GENERATE</p>
                                    </button>

                                    <a class="button button--info button--md" id="export-resident">
                                        <i class='bx bxs-file-export'></i>
                                        <p>EXPORT</p>
                                    </a>
                                <?php endif; ?>

                                <div class="dropdown dropdown--export dropdown">
                                    <ul>
                                        <li class="dropdown__item">
                                            <a href="export/brgy-clearance/excel/export-excel.php">
                                                <i class='bx bxs-spreadsheet'></i>
                                                Excel
                                            </a>
                                        </li>

                                        <li class="dropdown__item">
                                            <a href="export/brgy-clearance/excel/fourps-excel.php">
                                                <i class='bx bxs-spreadsheet'></i>
                                                4ps Excel
                                            </a>
                                        </li>

                                        <li class="dropdown__item">
                                            <a href="export/brgy-clearance/pdf/export-landscape.php">
                                                <i class='bx bxs-file-pdf'></i>
                                                PDF Landscape
                                            </a>
                                        </li>

                                        <li class="dropdown__item">
                                            <a href="export/brgy-clearance/pdf/fourps-landscape.php">
                                                <i class='bx bxs-file-pdf'></i>
                                                4ps PDF
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
                    $clearanceQuery = "SELECT brgy_clearance_id, first_name, mid_name, last_name, suffix, date_issued, img_url FROM barangay_clearance LEFT JOIN resident
                    ON resident.resident_id = barangay_clearance.resident_id ORDER BY date_issued DESC";

                    $clearanceStatement = $pdo->query($clearanceQuery);
                    $clearances = $clearanceStatement->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($clearances as $clearance) {

                        $brgy_clearance_id = $clearance['brgy_clearance_id'];
                        $date_format = $clearance['date_issued'];
                        $date_issued = date("F j, Y H:i:s", strtotime($date_format));
                        $img_url = $clearance['img_url'];

                    ?>
                        <tr>
                            <td>
                                <a href="brgy-clearance-view.php?brgy_clearance_id=<?php echo $brgy_clearance_id ?>">
                                    <div class="table__row-img">
                                        <img src="../residents/images/<?php echo $img_url ?>" alt="">
                                    </div>
                                </a>
                            </td>
                            <td>
                                <a href="brgy-clearance-view.php?brgy_clearance_id=<?php echo $brgy_clearance_id ?>">
                                    <div class="table__row-text">
                                        <div class="table__row-name">
                                            <?php echo $clearance['last_name'] ?>,
                                            <?php echo $clearance['first_name'] ?>
                                            <?php echo $clearance['mid_name'] ? mb_substr($resident['mid_name'], 0, 1, 'UTF-8') . "." : "" ?>
                                            <?php echo $clearance['suffix'] ?>
                                        </div>

                                        <div class="table__row-sub">
                                            <div>Date Issued: <?php echo $date_issued ?></div>
                                        </div>
                                    </div>
                                </a>
                            </td>
                            <td>

                                <div class="table__action-buttons">
                                    <?php if ($user_role === 'Administrator' || $user_role === 'Barangay Secretary' || $user_role === 'Barangay Clerk - Generate Clearance') : ?>
                                        <a href="regenerate/regenerate-brgy-clearance.php?brgy_clearance_id=<?php echo $brgy_clearance_id ?>" class="button button--info button--sm" id="regenerate-clearance" data-date-issued="<?php echo $clearance['date_issued'] ?>">
                                            <i class='bx bxs-file-blank'></i>
                                            REGENERATE
                                        </a>

                                    <?php endif; ?>

                                    <?php if ($user_role === 'Administrator' || $user_role === 'Barangay Chairman' || $user_role === 'Barangay Secretary' || $user_role === 'Barangay Clerk - Generate Clearance') : ?>

                                        <a href="brgy-clearance-view.php?brgy_clearance_id=<?php echo $brgy_clearance_id ?>" class="button button--green button--sm action__view" data-target="#modal-viewprofile" id="action-view">
                                            <i class='bx bxs-show'></i>
                                            <p>VIEW CLEARANCE</p>

                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </section>
    </div>

    <?php if (isset($_SESSION['success'])) { ?>
        <!-- ALERT -->
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

    <?php if (filter_has_var(INPUT_GET, 'msg')) { ?>
        <!-- ALERT -->
        <div class="alert alert--success">
            <i class='bx bxs-check-square alert__icon'></i>
            <div class="alert__message">
                <?php
                $msg = htmlspecialchars($_GET['msg']);
                unset($_GET['msg']);
                echo $msg;
                ?>
            </div>
        </div>
    <?php } ?>


</main>

</body>

</html>