<div class="modal__wrapper" id="modal-good-moral-history">
    <section class="modal__window modal__window--md">
        <header class="modal__header">
            <h3>Generated Good Moral Certificate History</h3>
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
                    $goodmoralQuery = "SELECT good_moral_id, resident_name, purpose, date_issued FROM good_moral_certificate_view WHERE official_id = :official_id";

                    $goodmoralStatement = $pdo->prepare($goodmoralQuery);
                    $goodmoralStatement->bindValue(':official_id', $official['official_id']);

                    $goodmoralStatement->execute();


                    while ($goodmoral = $goodmoralStatement->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <tr>
                            <td>

                            </td>
                            <td>
                                <a href="./../certificates/good-moral-view.php?good_moral_id=<?php echo $goodmoral['good_moral_id'] ?>">
                                    <div class="table__row-text">
                                        <div class="table__row-name">

                                        </div>
                                        <div class="table__row-sub">
                                            <div><?php echo $goodmoral['resident_name'] ?></div>
                                            <div>ID: <?php echo $goodmoral['good_moral_id'] ?></div>
                                            <div>Purpose: <?php echo $goodmoral['purpose'] ?></div>
                                        </div>
                                    </div>
                                </a>
                            </td>
                            <td>
                                <div class="table__action-buttons">
                                    <a href="./../certificates/good-moral-view.php?good_moral_id=<?php echo $goodmoral['good_moral_id'] ?>" class="button button--green button--sm action__cert" id="action-cert">
                                        <i class='bx bxs-show'></i>
                                        VIEW GOOD MORAL
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