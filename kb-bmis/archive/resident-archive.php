<?php
$page = 'Archive';
$headerTitle = 'Residents Archive';

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
                        <th>
                            <div class="residents__header-actions">
                                <div class="select__wrapper" id="residents__filter-container">
                                    <select class="select select--table" name="filter">
                                        <option value="">All</option>
                                        <option value="4Ps">4Ps</option>
                                        <option value="Deceased">Deceased</option>
                                        <option value="Person with Disability">Persons with Disability</option>
                                        <option value="Registered Voter">Registered Voters</option>
                                        <option value="Senior Citizen">Senior Citizens</option>
                                    </select>
                                </div>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    $residentArchive = "SELECT * FROM resident_archive ORDER BY resident_archive_id DESC";

                    $residentStatement = $pdo->query($residentArchive);
                    $residents = $residentStatement->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($residents as $resident) {

                    ?>

                        <tr>
                            <td>
                                <a <?php if ($user_role === 'Administrator' || $user_role === 'Barangay Secretary' || $user_role === 'Barangay Clerk - Complaint Admin') : ?> href="view-resident.php?resident_archive_id=<?php echo $resident['resident_archive_id'] ?>" <?php endif; ?>>
                                    <div class="table__row-img">
                                        <img src="../residents/images/<?php echo $resident["img_url"]; ?>" alt="">
                                    </div>
                                </a>
                            </td>
                            <td>
                                <a <?php if ($user_role === 'Administrator' || $user_role === 'Barangay Secretary' || $user_role === 'Barangay Clerk - Complaint Admin') : ?> href="view-resident.php?resident_archive_id=<?php echo $resident['resident_archive_id'] ?>" <?php endif; ?>>
                                    <div class="table__row-text">
                                        <div class="table__row-name">
                                            <?php echo $resident['last_name'] . "," ?>
                                            <?php echo $resident['first_name'] ?>
                                            <?php echo $resident['mid_name'] ? mb_substr($resident['mid_name'], 0, 1, 'UTF-8') . ". " : "" ?>
                                            <?php echo $resident['suffix'] ?? "" ?>
                                        </div>

                                        <div class="table__row-sub">
                                            <div>ID: <?php echo $resident['resident_id'] ?></div>
                                            <div>Date Archived: <?php echo $resident['date_archived'] ?></div>
                                        </div>
                                    </div>
                                </a>
                            </td>

                            <td>
                                <?php if ($user_role === 'Administrator' || $user_role === 'Barangay Secretary' || $user_role === 'Barangay Clerk - Complaint Admin') : ?>
                                    <div class="table__action-buttons">
                                        <a href="view-resident.php?resident_archive_id=<?php echo $resident['resident_archive_id'] ?>" class="button button--green button--sm archive__view-btn" data-target="#modal-viewprofile" id="action-view">
                                            <p>VIEW PROFILE</p>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </td>
                        </tr>

                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </div>

</main>

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

<!--=============== MODALS ===============-->
<div class="modal__wrapper" id="modal-delete">
    <section class="modal__window modal__window--sm">
        <header class="modal__header">
            <h3>Empty Archive</h3>
            <button type="button" class="modal__close close" aria-label="Close modal window">
                <i class='bx bx-x'></i>
            </button>
        </header>

        <div class="modal__body">
            Are you sure you want to empty archive?
        </div>

        <footer class="modal__footer">
            <a href="controllers/resident-empty-archive.php" class="button button--danger button--md"> Confirm</a>
            <a href="#" class="button button--dark button--md modal__cancel close">Cancel</a>
        </footer>
    </section>
</div>

</body>

</html>