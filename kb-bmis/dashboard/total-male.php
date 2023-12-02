<?php

$page = 'Dashboard';
$headerTitle = 'Lists of Male Resident';
require_once "../../includes/header.php";

?>
<main>
    <div class="content">
        <section class="male-residents">

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
                    $statement->bindValue(':sex', 'Male');
                    $statement->execute();


                    while ($maleResident = $statement->fetch(PDO::FETCH_ASSOC)) {

                    ?>
                        <tr>
                            <td>
                                <a href="../residents/view-resident.php?resident_id=<?php echo $maleResident['resident_id'] ?>">
                                    <div class="table__row-img">
                                        <img src="../residents/images/<?php echo $maleResident["img_url"]; ?>" alt="">
                                    </div>
                                </a>
                            </td>
                            <td>
                                <a href="../residents/view-resident.php?resident_id=<?php echo $maleResident['resident_id'] ?>">
                                    <div class="table__row-text">
                                        <div class="table__row-name">
                                            <?php echo $maleResident['last_name'] ?>,
                                            <?php echo $maleResident['first_name'] ?>
                                            <?php echo $maleResident['mid_name'] ? mb_substr($maleResident['mid_name'], 0, 1, 'UTF-8') . "." : "" ?>
                                            <?php echo $maleResident['suffix'] ?>
                                        </div>

                                        <div class="table__row-sub">
                                            <div>
                                                ID: <?php echo $maleResident['resident_id'] ?>
                                            </div>

                                            <div>
                                                Age: <?php echo calculate_age($maleResident['date_of_birth']) ?>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </td>
                            <td>

                                <div class="table__action-buttons">
                                    <a href="../residents/view-resident.php?resident_id=<?php echo $maleResident['resident_id'] ?>" class="button button--green button--sm action__view" data-target="#modal-viewprofile" id="action-view">
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