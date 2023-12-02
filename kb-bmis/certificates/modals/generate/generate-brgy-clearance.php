<!-- GENERATE BARANGAY CLEARANCE MODAL -->

<div class="modal__wrapper" id="modal-brgyclearance">
    <section class="modal__window modal__window--md">
        <header class="modal__header">
            <h3>Barangay Clearance</h3>
            <button type="button" class="modal__close close" aria-label="Close modal window">
                <i class='bx bx-x'></i>
            </button>
        </header>

        <div class="modal__body">
            <table id="modal-table" class="row-border">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <?php

                    $query = "SELECT * FROM resident ORDER BY resident_id DESC";
                    $statement = $pdo->query($query);
                    $residents = $statement->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($residents as $resident) {

                    ?>
                        <tr>
                            <td>
                                <a href="brgy-clearance-create.php?resident_id=<?php echo $resident['resident_id'] ?>">
                                    <div class="table__row-img">
                                        <img src="../residents/images/<?php echo $resident["img_url"]; ?>" alt="">
                                    </div>
                                </a>
                            </td>
                            <td>
                                <a href="brgy-clearance-create.php?resident_id=<?php echo $resident['resident_id'] ?>">
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
                                    <a href="brgy-clearance-create.php?resident_id=<?php echo $resident['resident_id'] ?>" class="button button--primary button--sm action__cert" id="action-cert">
                                        SELECT RESIDENT
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