<div class="modal__wrapper" id="modal-osca-history">
    <section class="modal__window modal__window--md">
        <header class="modal__header">
            <h3>Resident OSCA Certificate History</h3>
            <button type="button" class="modal__close close" aria-label="Close modal window">
                <i class='bx bx-x'></i>
            </button>
        </header>
        <div class="modal__body">
            <table id="good-moral-history-modal" class="row-border">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $oscaQuery = "SELECT osca_id, last_name, first_name, mid_name, suffix, date_issued FROM osca_certificate LEFT JOIN resident ON osca_certificate.resident_id = resident.resident_id WHERE osca_certificate.resident_id = :resident_id";

                    $oscaStatement = $pdo->prepare($oscaQuery);
                    $oscaStatement->bindValue(':resident_id', $osca['resident_id']);

                    $oscaStatement->execute();


                    while ($osca = $oscaStatement->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <tr>
                            <td>

                            </td>
                            <td>
                                <a href="./osca-view.php?osca_id=<?php echo $osca['osca_id'] ?>">
                                    <div class="table__row-text">
                                        <div class="table__row-name">
                                            <?php echo $osca['last_name'] ?>,
                                            <?php echo $osca['first_name'] ?>
                                            <?php echo $osca['mid_name'] ? mb_substr($osca['mid_name'], 0, 1, 'UTF-8')  . "." : "" ?>
                                            <?php echo $osca['suffix'] ?>
                                        </div>
                                        <div class="table__row-sub">
                                            <div>ID: <?php echo $osca['osca_id'] ?></div>
                                            <div>Date Issued: <?php echo date('m-d-Y h:i:s a', strtotime($osca['date_issued'])) ?></div>
                                        </div>
                                    </div>
                                </a>
                            </td>
                            <td>
                                <div class="table__action-buttons">
                                    <a href="./osca-view.php?osca_id=<?php echo $osca['osca_id'] ?>" class="button button--green button--sm action__cert" id="action-cert">
                                        <i class='bx bxs-show'></i>
                                        VIEW CERTIFICATE
                                    </a>
                                </div>
                            </td>
                        </tr>

                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>
</div>