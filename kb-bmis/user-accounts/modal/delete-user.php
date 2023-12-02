<!--=============== MODALS ===============-->
<div class="modal__wrapper" id="modal-delete">
    <section class="modal__window modal__window--md">
        <header class="modal__header">
            <h3>Delete Profile</h3>
            <button type="button" class="modal__close close" aria-label="Close modal window">
                <i class='bx bx-x'></i>
            </button>
        </header>
        <div class="modal__body">
            <p>Are you sure you want delete <strong>
                    <?php echo $user['last_name'] ?>,
                    <?php echo $user['first_name'] ?>
                    <?php echo $user['mid_name'] ? mb_substr($user['mid_name'], 0, 1, 'UTF-8') . "." : "" ?>
                    <?php echo $user['suffix'] ?> (<?php echo $user["role"]; ?>)</strong>?
            </p>
            <br>

            <form action="controller/delete.php" method="POST">
                <section class="profile-info__basic-info">
                    <div class="profile-info__container">
                        <div class="input__wrapper">
                            <label>Password <strong style="color: red;">*</strong></label>
                            <div class="input__inner--with-leading-icon input__inner">
                                <i class="bx bxs-lock input__icon input__icon--left"></i>

                                <input name="password" type="password" id="password" class="input--light300 input--login" placeholder="Password" style="width: 100%;" required>

                                <i class="fa fa-eye showpwd input__icon input__icon--right" onClick="showPwd('password', this)"> </i>
                            </div>
                        </div>
                    </div>
                </section>

                <input type="text" hidden name="user_id" value="<?php echo $user['user_id']; ?>">
                <input type="text" hidden name="role" value="<?php echo $user['role']; ?>">
                <footer class="modal__footer">
                    <button type="submit" name="submit" class="button button--danger button--md">Delete</button>
                    <a class="button button--dark button--md modal__cancel close">Cancel</a>
                </footer>
            </form>
        </div>

    </section>
</div>