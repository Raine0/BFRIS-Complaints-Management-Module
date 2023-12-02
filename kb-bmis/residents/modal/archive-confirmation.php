<!--=============== MODALS ===============-->
<div class="modal__wrapper" id="modal-delete">
    <section class="modal__window modal__window--md">
        <header class="modal__header">


            <h3>Archive Profile</h3>
            <button type="button" class="modal__close close" aria-label="Close modal window">
                <i class='bx bx-x'></i>
            </button>
        </header>
        <div class="modal__body">

            <p>Are you sure you want to move <strong><?php echo $resident["first_name"]; ?>
                    <?php echo $resident["last_name"]; ?><?php if (empty($resident["suffix"])) {
                                                                echo "";
                                                            } else {
                                                                echo " " . $resident["suffix"];
                                                            } ?></strong> into the Residents Archive?</p>

        </div>
        <br>
        <form action="controller/archive.php" method="POST">
            <input type="text" hidden name="resident_id" value="<?php echo $resident["resident_id"]; ?>">

            <section class="profile-info__basic-info">
                <div class="profile-info__container">
                    <div class="input__wrapper">
                        <label>Reason of Archive </label>
                        <div class="input__inner">
                            <input type="text" name="remarks" class="input--light300 input--login" value="Change of Residency" readonly />
                        </div>
                    </div>
                </div>

                <div class="profile-info__container">
                    <div class="input__wrapper">
                        <label>Password <strong style="color: red;">*</strong></label>
                        <div class="input__inner--with-leading-icon input__inner">
                            <i class="bx bxs-lock input__icon input__icon--left"></i>
                            <input name="password" type="password" placeholder="Password" class="input--light300 input--login" id="password" required />
                            <i class="fa fa-eye showpwd input__icon input__icon--right" onClick="showPwd('password', this)"> </i>
                        </div>
                    </div>
                </div>
            </section>

            <footer class="modal__footer">
                <button type="submit" name="submit" class="button button--danger button--md">ARCHIVE</button>
                <a class="button button--dark button--md modal__cancel close">CANCEL</a>
            </footer>
        </form>
    </section>
</div>