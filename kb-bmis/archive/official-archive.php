<?php

$page = 'Archive';
$headerTitle = 'Officials Archive';

require_once "../../includes/header.php";
include "../../includes/preloader.php";
?>

<main>
    <div class="content">
        <section class="archive">
            <?php require '../../includes/back-button.php'; ?>
            <table id="table" class="row-border">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $officialArchive =  "SELECT official_archive.*, 
                                        COALESCE(resident.first_name, resident_archive.first_name) AS first_name, 
                                        COALESCE(resident.mid_name, resident_archive.mid_name) AS  mid_name, 
                                        COALESCE(resident.last_name, resident_archive.last_name) AS last_name, 
                                        COALESCE(resident.suffix, resident_archive.suffix) AS suffix,
                                        COALESCE(resident.img_url, resident_archive.img_url) AS img_url
                                        FROM official_archive
                                        LEFT JOIN resident 
                                        ON official_archive.resident_id = resident.resident_id 
                                        LEFT JOIN resident_archive
                                        ON official_archive.resident_id = resident_archive.resident_id 
                                    ";
                    $officialStatement = $pdo->query($officialArchive);
                    $officials = $officialStatement->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($officials as $official) {
                    ?>
                        <tr>
                            <td>
                                <a <?php if ($user_role === 'Administrator' || $user_role === 'Barangay Secretary') : ?> href="view-official.php?official_archive_id=<?php echo $official['official_archive_id'] ?>" <?php endif; ?>>
                                    <div class="table__row-img">
                                        <img src="../residents/images/<?php echo $official['img_url'] ?>" alt="">
                                    </div>
                                </a>
                            </td>
                            <td>
                                <a <?php if ($user_role === 'Administrator' || $user_role === 'Barangay Secretary') : ?> href="view-official.php?official_archive_id=<?php echo $official['official_archive_id'] ?>" <?php endif; ?>>
                                    <div class="table__row-text">
                                        <div class="table__row-name">
                                            <?php echo $official['last_name'] ?>,
                                            <?php echo $official['first_name'] ?>
                                            <?php echo $official['mid_name'] ? mb_substr($official['mid_name'], 0, 1, 'UTF-8') . "." : "" ?>
                                            <?php echo $official['suffix'] ?>
                                        </div>
                                        <div class="table__row-sub">
                                            <?php echo $official['term'] ?> - <?php echo $official['off_position'] ?>
                                        </div>
                                    </div>
                                </a>
                            </td>
                            <td>
                                <?php if ($user_role === 'Administrator' || $user_role === 'Barangay Secretary') : ?>
                                    <div class="table__action-buttons">
                                        <a href="view-official.php?official_archive_id=<?php echo $official['official_archive_id'] ?>" class="button button--green button--sm archive__view-btn">
                                            VIEW PROFILE
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </td>

                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <!-- brgy officials end -->
        </section>
        <!-- officials end -->
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