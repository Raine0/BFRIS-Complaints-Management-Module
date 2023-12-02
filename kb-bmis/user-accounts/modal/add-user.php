<!--=============== MODALS ===============-->
<div class="modal__wrapper" id="modal-newofficial">
    <section class="modal__window modal__window--md">
        <header class="modal__header">
            <h3>Add New User</h3>
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
                    $officials = ['Barangay Councilor', 'Barangay Treasurer', 'SK Chairperson', 'SK Councilor'];
                    $officialPlaceholder = str_repeat('?, ', count($officials) - 1) . '?';

                    $officialQuery = "SELECT * FROM official_view WHERE off_position NOT IN ($officialPlaceholder) ORDER BY official_id DESC";

                    $officialStatement = $pdo->prepare($officialQuery);

                    $officialStatement->execute($officials);

                    while ($official = $officialStatement->fetch(PDO::FETCH_ASSOC)) {
                        $officialQuery2 =  "SELECT COUNT(official_id) AS 'count' FROM user_view WHERE official_id = :official_id";

                        $officialStatement2 = $pdo->prepare($officialQuery2);
                        $officialStatement2->bindParam(':official_id', $official['official_id'], PDO::PARAM_INT);
                        $officialStatement2->execute();
                        $officials2 = $officialStatement2->fetch(PDO::FETCH_ASSOC);

                        if ($officials2['count'] < 1) {

                    ?>
                            <tr>
                                <td>
                                    <div class="table__row-img">
                                        <img src="../residents/images/<?php echo $official['img_url'] ?>" alt="">
                                    </div>
                                </td>
                                <td>
                                    <a href="controller/create.php?resident_id=<?php echo $official['resident_id'] ?>&official_id=<?php echo $official['official_id'] ?>">
                                        <div class="table__row-text">
                                            <div class="table__row-name">
                                                <?php echo $official['last_name'] ?>,
                                                <?php echo $official['first_name'] ?>
                                                <?php echo $official['mid_name'] ? mb_substr($official['mid_name'], 0, 1, 'UTF-8') . "." : "" ?>
                                                <?php echo $official['suffix'] ?>
                                            </div>
                                            <div class="table__row-sub">
                                                <div><?php echo $official['off_position'] ?></div>
                                            </div>
                                        </div>
                                    </a>
                                </td>
                                <td>
                                    <div class="table__action-buttons">
                                        <a href="./create-user.php?resident_id=<?php echo $official['resident_id'] ?>&official_id=<?php echo $official['official_id'] ?>" class="button button--primary button--sm action__cert" id="action-cert">
                                            SELECT
                                        </a>
                                    </div>
                                </td>
                            </tr>
                    <?php }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>
</div>