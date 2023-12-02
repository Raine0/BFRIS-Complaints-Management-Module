<?php
$page = 'Residents';
$headerTitle = 'Residents';

require "../../includes/header.php";
require "../../includes/preloader.php";
require "filter.php";
require "modal/filter-resident.php";

if (isset($_SESSION['user_id'])) {
    $user_role = $_SESSION['role'];
}

?>

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

<main>
    <div class="content">
        <section class="residents">
            <table id="table" class="row-border">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th>
                            <div class="residents__header-actions">

                                <button class="button button--warning button--md modal-trigger filter-btn" data-modal-id="modal-filter">
                                    <i class='bx bxs-filter-alt' data-modal-id="modal-filter"></i>
                                    <span>FILTER</span>
                                </button>

                                <?php if ($user_role === 'Barangay Clerk - Resident Admin' || $user_role === 'Barangay Clerk - Resident Encoder' || $user_role === 'Barangay Secretary' || $user_role === 'Administrator') :  ?>
                                    <a href="create-resident.php" class="button button--primary button--md" data-target="#modal-newresident" id="add-resident">
                                        <i class='bx bx-plus'></i>
                                        <p>ADD NEW</p>
                                    </a>
                                <?php endif; ?>

                                <?php if ($user_role === 'Administrator' || $user_role === 'Barangay Secretary' || $user_role === 'Barangay Clerk - Resident Admin') : ?>
                                    <a class="button button--info button--md" id="export-resident">
                                        <i class='bx bxs-file-export'></i>
                                        <p>EXPORT</p>
                                    </a>
                                <?php endif; ?>

                                <div class="dropdown dropdown--export dropdown">
                                    <ul>
                                        <li class="dropdown__item">
                                            <a href="export/excel/export-excel.php">
                                                <i class='bx bxs-spreadsheet'></i>
                                                Excel
                                            </a>
                                        </li>

                                        <li class="dropdown__item">
                                            <a href="export/pdf/export-landscape.php">
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
                    $residentQuery = "SELECT * FROM resident";

                    // if filters are applied, add them to the where conditions
                    if (empty($condition)) {

                        $residentQuery .= " ORDER BY resident_id DESC";
                    } else {
                        $where_clause = "WHERE " . $condition;
                        $residentQuery .= " $where_clause";
                    }


                    $residentStatement = $pdo->query($residentQuery);
                    $residents = $residentStatement->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($residents as $resident) {

                    ?>
                        <tr>
                            <td>
                                <a <?php if ($user_role !== 'Barangay Clerk - Complaint Admin' && $user_role !== 'Barangay Clerk - Complaint Encoder') : ?> href="view-resident.php?resident_id=<?php echo $resident['resident_id'] ?>">
                                <?php endif; ?>

                                <div class="table__row-img">
                                    <img src="images/<?php echo $resident["img_url"] ?>" alt="">
                                </div>
                                </a>
                            </td>
                            <td>
                                <a <?php if ($user_role !== 'Barangay Clerk - Complaint Admin' && $user_role !== 'Barangay Clerk - Complaint Encoder') : ?> href="view-resident.php?resident_id=<?php echo $resident['resident_id'] ?>">
                                <?php endif; ?>
                                <div class="table__row-text">
                                    <div class="table__row-name">
                                        <?php echo $resident['last_name'] ?>,
                                        <?php echo $resident['first_name'] ?>
                                        <?php echo $resident['mid_name'] ? mb_substr($resident['mid_name'], 0, 1, 'UTF-8') . "." : "" ?>
                                        <?php echo $resident['suffix'] ?>
                                    </div>

                                    <div class="table__row-sub">
                                        <div>ID: <?php echo $resident['resident_id'] ?></div>
                                    </div>
                                </div>
                                </a>
                            </td>
                            <td>

                                <div class="table__action-buttons">
                                    <?php if ($user_role === 'Barangay Clerk - Resident Admin' || $user_role === 'Barangay Clerk - Resident Encoder' || $user_role === 'Barangay Secretary' || $user_role === 'Administrator' || $user_role === 'Barangay Chairman') : ?>
                                        <a href="view-resident.php?resident_id=<?php echo $resident['resident_id'] ?>" onclick="hideVoting();" class="button button--green button--sm action__view" data-target="#modal-viewprofile" id="action-view">
                                            <i class='bx bxs-show'></i>
                                            <p>VIEW PROFILE</p>

                                        </a>
                                    <?php endif; ?>

                                    <?php if ($user_role === 'Barangay Clerk - Resident Admin' || $user_role === 'Barangay Clerk - Resident Encoder' || $user_role === 'Barangay Secretary' || $user_role === 'Administrator') : ?>
                                        <a href="update-resident.php?resident_id=<?php echo $resident["resident_id"]; ?>" class="button button--primary button--sm modal-trigger">
                                            <i class='bx bxs-edit'></i>
                                            EDIT PROFILE
                                        </a>
                                    <?php endif;  ?>


                                    <div class="action__cert">
                                        <?php if ($user_role == 'Barangay Clerk - Admin' || $user_role == 'Barangay Secretary' || $user_role == 'Administrator') {  ?>
                                            <button class="button button--info button--sm dropdownBtn" id="action-cert">
                                                <i class='bx bxs-file-blank'></i>
                                                GENERATE CLEARANCE
                                            </button>
                                        <?php }  ?>

                                        <div class="dropdown dropdown--cert dropdownContent">
                                            <ul>
                                                <li class="dropdown__item">
                                                    <a href="../certificates/brgy-clearance-create.php?resident_id=<?php echo $resident['resident_id'] ?>" class="link-brgycert">
                                                        <i class='bx bxs-file'></i>
                                                        Barangay Clearance
                                                    </a>
                                                </li>
                                                <li class="dropdown__item">
                                                    <a href="../certificates/good-moral-create.php?resident_id=<?php echo $resident['resident_id'] ?>" class="link-brgycert">
                                                        <i class='bx bxs-file'></i>
                                                        Good Moral Certificate
                                                    </a>
                                                </li>
                                                <!-- <li class="dropdown__item">
                                                <a href="../certificates/resident-business-clearance.php?resident_id=<?php echo $resident['resident_id'] ?>" class="link-busclearance">
                                                    <i class='bx bxs-business'></i>
                                                    Business Clearance
                                                </a>
                                            </li> -->
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </section>
    </div>
</main>
</body>

</html>