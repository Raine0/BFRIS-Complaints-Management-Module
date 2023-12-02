<?php
$page = 'Announcements';
$headerTitle = 'Announcements';

require_once "../../includes/header.php";
include "../../includes/preloader.php";
?>

<main>
    <div class="content">
        <section class="announcement">
            <table id="table" class="row-border">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th>
                            <div class="residents__header-actions">
                                <button class="button button--md button--primary modal-trigger" data-modal-id="modal-sendmessage">
                                    <i class='bx bx-user-plus bx-sm' data-modal-id="modal-sendmessage"></i>
                                    ADD ANNOUNCEMENT
                                </button>
                            </div>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $annQuery = "SELECT * FROM announcement ORDER BY announcement_id DESC";
                    $annStatement = $pdo->query($annQuery);
                    $announcements = $annStatement->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($announcements as $announcement) {
                    ?>
                        <tr>

                            <td> </td>
                            <td>
                                <a href="view-announcement.php?announcement_id=<?php echo $announcement['announcement_id'] ?>">
                                    <div class="table__row-text">
                                        <div class="table__row-name">
                                            Recipients: <strong><?php echo $announcement["recipients"]; ?></strong>
                                        </div>
                                        <div class="table__row-sub">
                                            <div class="message__date-time">
                                                <?php echo date("l, F j Y", strtotime($announcement["date"])); ?> -
                                                <?php echo date("g:i A", strtotime($announcement["time"])); ?></div>
                                        </div>
                                    </div>
                                </a>
                            </td>
                            <td>
                                <div class="table__action-buttons">
                                    <a href="view-announcement.php?announcement_id=<?php echo $announcement['announcement_id'] ?>" class="button button--primary button--sm action__cert" id="action-cert">
                                        VIEW
                                    </a>
                                </div>
                            </td>


                        </tr>
                    <?php } ?>

                </tbody>
            </table>
        </section>
    </div>
</main>

<?php require './modal/send-modal.php'; ?>

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

</body>

</html>