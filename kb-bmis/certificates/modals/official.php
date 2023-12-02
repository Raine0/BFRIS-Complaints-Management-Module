<div class="modal__wrapper" id="official-modal">
    <section class="modal__window modal__window--md">
        <header class="modal__header">
            <h3>Official</h3>
            <button type="button" class="modal__close close" aria-label="Close modal window">
                <i class='bx bx-x'></i>
            </button>
        </header>

        <div class="modal__body">
            <table id="official-table-modal" class="row-border">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <?php

                    $officialQuery = "SELECT * FROM official, resident WHERE official.resident_id = resident.resident_id ORDER BY official_id DESC";
                    $officialStatement = $pdo->query($officialQuery);
                    $officials = $officialStatement->fetchAll(PDO::FETCH_ASSOC);

                    $officialCount = $officialStatement->rowCount();


                    foreach ($officials as $official) {
                    ?>
                        <tr>
                            <td>
                                <a class="update-official" data-official-id="<?php echo $official['official_id'] ?>">
                                    <div class="table__row-img">
                                        <img src="./../../residents/images/<?php echo $official["img_url"]; ?>" alt="">
                                    </div>
                                </a>
                            </td>
                            <td>
                                <a class="update-official" data-official-id="<?php echo $official['official_id'] ?>">
                                    <div class=" table__row-text">
                                        <div class="table__row-name">
                                            <?php echo $official['last_name'] ?>,
                                            <?php echo $official['first_name'] ?>
                                            <?php echo $official['mid_name'] ? mb_substr($official['mid_name'], 0, 1, 'UTF-8')  . "." : "" ?>
                                            <?php echo $official['suffix'] ?? "" ?>
                                        </div>

                                        <div class="table__row-sub">
                                            <div>Position: <?php echo $official['off_position'] ?></div>
                                        </div>
                                    </div>
                                </a>
                            </td>
                            <td>
                                <div class="table__action-buttons">
                                    <a class="button button--primary button--sm action__cert select-official" data-official-id="<?php echo $official['official_id'] ?>">
                                        SELECT MEDIATOR
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php
                    }

                    ?>
                </tbody>

                <tr>
                    <td></td>
                    <td></td>
                    <td>
                        <a href=" ../barangay-officials/" style="color:#ef6a61">
                            <u>Create Official Profile Here!</u>
                        </a>
                    </td>
                </tr>
            </table>
        </div>
    </section>
</div>