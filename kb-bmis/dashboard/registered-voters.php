<?php
$page = 'Dashboard';
$headerTitle = 'Lists of Registered Voter\'s';
require_once "../../includes/header.php";
?>
<main>
    <div class="content">
        <section class="voter-residents">

            <?php require '../../includes/back-button.php'; ?>

            <table id="table" class="row-border">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $query = "SELECT * FROM resident WHERE voter_id != :emptyString AND precinct_number != :emptyString ORDER BY last_name";

                    $statement = $pdo->prepare($query);
                    $statement->bindValue(':emptyString', "");
                    $statement->execute();

                    while ($voter = $statement->fetch(PDO::FETCH_ASSOC)) {

                    ?>
                        <tr>
                            <td>
                                <a href="../residents/view-resident.php?resident_id=<?php echo $voter['resident_id'] ?>">
                                    <div class="table__row-img">
                                        <img src="../residents/images/<?php echo $voter["img_url"]; ?>" alt="">
                                    </div>
                                </a>
                            </td>
                            <td>
                                <a href="../residents/view-resident.php?resident_id=<?php echo $voter['resident_id'] ?>">
                                    <div class="table__row-text">
                                        <div class="table__row-name">
                                            <?php echo $voter['last_name'] ?>,
                                            <?php echo $voter['first_name'] ?>
                                            <?php echo $voter['mid_name'] ? mb_substr($voter['mid_name'], 0, 1, 'UTF-8') . "." : "" ?>
                                            <?php echo $voter['suffix'] ?>
                                        </div>

                                        <div class="table__row-sub">
                                            <div>
                                                Voter's ID: <?php echo $voter['voter_id'] ?>
                                            </div>

                                            <div>
                                                Precinct No.: <?php echo $voter['precinct_number'] ?>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </td>

                            <td>
                                <div class="table__action-buttons">
                                    <a href="../residents/view-resident.php?resident_id=<?php echo $voter['resident_id'] ?>" class="button button--green button--sm action__view" data-target="#modal-viewprofile" id="action-view">
                                        <i class='bx bxs-show'></i>
                                        <p>VIEW PROFILE</p>
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
</body>

</html>