<?php

$page = 'Certificates';
$headerTitle = 'Good Moral Certificate';

require_once "../../includes/header.php";
include "../../includes/preloader.php";
require "modals/generate/generate-good-moral.php";


if (isset($_SESSION['user_id'])) {
    $user_role = $_SESSION['role'];
}
?>

<main>
    <div class="content">
        <section class="good-moral">
            <?php require '../../includes/back-button.php'; ?>
            <table id="table" class="row-border">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th>
                            <div class="residents__header-actions">

                                <?php if ($user_role === 'Administrator' || $user_role === 'Barangay Secretary' || $user_role === 'Barangay Clerk - Generate Clearance') : ?>
                                    <button class="button button--primary button--md certificates__button modal-trigger" data-modal-id="modal-goodmoral">
                                        <i class='bx bx-file' data-modal-id="modal-goodmoral"></i>
                                        <p data-modal-id="modal-goodmoral">GENERATE</p>
                                    </button>

                                    <a class="button button--info button--md" id="export-resident">
                                        <i class='bx bxs-file-export'></i>
                                        <p>EXPORT</p>
                                    </a>
                                <?php endif; ?>

                                <div class="dropdown dropdown--export dropdown">
                                    <ul>
                                        <li class="dropdown__item">
                                            <a href="export/good-moral/excel/export-excel.php">
                                                <i class='bx bxs-spreadsheet'></i>
                                                Excel
                                            </a>
                                        </li>

                                        <li class="dropdown__item">
                                            <a href="export/good-moral/pdf/export-landscape.php">
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
                    $goodmoralQuery = "SELECT good_moral_certificate_view.*, resident_name, resident_image FROM good_moral_certificate_view ORDER BY date_issued DESC";

                    $goodmoralStatement = $pdo->query($goodmoralQuery);
                    $goodmorals = $goodmoralStatement->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($goodmorals as $goodmoral) {

                        $good_moral_id = $goodmoral['good_moral_id'];
                        $resident_name = $goodmoral['resident_name'];
                        $date_format = $goodmoral['date_issued'];
                        $date_issued = date("F j, Y H:i:s", strtotime($date_format));
                        $resident_image = $goodmoral['resident_image'];

                    ?>
                        <tr>

                            <td>
                                <a href="good-moral-view.php?good_moral_id=<?php echo $good_moral_id ?>">
                                    <div class="table__row-img">
                                        <img src="../residents/images/<?php echo $resident_image ?>" alt="">
                                    </div>
                                </a>
                            </td>
                            <td>
                                <a href="good-moral-view.php?good_moral_id=<?php echo $good_moral_id ?>">
                                    <div class="table__row-text">
                                        <div class="table__row-name">
                                            <?php echo $resident_name ?>
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
                                        <a href="regenerate/regenerate-good-moral.php?good_moral_id=<?php echo $good_moral_id ?>" class="button button--info button--sm" id="regenerate-clearance" data-date-issued="<?php echo $goodmoral['date_issued'] ?>">
                                            <i class='bx bxs-file-blank'></i>
                                            REGENERATE
                                        </a>

                                    <?php endif; ?>

                                    <a href="good-moral-view.php?good_moral_id=<?php echo $good_moral_id ?>" class="button button--green button--sm action__view" data-target="#modal-viewprofile" id="action-view">
                                        <i class='bx bxs-show'></i>
                                        <p>VIEW GOOD MORAL</p>
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

<!-- <div class="modal__wrapper" id="modal-import">
    <section class="modal__window modal__window--md">
        <header class="modal__header">
            <h3>Import Excel or CSV File</h3>
            <button type="button" class="modal__close close" aria-label="Close modal window">
                <i class='bx bx-x'></i>
            </button>
        </header>
        <div class="modal__body">
            <form action="import/import.php" method="POST" enctype="multipart/form-data">
                <label for="importFiles">Select Excel, CSV file to import:</label>
                <input type="file" id="importFiles" name="importFiles">

                <footer class="modal__footer">
                    <button type="submit" class="button button--danger button--md">Import</button>
                </footer>
            </form>
        </div>
    </section>
</div> -->
</body>

</html>