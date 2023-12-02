<?php
$page = 'Dashboard';
$headerTitle = 'Lists of Female Resident';
require_once "../../includes/header.php";
?>
<main>
    <div class="content">
        <section class="female-residents">

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
                    $query =  "SELECT * FROM resident WHERE sex = :sex ORDER BY last_name";
                    $statement = $pdo->prepare($query);
                    $statement->bindValue(':sex', 'Female');
                    $statement->execute();

                    while ($femaleResident = $statement->fetch(PDO::FETCH_ASSOC)) {

                    ?>
                        <tr>
                            <td>
                                <a href="../residents/view-resident.php?resident_id=<?php echo $femaleResident['resident_id'] ?>">
                                    <div class="table__row-img">
                                        <img src="../residents/images/<?php echo $femaleResident["img_url"]; ?>" alt="">
                                    </div>
                                </a>
                            </td>
                            <td>
                                <a href="../residents/view-resident.php?resident_id=<?php echo $femaleResident['resident_id'] ?>">
                                    <div class="table__row-text">
                                        <div class="table__row-name">
                                            <?php echo $femaleResident['last_name'] ?>,
                                            <?php echo $femaleResident['first_name'] ?>
                                            <?php echo $femaleResident['mid_name'] ? mb_substr($femaleResident['mid_name'], 0, 1, 'UTF-8') . "." : "" ?>
                                            <?php echo $femaleResident['suffix'] ?>
                                        </div>

                                        <div class="table__row-sub">
                                            <div>
                                                ID: <?php echo $femaleResident['resident_id'] ?>
                                            </div>
                                            <div>
                                                Age: <?php echo calculate_age($femaleResident['date_of_birth']) ?>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </td>
                            <td>

                                <div class="table__action-buttons">
                                    <a href="../residents/view-resident.php?resident_id=<?php echo $femaleResident['resident_id'] ?>" class="button button--green button--sm action__view" data-target="#modal-viewprofile" id="action-view">
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