<?php

$page = 'Certificates';
$headerTitle = 'Low Income Certificate';

require_once "../../includes/header.php";
include "../../includes/preloader.php";
require "modals/generate/generate-low-income.php";


if (isset($_SESSION['user_id'])) {
    $user_role = $_SESSION['role'];
}
?>

<main>
    <div class="content">
        <section class="osca">
            <?php require '../../includes/back-button.php'; ?>
            <table id="table" class="row-border">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th>
                            <div class="residents__header-actions">

                                <?php if ($user_role === 'Administrator' || $user_role === 'Barangay Secretary' || $user_role === 'Barangay Clerk - Generate Clearance') : ?>
                                    <button class="button button--primary button--md certificates__button modal-trigger" data-modal-id="modal-low-income">
                                        <i class='bx bx-file' data-modal-id="modal-low-income"></i>
                                        <p data-modal-id="modal-low-income">GENERATE</p>
                                    </button>

                                    <a class="button button--info button--md" id="export-resident">
                                        <i class='bx bxs-file-export'></i>
                                        <p>EXPORT</p>
                                    </a>
                                <?php endif; ?>

                                <div class="dropdown dropdown--export dropdown">
                                    <ul>
                                        <li class="dropdown__item">
                                            <a href="export/low-income/excel/export-excel.php">
                                                <i class='bx bxs-spreadsheet'></i>
                                                Excel
                                            </a>
                                        </li>

                                        <li class="dropdown__item">
                                            <a href="export/low-income/pdf/export-landscape.php">
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
                    $lowIncomeQuery = "SELECT low_income_id, last_name, first_name, mid_name, suffix, img_url, date_issued FROM resident RIGHT JOIN low_income_certificate ON resident.resident_id = low_income_certificate.resident_id ORDER BY date_issued DESC";


                    $lowIncomeStatement = $pdo->query($lowIncomeQuery);
                    $lowIncomes = $lowIncomeStatement->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($lowIncomes as $lowIncome) {

                        $low_income_id = $lowIncome['low_income_id'];
                        $date_format = $lowIncome['date_issued'];
                        $date_issued = date("F j, Y H:i:s", strtotime($date_format));
                        $resident_image = $lowIncome['img_url'];

                    ?>
                        <tr>

                            <td>
                                <a href="low-income-view.php?low_income_id=<?php echo $low_income_id ?>">
                                    <div class="table__row-img">
                                        <img src="../residents/images/<?php echo $resident_image ?>" alt="">
                                    </div>
                                </a>
                            </td>
                            <td>
                                <a href="low-income-view.php?low_income_id=<?php echo $low_income_id ?>">
                                    <div class="table__row-text">
                                        <div class="table__row-name">
                                            <?php echo $lowIncome['last_name'] ?>,
                                            <?php echo $lowIncome['first_name'] ?>
                                            <?php echo $lowIncome['mid_name'] ? mb_substr($lowIncome['mid_name'], 0, 1, 'UTF-8') . "." : "" ?>
                                            <?php echo $lowIncome['suffix'] ?>
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
                                        <a href="regenerate/regenerate-low-income.php?low_income_id=<?php echo $low_income_id ?>" class="button button--info button--sm" id="regenerate-clearance" data-date-issued="<?php echo $lowIncome['date_issued'] ?>">
                                            <i class='bx bxs-file-blank'></i>
                                            REGENERATE
                                        </a>

                                    <?php endif; ?>

                                    <a href="low-income-view.php?low_income_id=<?php echo $low_income_id ?>" class="button button--green button--sm action__view" data-target="#modal-viewprofile" id="action-view">
                                        <i class='bx bxs-show'></i>
                                        <p>VIEW CERTIFICATE</p>
                                    </a>
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

</main>

</body>

</html>