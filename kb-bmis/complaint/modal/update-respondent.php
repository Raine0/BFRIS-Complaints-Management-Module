<div class="modal__wrapper" id="modal-update-respondent">
    <section class="modal__window modal__window--md">
        <header class="modal__header">
            <h3>Respondent</h3>

            <button type="button" class="modal__close close" aria-label="Close modal window">
                <i class='bx bx-x'></i>
            </button>
        </header>

        <div class="left" style=" margin-bottom:12px;">
            <div>
                <button class="button button--md back-btn" style="position: relative; top: 0; left: 0; padding:0;" id="modal-respondent-back">
                    <i class='bx bx-left-arrow-circle'></i>
                    Back
                </button>
            </div>
        </div>

        <div class="modal__body">
            <table id="respondent-table-modal" class="row-border">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>

                </thead>

                <tbody>
                    <?php

                    $residentQuery = "SELECT * FROM resident ORDER BY resident_id DESC";
                    $residentStatement = $pdo->query($residentQuery);
                    $residents = $residentStatement->fetchAll(PDO::FETCH_ASSOC);

                    $residentCount = $residentStatement->rowCount();

                    foreach ($residents as $resident) {
                    ?>
                        <tr>
                            <td>
                                <a href="#" class="update-respondent" data-respondent-id="<?php echo $resident['resident_id'] ?>">
                                    <div class="table__row-img">
                                        <img src="../residents/images/<?php echo $resident["img_url"]; ?>" alt="">
                                    </div>
                                </a>
                            </td>
                            <td>
                                <a href="#" class="update-respondent" data-respondent-id="<?php echo $resident['resident_id'] ?>">
                                    <div class="table__row-text">
                                        <div class="table__row-name">
                                            <?php echo $resident['last_name'] ?>,
                                            <?php echo $resident['first_name'] ?>
                                            <?php echo $resident['mid_name'] ? mb_substr($resident['mid_name'], 0, 1, 'UTF-8')  . "." : "" ?>
                                            <?php echo $resident['suffix'] ?? "" ?>
                                        </div>

                                        <div class="table__row-sub">
                                            <div>ID: <?php echo $resident['resident_id'] ?></div>
                                        </div>
                                    </div>
                                </a>
                            </td>
                            <td>
                                <div class="table__action-buttons">
                                    <a class="button button--primary button--sm action__cert update-respondent" data-respondent-id="<?php echo $resident['resident_id'] ?>">
                                        SELECT RESPONDENT
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