 <!--================ MODALS ===============-->
 <div class="modal__wrapper" id="modal-filter">
     <section class="modal__window modal__window--md">
         <header class="modal__header">
             <h3>Filter Residents</h3>
             <button type="button" class="modal__close close" aria-label="Close modal window">
                 <i class='bx bx-x'></i>
             </button>
         </header>
         <br>

         <form method="GET">
             <section class="profile-info__basic-info">
                 <div class="profile-info__container">
                     <div class="input__wrapper">
                         <label for="resident-purok">Purok Name / Zone No.</label>
                         <div class="input__inner">
                             <div class="select__wrapper">
                                 <select name="purok" class="select select--resident-profile">
                                     <?php if (empty($_GET['purok']) || $_GET['purok'] === "") : ?>
                                         <option selected value="">Select</option>
                                     <?php else : ?>
                                         <option value="">Select</option>
                                         <option hidden selected value="<?php echo $_GET['purok'] ?>">
                                             <?php echo $_GET['purok'] ?></option>
                                     <?php endif; ?>

                                     <option value="Purok 1">Purok 1</option>
                                     <option value="Purok 2">Purok 2</option>
                                     <option value="Purok 3">Purok 3</option>
                                     <option value="Purok 4">Purok 4</option>
                                     <option value="Purok 5">Purok 5</option>
                                     <option value="Purok 6">Purok 6</option>
                                     <option value="Purok 7">Purok 7</option>
                                     <option value="Purok 8">Purok 8</option>
                                     <option value="Purok 9-A">Purok 9-A</option>
                                     <option value="Purok 9-B">Purok 9-B</option>
                                     <option value="Purok 10-A">Purok 10-A</option>
                                     <option value="Purok 10-B">Purok 10-B</option>
                                     <option value="Purok 11">Purok 11</option>
                                     <option value="Purok Lower 11-A">Purok Lower 11-A</option>
                                     <option value="Purok Purok Upper 11-A">Purok Upper 11-A</option>
                                     <option value="Purok 11-B">Purok 11-B</option>
                                     <option value="Purok 11-C">Purok 11-C</option>
                                     <option value="Purok 12">Purok 12</option>
                                     <option value="Purok 12-A">Purok 12-A</option>
                                     <option value="Purok 13">Purok 13</option>
                                     <option value="Purok 13-A">Purok 13-A</option>
                                     <option value="Purok 13-B">Purok 13-B</option>
                                     <option value="Purok 14">Purok 14</option>
                                     <option value="Purok 15">Purok 15</option>
                                     <option value="Purok Lower 16">Purok Lower 16</option>
                                     <option value="Purok Upper 16">Purok Upper 16</option>
                                     <option value="Purok 17-A">Purok 17-A</option>
                                     <option value="Purok 17-B">Purok 17-B</option>
                                     <option value="Purok 18">Purok 18</option>
                                     <option value="Purok 19">Purok 19</option>
                                     <option value="Purok 20">Purok 20</option>
                                     <option value="Purok 21">Purok 21</option>
                                     <option value="Purok 22">Purok 22</option>
                                     <option value="Purok 23">Purok 23</option>
                                     <option value="Purok 24">Purok 24</option>
                                     <option value="Purok 25">Purok 25</option>
                                     <option value="Purok 26">Purok 26</option>
                                     <option value="Purok 27">Purok 27</option>
                                     <option value="Purok 28">Purok 28</option>
                                     <option value="Purok 29">Purok 29</option>
                                     <option value="Purok 30">Purok 30</option>
                                 </select>
                             </div>
                         </div>
                     </div>
                 </div>

                 <div class="profile-info__container">
                     <div class="profile-info__container">
                         <div class="input__wrapper">
                             <label for="street">Street / Block </strong></label>
                             <div class="input__inner">
                                 <input type="text" name="street" id="street" title="Special Characters are not allowed." class="input--light300" value="<?php echo $_GET['street'] ?? "" ?>">
                             </div>
                         </div>
                     </div>
                 </div>

                 <div class="profile-info__container">
                     <div class="input__wrapper">
                         <label for="resident-civilstatus">Civil Status </label>
                         <div class="input__inner">
                             <div class="select__wrapper">
                                 <select name="civil_status" id="" class="select select--resident-profile">
                                     <?php if (empty($_GET['civil_status']) || $_GET['civil_status'] === "") : ?>
                                         <option selected value="">Select</option>
                                     <?php else : ?>
                                         <option value="">Select</option>
                                         <option hidden selected value="<?php echo $_GET['civil_status'] ?>">

                                             <?php echo $_GET['civil_status'] ?></option>
                                     <?php endif; ?>

                                     <option value="Single">Single</option>
                                     <option value="Married">Married</option>
                                     <option value="Widowed">Widowed</option>
                                     <option value="Divorced">Divorced</option>
                                     <option value="Legally Separated">Legally Separated</option>
                                     <option value="Annulled">Annulled</option>
                                     <option value="Nullified">Nullified</option>
                                     <option value="Undisclosed">Undisclosed</option>
                                 </select>
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="profile-info__container">
                     <div class="input__wrapper">
                         <label for="resident-civilstatus">Age Group</label>
                         <div class="input__inner">
                             <div class="select__wrapper">
                                 <select name="age" id="" class="select select--resident-profile">
                                     <?php if (empty($_GET['age']) or $_GET['age'] === "") : ?>
                                         <option selected value="">Select</option>
                                     <?php else : ?>
                                         <option value="">Select</option>
                                         <option hidden selected value="<?php echo $_GET['age'] ?>">
                                             <?php echo $_GET['age'] ?></option>
                                     <?php endif; ?>

                                     <option value="Children">Children (0-12)</option>
                                     <option value="Adolescents">Adolescents (13-18)</option>
                                     <option value="Adults">Adults (19-59)</option>
                                     <option value="Senior">Senior Citizen (60+)</option>
                                 </select>
                             </div>
                         </div>
                     </div>
                 </div>

                 <!-- <div class="profile-info__container">
                     <div class="input__wrapper">
                         <label for="resident-civilstatus">Voter Status</label>
                         <div class="input__inner">
                             <div class="select__wrapper">
                                 <select name="voter_status" id="" class="select select--resident-profile">
                                     <?php if (empty($_GET['voter_status']) or $_GET['voter_status'] === "--") { ?>
                                         <option selected value="--">Select</option>
                                     <?php } else { ?>
                                         <option hidden selected value="<?php echo $_GET['voter_status'] ?>">
                                             <?php echo $_GET['voter_status'] ?></option>
                                     <?php   } ?>
                                     <option value="no">Not Registered</option>
                                     <option value="Registered Voter">Registered</option>
                                 </select>
                             </div>
                         </div>
                     </div>
                 </div>

                 <div class="profile-info__container">
                     <div class="input__wrapper">
                         <label for="resident-civilstatus">Vaccinated</label>
                         <div class="input__inner">
                             <div class="select__wrapper">
                                 <select name="vaccine_status" id="" class="select select--resident-profile">
                                     <?php if (empty($_GET['vaccine_status']) or $_GET['vaccine_status'] === "--") { ?>
                                         <option selected value="--">Select</option>
                                     <?php } else { ?>
                                         <option hidden selected value="<?php echo $_GET['vaccine_status'] ?>">
                                             <?php echo $_GET['vaccine_status'] ?></option>
                                     <?php   } ?>
                                     <option value="no">Not Vaccinated</option>
                                     <option value="Vaccinated">Vaccinated</option>
                                 </select>
                             </div>
                         </div>
                     </div>
                 </div> -->

             </section>
             <footer class="modal__footer">
                 <button type="submit" class="button button--danger button--md">Filter</button>
                 <a href="#" class="button button--dark button--md modal__cancel close">Cancel</a>
             </footer>
         </form>
     </section>
 </div>