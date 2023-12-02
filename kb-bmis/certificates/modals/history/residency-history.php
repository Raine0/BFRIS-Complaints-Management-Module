<div class="modal__wrapper" id="modal-residency-history">
    <section class="modal__window modal__window--md">
        <header class="modal__header">
            <h3>Resident Residency Certificate History</h3>
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
                    $residencyQuery = "SELECT residency_id, last_name, first_name, mid_name, suffix, date_issued FROM residency_certificate LEFT JOIN resident ON residency_certificate.resident_id = resident.resident_id WHERE residency_certificate.resident_id = :resident_id";

                    $residencyStatement = $pdo->prepare($residencyQuery);
                    $residencyStatement->bindValue(':resident_id', $residency['resident_id']);

                    $residencyStatement->execute();


                    while ($residency = $residencyStatement->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <tr>
                            <td>

                            </td>
                            <td>
                                <a href="./residency-view.php?residency_id=<?php echo $residency['residency_id'] ?>">
                                    <div class="table__row-text">
                                        <div class="table__row-name">
                                            <?php echo $residency['last_name'] ?>,
                                            <?php echo $residency['first_name'] ?>
                                            <?php echo $residency['mid_name'] ? mb_substr($residency['mid_name'], 0, 1, 'UTF-8')  . "." : "" ?>
                                            <?php echo $residency['suffix'] ?>
                                        </div>
                                        <div class="table__row-sub">
                                            <div>ID: <?php echo $residency['residency_id'] ?></div>
                                            <div>Date Issued: <?php echo date('m-d-Y h:i:s a', strtotime($residency['date_issued'])) ?></div>
                                        </div>
                                    </div>
                                </a>
                            </td>
                            <td>
                                <div class="table__action-buttons">
                                    <a href="./residency-view.php?residency_id=<?php echo $residency['residency_id'] ?>" class="button button--green button--sm action__cert" id="action-cert">
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