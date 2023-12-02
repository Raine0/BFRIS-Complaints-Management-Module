<?php

$page = 'login';
$headerTitle = 'Login';
include "db_conn.php";

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="assets/img/fatima-logo.png" type="image/png" />

    <!--=============== BOX ICONS ===============-->
    <link href="vendors/boxicons-2.0.9/css/boxicons.min.css" rel="stylesheet" />

    <!--=============== JQUERY ===============-->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!--=============== DATATABLES ===============-->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css" />
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js">
    </script>

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="assets/css/style.css" />

    <!--=============== MAIN JS ===============-->
    <script src="assets/js/main.js" defer></script>

    <title>Barangay Information System</title>
</head>

<body>
    <div class="login__container">
        <div class="wave">
            <img src="assets/img/layered-waves-haikei.svg" alt="" />
        </div>

        <img class="login__img" src="assets/img/fatima-logo.png" alt="" />

        <form action="check-login.php" class="login__form" method="POST">
            <div class="login__text">
                <img src="assets/img/bfris-bg.png" alt="" />
            </div>

            <div class="input__wrapper input__wrapper--block input__wrapper--login">
                <div class="input__inner--with-leading-icon input__inner">
                    <i class="bx bxs-user-rectangle input__icon input__icon--left"></i>
                    <input name="username" type="text" class="input--light300 input--login" placeholder="Username" />
                </div>
            </div>

            <div class="input__wrapper input__wrapper--block input__wrapper--login">
                <div class="input__inner--with-leading-icon input__inner">
                    <i class="bx bxs-lock input__icon input__icon--left"></i>
                    <input name="password" type="password" id="password" class="input--light300 input--login" placeholder="Password" />
                    <i class="fa fa-eye showpwd input__icon input__icon--right" onClick="showPwd('password', this)"> </i>
                </div>
            </div>
            <?php if (isset($_GET['error'])) { ?>
                <p class="error-message" style="margin-bottom: 15px;"><?php echo $_GET['error']; ?></p>
            <?php } ?>
            <button class="button button--primary button--block login__button">Login</button>

            <div class="login__msulogo">
                <img width="100%" height="100%" class="it-physics-logo" src="assets/img/it-physics-logo.png" alt="it-physics-logo">
                <img width="90%" height="90%" class="msu-logo" src="assets/img/msu-logo.png" alt="msu-logo">
            </div>
        </form>
    </div>
</body>

</html>