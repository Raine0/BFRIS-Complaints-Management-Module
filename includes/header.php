<?php
session_start();
require __DIR__ . "/../db_conn.php";
include __DIR__ . "/../kb-bmis/calculate-age.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../");
    exit();
}
$user_role = $_SESSION['role'];
$resident_id = $_SESSION['resident_id'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png" href="../../assets/img/fatima-logo.png">
    <!--=============== BOX ICONS ===============-->
    <link href="../../vendors/boxicons-2.0.9/css/boxicons.min.css" rel="stylesheet" />

    <!--=============== JQUERY ===============-->
    <!--=============== DATATABLES ===============-->
    <link rel="stylesheet" type="text/css" href="../../vendors/jquery.dataTables.min.css">
    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="../../assets/css/style.css" />

    <!--=============== SCRIPTS ===============-->
    <script type="text/javascript" src="../../vendors/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="../../vendors/jquery.dataTables.min.js"></script>

    <?php if ($page == 'Residents') {
        echo '
    <script src="../../vendors/webcam.min.js"></script>
    <script src="../../assets/js/webcam.js" defer></script>
    <script src="../../assets/js/input-validation/resident.js" defer></script>
    ';
    } elseif ($page == 'Certificates') {
        echo '
    <script src="../../vendors/webcam.min.js"></script>
    <script src="./../../assets/js/input-validation/certificate.js"defer></script>
    ';
    } elseif ($page == 'Reports') {
        echo '
    <script src="../../vendors/dataTables.buttons.min.js"></script>
    <script src="../../vendors/jszip.min.js"></script>
    <script src="../../vendors/buttons.html5.min.js"></script>
    <script src="../../vendors/buttons.print.min.js"></script>
    <script src="../../assets/js/pdfmake.js" type="text/javascript"></script>
    <script src="../../assets/js/vfs_fonts.js" type="text/javascript"></script>
    <script src="../../assets/js/brgy-pdf.js" type="text/javascript"></script>
    <script src="../../assets/js/business-pdf.js" type="text/javascript"></script>
    ';
    } elseif ($headerTitle == 'Changelog') {
        echo '
    <script src="../../vendors/dataTables.buttons.min.js"></script>
    <script src="../../vendors/jszip.min.js"></script>
    <script src="../../vendors/buttons.html5.min.js"></script>
    <script src="../../vendors/buttons.print.min.js"></script>
    <script src="../../assets/js/pdfmake.js" type="text/javascript"></script>
    <script src="../../assets/js/vfs_fonts.js" type="text/javascript"></script>
    <script src="../../assets/js/fees-changelog.js" type="text/javascript"></script>
    ';
    } elseif ($page === 'Complaints') {
        echo '
    <script src="./../../assets/js/input-validation/complaint.js"defer></script>';
    }
    ?>

    <script src="../../assets/js/alert.js" defer></script>
    <script src="../../assets/js/main.js" defer></script>


    <title><?php echo $headerTitle; ?> | Barangay Information System</title>
</head>

<body>
    <!--=============== NAV ===============-->
    <nav class="nav">
        <span class="nav__close">
            <i class='bx bx-x'></i>
        </span>

        <ul class="nav__list">
            <li class="nav__item">
                <a href="../dashboard/" class="nav__logo">
                    <img src="../../assets/img/fatima-logo.png" alt="">
                    <span class="nav__logo-text">BRGY. FATIMA<br>INFORMATION SYSTEM</br></span>
                </a>
            </li>

            <li class="nav__item <?php if ($page == 'Dashboard') {
                                        echo 'nav__item--active';
                                    } ?>">
                <a href="../dashboard/" class="nav__item-link">
                    <i class='bx bxs-dashboard'></i>
                    <span class="nav__item-text">Dashboard</span>
                </a>
            </li>
            <?php
            if ($user_role !== 'Barangay Clerk - Complaint Admin' && $user_role !== 'Barangay Clerk - Complaint Encoder' && $user_role !== 'Barangay Clerk - Generate Clearance') : ?>
                <li class="nav__item <?php if ($page == 'Residents') {
                                            echo 'nav__item--active';
                                        } ?>">
                    <a href="../residents/" class="nav__item-link">
                        <i class='bx bxs-id-card'></i>
                        <span class="nav__item-text">Residents</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if ($user_role === 'Administrator' || $user_role === 'Barangay Chairman' || $user_role === 'Barangay Secretary' || $user_role === 'Barangay Clerk - Generate Clearance') : ?>
                <li id="nav-certificates" class="nav__item <?php if ($page == 'Certificates') {
                                                                echo 'nav__item--active';
                                                            } ?>">
                    <a href="../certificates/" class="nav__item-link">
                        <i class='bx bxs-file-blank'></i>
                        <span class="nav__item-text">Certificates</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if ($user_role !== 'Barangay Clerk - Resident Admin' && $user_role !== 'Barangay Clerk - Resident Encoder' && $user_role !== 'Barangay Clerk - Generate Clearance') : ?>
                <li id="nav-certificates" class="nav__item <?php if ($page == 'Complaints') {
                                                                echo 'nav__item--active';
                                                            } ?>">
                    <a href="../complaint/" class="nav__item-link">
                        <i class='bx bxs-notepad'></i>
                        <span class="nav__item-text">Complaints</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if ($user_role === 'Administrator' || $user_role === 'Barangay Clerk - Generate Clearance' || $user_role === 'Barangay Chairman' || $user_role === 'Barangay Secretary') : ?>
                <li class="nav__item <?php if ($page == 'Reports') {
                                            echo 'nav__item--active';
                                        } ?>">
                    <a href="../reports/" class="nav__item-link">
                        <i class='bx bxs-bar-chart-alt-2'></i>
                        <span class="nav__item-text">Reports</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if ($user_role === 'Administrator' || $user_role === 'Barangay Secretary') : ?>

                <li class="nav__item <?php if ($page == 'Announcements') {
                                            echo 'nav__item--active';
                                        } ?>">
                    <a href="../announcements/" class="nav__item-link">
                        <i class='bx bxs-megaphone'></i>
                        <span class="nav__item-text">Announcements</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if ($user_role == 'Administrator' || $user_role == 'Barangay Secretary') : ?>
                <li class="nav__item <?php if ($page == 'Barangay Officials') {
                                            echo 'nav__item--active';
                                        } ?>">
                    <a href="../barangay-officials" class="nav__item-link">
                        <i class='bx bxs-user-voice'></i>
                        <span class="nav__item-text">Barangay Officials</span>
                    </a>
                </li>
            <?php endif ?>

            <?php if ($user_role === 'Administrator' || $user_role === 'Barangay Secretary' || $user_role === 'Barangay Clerk - Resident Admin' || $user_role === 'Barangay Clerk - Complaint Admin') : ?>
                <li class="nav__item <?php if ($page == 'Archive') {
                                            echo 'nav__item--active';
                                        } ?>">
                    <a href="../archive/" class="nav__item-link">
                        <i class='bx bxs-archive'></i>
                        <span class="nav__item-text">Archive</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if ($user_role === 'Administrator' || $user_role === 'Barangay Secretary') : ?>
                <li class="nav__item <?php if ($page == 'Fee Settings') {
                                            echo 'nav__item--active';
                                        } ?>">
                    <a href="../settings/" class="nav__item-link">
                        <i class='bx bxs-cog'></i>
                        <span class="nav__item-text">Fee Settings</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if ($user_role == 'Administrator') : ?>
                <li class="nav__item <?php if ($page == 'User Accounts') {
                                            echo 'nav__item--active';
                                        } ?>">
                    <a href="../user-accounts/" class="nav__item-link">
                        <i class='bx bxs-user-rectangle'></i>
                        <span class="nav__item-text">User Accounts</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
    <!--=============== HEADER ===============-->
    <header class="header">
        <span class="header__menu">
            <i class='bx bx-menu'></i>
        </span>
        <div class="header__title">
            <?php echo $headerTitle; ?>
        </div>

        <?php
        if ($user_role === 'Administrator') {
            $sql = "SELECT * FROM users WHERE role = :user_role";
            $statement = $pdo->prepare($sql);
            $statement->bindParam(':user_role', $user_role);
            $statement->execute();
            $count = $statement->rowCount();

            if ($count === 1) {
                $user = $statement->fetch(PDO::FETCH_ASSOC);

        ?> <a href="../user-accounts/view-user.php?user_id=<?php echo $user['user_id'] ?>" class="header__img">
                    <img src="../../assets/img/admin.svg" alt="user" />
                </a>
                <div class="header__role"> <?php echo $user_role ?></div>
                <span class="header__toggle dropdownBtn">
                    <i class='bx bxs-down-arrow'></i>
                </span>
                <div class="dropdown dropdown--user dropdownContent">
                    <ul>
                        <li class="dropdown__item">
                            <a href="../user-accounts/view-user.php?user_id=<?php echo $user['user_id'] ?>">
                                <i class='bx bx-user'></i>
                                User Profile
                            </a>
                        </li>
                        <li class="dropdown__item">
                            <a href="../../logout.php">
                                <i class='bx bx-exit'></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            <?php }
        } else {

            $query = "SELECT * FROM users, resident WHERE users.role = :user_role AND users.resident_id = :resident_id AND resident.resident_id = :resident_id";
            $statement2 = $pdo->prepare($query);
            $statement2->bindParam(':user_role', $user_role);
            $statement2->bindParam(':resident_id', $resident_id);
            $statement2->execute();

            $count2 = $statement2->rowCount();
            if ($count2 === 1) {
                $users = $statement2->fetch(PDO::FETCH_ASSOC);
            ?>
                <a href="../user-accounts/view-user.php?user_id=<?php echo $users['user_id'] ?>&role=<?php echo $users['role'] ?>" class="header__img">
                    <img src="../residents/images/<?php echo $users['img_url'] ?>" alt="user" />
                </a>
                <div class="header__role"> <?php echo $user_role  ?></div>


                <span class="header__toggle dropdownBtn">
                    <i class='bx bxs-down-arrow'></i>
                </span>
                <div class="dropdown dropdown--user dropdownContent">
                    <ul>
                        <li class="dropdown__item">
                            <a href="../user-accounts/view-user.php?user_id=<?php echo $users['user_id'] ?>&role=<?php echo $users['role'] ?>">
                                <i class='bx bx-user'></i>
                                User Profile
                            </a>
                        </li>
                        <li class="dropdown__item">
                            <a href="../../logout.php">
                                <i class='bx bx-exit'></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
        <?php
            }
        } ?>
    </header>