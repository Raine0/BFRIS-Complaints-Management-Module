<?php
$page = 'Announcements';
$headerTitle = 'Announcements';

require_once "../../includes/header.php";
include "../../includes/preloader.php";

if (filter_has_var(INPUT_GET, 'announcement_id')) {
    $clean_announcement_id = filter_var($_GET["announcement_id"], FILTER_SANITIZE_NUMBER_INT);
    $announcement_id = filter_var($clean_announcement_id, FILTER_VALIDATE_INT);

?>
    <main>
        <div class="content">
            <section class="announcements">

                <?php
                include "../../includes/back-button.php";

                $annQuery = "SELECT * FROM announcement WHERE announcement_id = :announcement_id";
                $annStatement = $pdo->prepare($annQuery);
                $annStatement->bindParam(':announcement_id', $announcement_id, PDO::PARAM_INT);
                $annstatement->execute();

                $annCount = $annStatement->rowCount();
                if ($annCount === 1) {
                    $announcement = $annStatement->fetch(PDO::FETCH_ASSOC);

                ?>

                    <div class="card card--announcements">
                        <div class="card__header">
                            <div class="card__header-content">
                                <div class="card__header-content--left">
                                    Recipients: <strong><?php echo $announcement["recipients"]; ?></strong>
                                </div>
                                <div class="card__header-content--right">
                                    <a class="button button--icon button--icon-sm button--icon-primary modal-trigger" data-modal-id="modal-deletemessage">
                                        <i class='bx bx-trash' data-modal-id="modal-deletemessage"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="card__body">
                            <div class="card__body-content" style="align-items: flex-start; position:relative;">
                                <div class="message__date-time"><?php echo date("l, F j Y", strtotime($announcement["date"])); ?> - <?php echo date("g:i A", strtotime($announcement["time"])); ?></div>
                                <div class="message">
                                    <?php echo $announcement["message"]; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </section>
        </div>
    </main>

    <div class="modal__wrapper" id="modal-deletemessage">
        <section class="modal__window modal__window--md">
            <header class="modal__header">
                <h3>Delete Message</h3>
                <button type="button" class="modal__close close" aria-label="Close modal window">
                    <i class='bx bx-x'></i>
                </button>
            </header>
            <div class="modal__body">
                Are you sure you want to delete this message?
            </div>

            <footer class="modal__footer">
                <a href="delete.php?announcement_id=<?php echo $announcement["announcement_id"]; ?>" class="button button--danger button--md">DELETE</a>
                <a href="#" class="button button--dark button--md modal__cancel close">CANCEL</a>
            </footer>
        </section>
    </div>
<?php
}
?>