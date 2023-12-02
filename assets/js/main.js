
/*=============== MODALS ===============*/
let currentlyOpenModals = [];

const noModalsOpen = () => !currentlyOpenModals.length;

const openModal = (modalId) => {
  const modalWrapper = document.getElementById(modalId);
  modalWrapper.classList.add("modal--show");
  currentlyOpenModals.push(modalWrapper);
};

// By definition, it's always the topmost modal that will be closed first
const closeTopmostModal = () => {
  if (noModalsOpen()) {
    return;
  }

  const modalWrapper = currentlyOpenModals[currentlyOpenModals.length - 1];
  modalWrapper.classList.remove("modal--show");
  currentlyOpenModals.pop();
};

const modalTriggers = document.querySelectorAll(".modal-trigger");
modalTriggers.forEach((modalTrigger) => {
  modalTrigger.addEventListener("click", (clickEvent) => {
    const trigger = clickEvent.target;
    const modalId = trigger.getAttribute("data-modal-id");
    openModal(modalId);
  });
});

// Otherwise, clicking the content of a modal will propagate the click to the modal wrapper,
// and that will close the entire thing. That's not what we want!
document.querySelectorAll(".modal__window").forEach((modal) => {
  modal.addEventListener("click", (clickEvent) => {
    clickEvent.stopPropagation();
  });
});

const modalWrappers = document.querySelectorAll(".modal__wrapper");
modalWrappers.forEach((modalWrapper) => {
  modalWrapper.addEventListener("click", () => {
    closeTopmostModal();
  });
});

document.querySelectorAll(".close").forEach((closeModalButton) => {
  closeModalButton.addEventListener("click", () => {
    closeTopmostModal();
  });
});

document.body.addEventListener("keyup", (keyEvent) => {
  if (keyEvent.key === "Escape") {
    closeTopmostModal();
  }
});
// Function to hide and disable the button
function hideAndDisableButton(button) {
  button.style.display = "none"; // Hide the button
  button.disabled = true; // Disable the button
}

function checkButtonState() {
  let buttons = document.querySelectorAll("#regenerate-clearance");
  let currentTime = new Date().getTime();
  let twentyFourHoursInMillis = 24 * 60 * 60 * 1000;

  buttons.forEach(function (button) {
      let dateIssued = button.getAttribute("data-date-issued");
      if (dateIssued) {
          let dateIssuedTime = new Date(dateIssued).getTime();

          if (currentTime >= dateIssuedTime + twentyFourHoursInMillis) {
              hideAndDisableButton(button);
          }
      }
  });
}

// Call the function to check the button's state on page load
checkButtonState();

// SELECTING COMPLAINANT, RESPONDENT, AND MEDIATOR FROM MODAL
document.addEventListener("DOMContentLoaded", function() {
  var complainantId, respondentId, mediatorId;

  document.querySelectorAll('.select-complainant').forEach(function(element) {
    element.addEventListener("click", function() {
      // Event listener for selecting a complainant
      complainantId = this.dataset.complainantId;
      document.getElementById("modal-complainant").classList.remove("modal--show");
      document.getElementById("modal-respondent").classList.add("modal--show");
      document.getElementById("complainant-resident-id").value = complainantId;
    });
  });

  document.querySelectorAll('.select-respondent').forEach(function(element) {
    element.addEventListener("click", function() {
      // Event listener for selecting a respondent
      respondentId = this.dataset.respondentId;
      document.getElementById("modal-respondent").classList.remove("modal--show");
      document.getElementById("modal-mediator").classList.add("modal--show");
      document.getElementById("respondent-resident-id").value = respondentId;
    });
  });

  document.querySelectorAll('.select-mediator').forEach(function(element) {
    element.addEventListener("click", function() {
      // Event listener for selecting a mediator
      mediatorId = this.dataset.mediatorId;
      if (typeof complainantId !== 'undefined') {
        window.location.href = "resident-complaint-create.php?complainant_id=" + complainantId + "&respondent_id=" + respondentId + "&mediator_id=" + mediatorId;
      } else {
        window.location.href = "non-resident-complaint-create.php?respondent_id=" + respondentId + "&mediator_id=" + mediatorId;
      }
    });
  });

  document.querySelectorAll('.modal__close').forEach(function(element) {
    element.addEventListener("click", function() {
      // Event listener for modal close button
      this.closest('.modal__wrapper').classList.remove("modal--show");
    });
  });

  document.getElementById("modal-respondent-back").addEventListener("click", function() {
    document.getElementById("modal-respondent").classList.remove("modal--show");
    document.getElementById("modal-complainant").classList.add("modal--show");
  });

  document.getElementById("modal-mediator-back").addEventListener("click", function() {
    document.getElementById("modal-mediator").classList.remove("modal--show");
    document.getElementById("modal-respondent").classList.add("modal--show");
  });
});

// CHOOSE CERTIFICATE OFFICER IN CHARGE
document.addEventListener("DOMContentLoaded", function() {
  let selectOfficialButtons = document.querySelectorAll(".select-official");
  let wrapper = document.getElementById("official-modal");
  let chooseOfficialButton = document.getElementById("choose_official");
  let printButton = document.getElementById("print-btn");

  for (let i = 0; i < selectOfficialButtons.length; i++) {
    selectOfficialButtons[i].addEventListener("click", function(event) {
      event.preventDefault();

      let officialId = this.getAttribute("data-official-id");

      // Make an AJAX request to fetch the Official details
      let official = new XMLHttpRequest();
      official.open("GET", "./../json_response/official.php?official_id=" + officialId, true);
      official.onreadystatechange = function() {
        if (official.readyState === 4 && official.status === 200) {
          // Parse the response JSON
          let officialDetails = JSON.parse(official.responseText);

          // Official Id
          if (officialDetails) {
            printButton.disabled = false;

            let official_id = document.getElementById("official_id");
            official_id.value = officialDetails.official_id;

            // Update the official input field
            let officialInput = document.getElementById("off_name");
            officialInput.innerText = officialDetails.name;

            // Update the position input field
            let positionInput = document.getElementById("off_position");
            positionInput.innerText = officialDetails.position;

            // Close the modal
            wrapper.classList.remove('modal--show');
            chooseOfficialButton.style.display = 'none';
          }
          
        }
      };
      official.send();
    });
  }
});

// UPDATE MEDIATOR

document.addEventListener("DOMContentLoaded", function() {
  let selectMediatorButtons = document.querySelectorAll(".update-mediator");
  let wrapper = document.getElementById("modal-update-mediator");

  for (let i = 0; i < selectMediatorButtons.length; i++) {
    selectMediatorButtons[i].addEventListener("click", function(event) {
      event.preventDefault();

      let officialId = this.getAttribute("data-mediator-id");

      // Make an AJAX request to fetch the mediator details
      let mediator = new XMLHttpRequest();
      mediator.open("GET", "./json_response/update-mediator-details.php?official_id=" + officialId, true);
      mediator.onreadystatechange = function() {
        if (mediator.readyState === 4 && mediator.status === 200) {
          // Parse the response JSON
          let mediatorDetails = JSON.parse(mediator.responseText);

          // Update the mediatorid  input field
          let officialidInput = document.getElementById("official-id");
          officialidInput.value = mediatorDetails.official_id;

          // Update the mediator input field
          let mediatorInput = document.getElementById("mediator");
          mediatorInput.value = mediatorDetails.name;

          // Update the position input field
          let positionInput = document.getElementById("off_position");
          positionInput.value = mediatorDetails.position;

          // Close the modal
          wrapper.classList.remove('modal--show');
        }
      };
      mediator.send();
    });
  }
});

// UPDATE RESPONDENT
document.addEventListener("DOMContentLoaded", function() {
  let selectRespondentButtons = document.querySelectorAll(".update-respondent");
  let wrapper = document.getElementById("modal-update-respondent");

  for (let i = 0; i < selectRespondentButtons.length; i++) {
    selectRespondentButtons[i].addEventListener("click", function(event) {
      event.preventDefault();

      let residentID = this.getAttribute("data-respondent-id");

      // Make an AJAX request to fetch the respondent details
      let respondent = new XMLHttpRequest();
      respondent.open("GET", "./json_response/update-respondent-details.php?resident_id=" + residentID, true);
      respondent.onreadystatechange = function() {
        if (respondent.readyState === 4 && respondent.status === 200) {
          // Parse the response JSON
          let respondentDetails = JSON.parse(respondent.responseText);

          // Update the respondent_id  input field
          let residentidInput = document.getElementById("respondent-resident-id");
          residentidInput.value = respondentDetails.resident_id;

          // Update the respondent name input field
          let respondentnameInput = document.getElementById("respondent");
          respondentnameInput.value = respondentDetails.name;

          // Update the address input field
          let addressInput = document.getElementById("respondent-address");
          addressInput.value = respondentDetails.address;

          // Close the modal
          wrapper.classList.remove('modal--show');
        }
      };
      respondent.send();
    });
  }
});
// UPDATE COMPLAINANT
document.addEventListener("DOMContentLoaded", function() {
  let selectComplainantButtons = document.querySelectorAll(".update-complainant");
  let wrapper = document.getElementById("modal-update-complainant");

  for (let i = 0; i < selectComplainantButtons.length; i++) {
    selectComplainantButtons[i].addEventListener("click", function(event) {
      event.preventDefault();

      let residentID = this.getAttribute("data-complainant-id");

      // Make an AJAX request to fetch the respondent details
      let complainant = new XMLHttpRequest();
      complainant.open("GET", "./json_response/update-complainant-details.php?resident_id=" + residentID, true);
      complainant.onreadystatechange = function() {
        if (complainant.readyState === 4 && complainant.status === 200) {
          // Parse the response JSON
          let complainantDetails = JSON.parse(complainant.responseText);

          // Update the complainant_id  input field
          let residentidInput = document.getElementById("complainant-resident-id");
          residentidInput.value = complainantDetails.resident_id;

          // Update the complainant name input field
          let complainantnameInput = document.getElementById("complainant");
          complainantnameInput.value = complainantDetails.name;

          // Update the address input field
          let addressInput = document.getElementById("complainant-address");
          addressInput.value = complainantDetails.address;

          // Close the modal
          wrapper.classList.remove('modal--show');
          
        }
      };
      complainant.send();
    });
  }
});


// UPDATE RESPONDENT
document.addEventListener("DOMContentLoaded", function() {
  let selectRespondentButtons = document.querySelectorAll(".update-respondent");
  let wrapper = document.getElementById("modal-update-respondent");

  for (let i = 0; i < selectRespondentButtons.length; i++) {
    selectRespondentButtons[i].addEventListener("click", function(event) {
      event.preventDefault();

      let residentID = this.getAttribute("data-respondent-id");

      // Make an AJAX request to fetch the respondent details
      let respondent = new XMLHttpRequest();
      respondent.open("GET", "./json_response/update-respondent-details.php?resident_id=" + residentID, true);
      respondent.onreadystatechange = function() {
        if (respondent.readyState === 4 && respondent.status === 200) {
          // Parse the response JSON
          let respondentDetails = JSON.parse(respondent.responseText);

          // Update the respondent_id  input field
          let residentidInput = document.getElementById("respondent-resident-id");
          residentidInput.value = respondentDetails.resident_id;

          // Update the respondent name input field
          let respondentnameInput = document.getElementById("respondent");
          respondentnameInput.value = respondentDetails.name;

          // Update the address input field
          let addressInput = document.getElementById("respondent-address");
          addressInput.value = respondentDetails.address;

          // Close the modal
          wrapper.classList.remove('modal--show');
        }
      };
      respondent.send();
    });
  }
});

document.addEventListener("DOMContentLoaded", function() {
  let purposeSelect = document.getElementById("purpose");
  let categorySelect = document.getElementById("certificate-category");

  if (purposeSelect) {
    function updateFee() {
      let selectedPurpose = purposeSelect.value;
      // Make an AJAX request to fetch the clearance price based on purpose and certificate_category
      let clearancePrice = new XMLHttpRequest();

      let url = "./json_response/purpose-fee.php?purpose=" + selectedPurpose;

      if (categorySelect) {
        let selectedCategory = categorySelect.value ? categorySelect.value : null;

        if (selectedCategory) {
          url += "&certificate_category=" + selectedCategory;
        }
      }

      clearancePrice.open("GET", url, true);
      clearancePrice.onreadystatechange = function() {
        if (clearancePrice.readyState === 4 && clearancePrice.status === 200) {
          // Parse the response JSON
          let clearancePriceDetails = JSON.parse(clearancePrice.responseText);

          // Set the clearance fee input field
          let feeInput = document.getElementById("fee");
          feeInput.value = clearancePriceDetails.fee;

          let feeSettingId = document.getElementById("fee-setting-id");
          feeSettingId.value = clearancePriceDetails.fee_setting_id;
        }
      };
      clearancePrice.send();
    }

    purposeSelect.addEventListener("change", updateFee);


    if (categorySelect) {
      categorySelect.addEventListener("change", updateFee);
    }
  
  }
});



/*=============== DATATABLES ===============*/

$("#official-table-modal").DataTable({
  dom: "ftpr",
  bSort: false,
  pageLength: 5,
  // scrollX: true,
  language: {
    search: "_INPUT_",
    searchPlaceholder: "Search",
    paginate: {
      next: ">",
      previous: "<",
    },
  },
});


$(document).ready(function () {
  $("#table").DataTable({
    dom: "ftpr",
    bSort: false,
    pageLength: 5,
    search: {
      regex: false,
      smart: false,
    },
    // scrollX: true,
    language: {
      search: "_INPUT_",
      searchPlaceholder: "Search",
      paginate: {
        next: ">",
        previous: "<",
      },
    },
  });

  $("#respondent-table-modal").DataTable({
    dom: "ftpr",
    bSort: false,
    pageLength: 5,
    // scrollX: true,
    language: {
      search: "_INPUT_",
      searchPlaceholder: "Search",
      paginate: {
        next: ">",
        previous: "<",
      },
    },
  });

  $("#mediator-table-modal").DataTable({
    dom: "ftpr",
    bSort: false,
    pageLength: 5,
    // scrollX: true,
    language: {
      search: "_INPUT_",
      searchPlaceholder: "Search",
      paginate: {
        next: ">",
        previous: "<",
      },
    },
  });
  

  $("#modal-table").DataTable({
    dom: "ftpr",
    bSort: false,
    pageLength: 5,
    language: {
      search: "_INPUT_",
      searchPlaceholder: "Search",
      paginate: {
        next: ">",
        previous: "<",
      },
    },
  });

  $("#good-moral-history-modal").DataTable({
    dom: "ftpr",
    bSort: false,
    pageLength: 5,
    // scrollX: true,
    language: {
      search: "_INPUT_",
      searchPlaceholder: "Search",
      paginate: {
        next: ">",
        previous: "<",
      },
    },
  });

  $("#complaint-history-modal").DataTable({
    dom: "ftpr",
    bSort: false,
    pageLength: 5,
    // scrollX: true,
    language: {
      search: "_INPUT_",
      searchPlaceholder: "Search",
      paginate: {
        next: ">",
        previous: "<",
      },
    },
  });

  $("#reports-table").DataTable({
    dom: "ftpr",
    bSort: false,
    pageLength: 8,
    language: {
      search: "_INPUT_",
      searchPlaceholder: "Search",
      paginate: {
        next: ">",
        previous: "<",
      },
    },
    responsive: true,
  });

  /*=============== RESIDENTS DROPDOWN FILTER ===============*/
  const wtable = $("#table").DataTable();
  const select = document.querySelector("#residents__filter");

  $(select).on("change", function () {
    const option = select.options[select.selectedIndex];
    wtable.search(option.value).draw();
  });

  if (select) {
    select.onchange = function () {
      const option = select.options[select.selectedIndex];

      document.querySelector(".dataTables_filter input").value = option.value;
      document.querySelector(".dataTables_filter input").focus();
    };
  }

  /*=============== RESIDENTS ARCHIVE DROPDOWN FILTER ===============*/
  const archiveTable = $("#residentArchive-table").DataTable();
  const archiveSelect = document.querySelector("#residents__filter");

  $(archiveSelect).on("change", function () {
    const archiveOption = archiveSelect.options[archiveSelect.selectedIndex];
    archiveTable.search(archiveOption.value).draw();
  });

  if (archiveSelect) {
    archiveSelect.onchange = function () {
      const archiveOption = archiveSelect.options[archiveSelect.selectedIndex];

      document.querySelector(".dataTables_filter input").value =
        archiveOption.value;
      document.querySelector(".dataTables_filter input").focus();
    };
  }

  /*=============== EXACT MATCH SEARCH ===============*/

  // $(".dataTables_filter input")
  //   .unbind()
  //   .bind("keyup", function () {
  //     var searchTerm = this.value.toLowerCase(),
  //       regex = "\\b" + searchTerm + "\\b";
  //     $("#residents-table")
  //       .DataTable()
  //       .rows()
  //       .search(regex, true, false)
  //       .draw();
  //   });
});

const dropdownBtns = document.querySelectorAll(".dropdownBtn");
// const dropdownContents = document.querySelectorAll(".dropdownContent");

dropdownBtns.forEach((dropdownBtn) => {
  const dropdownContent = dropdownBtn.nextElementSibling;

  dropdownBtn.addEventListener("click", () => {
    if (dropdownContent.classList.contains("dropdownContent--show")) {
      dropdownContent.classList.remove("dropdownContent--show");
    } else {
      const currentActive = document.querySelector(
        ".dropdownContent.dropdownContent--show"
      );

      if (currentActive) {
        currentActive.classList.remove("dropdownContent--show");
      }

      dropdownContent.classList.add("dropdownContent--show");
    }
  });
});

// export dropdown
const exportBtn = document.querySelector("#export-resident"),
dropdownExport = document.querySelector(".dropdown--export");

if (exportBtn) {
  exportBtn.addEventListener("click", () => {
    dropdownExport.classList.toggle("dropdown--export--show");
  });
}


// history dropdown
const historyBtn = document.querySelector("#resident-history"),
dropdownHistory = document.querySelector(".dropdown--history");

if (historyBtn) {
  historyBtn.addEventListener("click", () => {
    dropdownHistory.classList.toggle("dropdown--history--show");
  });
}


// hide dropdown
const dropdownLink = document.querySelectorAll(
  "table tbody td .table__action-buttons .dropdown ul li a"
);

function hideDropdown() {
  // When we click on each dropdown link, we remove the show class
  dropdownUser.classList.remove("dropdown--user--show");
  headerToggle.classList.remove("header__toggle--rotate");
  certDropdowns.forEach(function (dropdown) {
    dropdown.classList.remove("dropdown--cert--show");
  });
}
dropdownLink.forEach((x) => x.addEventListener("click", hideDropdown));


/*=============== DISPLAY SAVE BUTTON IF EMERGENCY TAB IS ACTIVE ===============*/
// const tabItems = document.querySelectorAll('.profile-info__item');
// const residentProfileFooter = document.querySelector('.card__footer.residentProfileFooter')

// tabItems.forEach(tabItem => {
// tabItem.addEventListener('click', () => {
// if(tabItem.classList.contains('emergencyTab')){
//   residentProfileFooter.classList.add('residentProfileFooter--show')
//   } else{
//       residentProfileFooter.classList.remove('residentProfileFooter--show')
//   }
//   })
// })

/*=============== PROFILE INFO VIEW TABS ===============*/
const profileTabs = document.querySelectorAll(
  ".profile-info__list .profile-info__item"
);
const profileTabContents = document.querySelectorAll(
  ".profile-info__content"
);

profileTabs.forEach(function (profileTab, profileTab_index) {
  profileTab.addEventListener("click", function () {
    profileTabs.forEach(function (profileTab) {
      profileTab.classList.remove("profile-info__item--active");
    });

    profileTab.classList.add("profile-info__item--active");

    profileTabContents.forEach(function (
      profileTabContent,
      profileTabContent_index
    ) {
      if (profileTabContent_index == profileTab_index) {
        profileTabContent.style.display = "block";
      } else {
        profileTabContent.style.display = "none";
      }
    });
  });
});

/*=============== HISTORY INFO VIEW TABS ===============*/
const historyTabs = document.querySelectorAll(
  ".history-info__list .history-info__item"
);
const historyTabContents = document.querySelectorAll(
  ".history-info__content"
);

historyTabs.forEach(function (historyTab, historyTab_index) {
  historyTab.addEventListener("click", function () {
    historyTabs.forEach(function (historyTab) {
      historyTab.classList.remove("history-info__item--active");
    });

    historyTab.classList.add("history-info__item--active");

    historyTabContents.forEach(function (
      historyTabContent,
      historyTabContent_index
    ) {
      if (historyTabContent_index == historyTab_index) {
        historyTabContent.style.display = "block";
      } else {
        historyTabContent.style.display = "none";
      }
    });
  });
});



function switchTabs(currentTab, nextTab) {
  const currentTabElement = document.querySelector(`.${currentTab}`);
  const nextTabElement = document.querySelector(`.${nextTab}`);
  const currentTabContent = document.querySelector(`.profile-info__content.${currentTab}`);
  const nextTabContent = document.querySelector(`.profile-info__content.${nextTab}`);

  currentTabElement.classList.remove('profile-info__item--active');
  currentTabContent.style.display = 'none';

  nextTabElement.classList.add('profile-info__item--active');
  nextTabContent.style.display = 'block';
}

const paginationButtons = document.querySelectorAll('.pagination__button');

paginationButtons.forEach(button => {
  button.addEventListener('click', function () {
    const currentTab = this.getAttribute('data-current-tab');
    const nextTab = this.getAttribute('data-next-tab');

    switchTabs(currentTab, nextTab);
  });
});
/*===============REPORTS TABS ===============*/

const tabs = document.querySelectorAll(".tab");
const tabContents = document.querySelectorAll(".tabContent");

tabs.forEach(function (tab, tab_index) {
  tab.addEventListener("click", function () {
    tabs.forEach(function (tab) {
      tab.classList.remove("tab--active");
    });

    tab.classList.add("tab--active");

    tabContents.forEach(function (tabContent, tabContent_index) {
      if (tabContent_index == tab_index) {
        tabContent.style.display = "grid";
      } else {
        tabContent.style.display = "none";
      }
    });
  });
});

/*==================== SHOW MENU ====================*/
const nav = document.querySelector(".nav"),
  menu = document.querySelector(".header__menu"),
  close = document.querySelector(".nav__close");

/*===== MENU SHOW =====*/
/* Validate if constant exists */
if (menu) {
  menu.addEventListener("click", () => {
    nav.classList.add("show");
  });
}

/*===== MENU HIDDEN =====*/
/* Validate if constant exists */
if (close) {
  close.addEventListener("click", () => {
    nav.classList.remove("show");
  });
}

/*=============== PROFILE INFO VIEW INPUTS ===============*/
// const viewprofileInputs = document.querySelectorAll(
//   ".profile-info__content.viewprofile .input-viewprofile"
// );
// const loginBtn = document.querySelector("#login-editprofile");
// const editBtn = document.querySelector("#edit-viewprofile");
// const saveBtn = document.querySelector("#save-editprofile");
// const cancelBtn = document.querySelector(".modal-viewprofile .modal__cancel");
// const footer = document.querySelector(".modal-viewprofile .modal__footer");
// const headerText = document.querySelector(".modal__header-content--left");

// viewprofileInputs.forEach((viewprofileInput) => {
//   viewprofileInput.disabled = true;
// });

// function toggleEnable() {
//   viewprofileInputs.forEach((viewprofileInput) => {
//     if (viewprofileInput.disabled) {
//       viewprofileInput.disabled = false;
//     }
//   });
// }

// function hideShowBtns() {
//   editBtn.style.display = "none";
//   footer.style.display = "block";
//   headerText.innerHTML = "Edit Profile";
//   const modalContainer = this.closest(".modal__container");
//   modalContainer.classList.remove("modal--show");
// }

// function profileFooterActions() {
//   viewprofileInputs.forEach((viewprofileInput) => {
//     viewprofileInput.disabled = true;
//   });

//   editBtn.style.display = "block";
//   footer.style.display = "none";
//   headerText.innerHTML = "View Profile";
// }

// loginBtn.addEventListener("click", toggleEnable);
// loginBtn.addEventListener("click", hideShowBtns);
// saveBtn.addEventListener("click", profileFooterActions);
// cancelBtn.addEventListener("click", profileFooterActions);

/*=============== TOGGLE SWITCH ===============*/
const toggleswitches = document.querySelectorAll(".toggleswitch");
const ons = document.querySelectorAll(".toggleswitch__indicator--on");
const offs = document.querySelectorAll(".toggleswitch__indicator--off");

toggleswitches.forEach((toggleswitch) => {
  toggleswitch.addEventListener("click", () => {
    if (toggleswitch.checked) {
      offs.forEach((off) =>
        off.classList.remove("toggleswitch__indicator--darken")
      );
      ons.forEach((on) => on.classList.add("toggleswitch__indicator--light"));
    } else {
      ons.forEach((on) =>
        on.classList.remove("toggleswitch__indicator--light")
      );
      offs.forEach((off) =>
        off.classList.add("toggleswitch__indicator--darken")
      );
    }
  });
});

// toggleswitches.forEach((toggleswitch) => {
//   toggleswitch.addEventListener("click", () => {
//     if (toggleswitch.checked) {
//       const on = toggleswitch.closest(".toggleswitch__indicator--on");
//       on.classList.add("toggleswitch__indicator--light");

//       const off = toggleswitch.closest(".toggleswitch__indicator--off");
//       off.classList.remove("toggleswitch__indicator--darken");
//     } else {
//       const off = toggleswitch.closest(".toggleswitch__indicator--off");
//       off.classList.add("toggleswitch__indicator--darken");

//       const on = toggleswitch.closest(".toggleswitch__indicator--on");
//       on.classList.remove("toggleswitch__indicator--light");
//     }

//   });
// });

function printPage() {
  //Get the print button and put it into a variable
  var printBtn = document.getElementById("print-btn");
  var backBtn = document.getElementById("back-btn");
  //Set the buttons visibility to 'hidden'
  printBtn.style.visibility = "hidden";
  backBtn.style.visibility = "hidden";
  //Print the page content
  window.print();
  printBtn.style.visibility = "visible";
  backBtn.style.visibility = "visible";
}

/*==================== PRELOADER ====================*/

$(window).on("load", function () {
  setTimeout(() => {
    // $(".loader-wrapper").fadeIn("slow");
    $(".loader-wrapper").fadeOut("slow");
  }, 400);
});

/*==================== SHOW/HIDE PASSWORD ====================*/

function showPwd(id, el) {
  let x = document.getElementById(id);
  if (x.type === "password") {
    x.type = "text";
    el.className = "fa fa-eye-slash showpwd input__icon input__icon--right";
  } else {
    x.type = "password";
    el.className = "fa fa-eye showpwd input__icon input__icon--right";
  }
}

/*==================== DISABLE INPUT TOGGLE ====================*/

$("#disability_status")
  .change(function () {
    $("#type_disability").prop("disabled", !this.checked);
  })
  .change();


$("#deceased_status")
  .change(function () {
    $("#date_of_death").prop("disabled", !this.checked);
  })
  .change();

$("#voter_status")
  .change(function () {
    $("#voter_id").prop("disabled", !this.checked);
    $("#precinct_number").prop("disabled", !this.checked);
  })
  .change();

$("#vaccine_status")
  .change(function () {
    $("#vaccine_1").prop("disabled", !this.checked);
    $("#vaccine_date_1").prop("disabled", !this.checked);
    $("#vaccine_2").prop("disabled", !this.checked);
    $("#vaccine_date_2").prop("disabled", !this.checked);
    $("#booster_status").prop("disabled", !this.checked);
  })
  .change();

$("#booster_status")
  .change(function () {
    $("#booster_1").prop("disabled", !this.checked);
    $("#booster_date_1").prop("disabled", !this.checked);
    $("#booster_2").prop("disabled", !this.checked);
    $("#booster_date_2").prop("disabled", !this.checked);
  })
  .change();

$("#second_term")
  .change(function () {
    $("#second_start").prop("disabled", !this.checked);
  }).change();

$("#third_term")
  .change(function () {
    $("#third_start").prop("disabled", !this.checked);
  }).change();


let firstdose = document.querySelector("#vaccine_1");
let second_dose = document.querySelector("#vaccine_2");
let secvaxdate = document.querySelector("#vaccine_date_2");

if (second_dose && firstdose) {
  second_dose.disabled = true;
  firstdose.addEventListener("change", stateHandle);
}

function stateHandle() {
  if (document.querySelector("#vaccine_1").value === "Janssen") {
    second_dose.disabled = true;
    secvaxdate.disabled = true;
  } else {
    second_dose.disabled = false;
    secvaxdate.disabled = false;
  }
}

let boostfirstdose = document.querySelector("#booster_1");
let boost_second_dose = document.querySelector("#booster_2");
let boostsecvaxdate = document.querySelector("#booster_date_2");

if (boost_second_dose && boostfirstdose) {
  boost_second_dose.disabled = true;
  boostfirstdose.addEventListener("change", boostStateHandle);
}

function boostStateHandle() {
  if (document.querySelector("#booster_1").value === "Janssen") {
    boost_second_dose.disabled = true;
    boostsecvaxdate.disabled = true;
  } else {
    boost_second_dose.disabled = false;
    boostsecvaxdate.disabled = false;
  }
}

// age
// $('#dob').on('input', function () {
//   var empty = false;
//   $('form > input, form > select').each(function () {
//     if ($(this).val() == '') {
//       empty = true;
//     }
//   });

//   if (empty) {
//     $('#').attr('disabled', 'disabled');
//   } else {
//     $('#').removeAttr('disabled');
//   }
// });

//CLOSE MODAL
const modalWrapper = document.querySelector('.modal__wrapper');
const closeModal = document.querySelector('.modal__close');

closeModal.addEventListener("click", () => {
  modalWrapper.classList.remove('modal--show');
});

/*==================== HIDE VOTING TAB ====================*/
var result;

function calculateAge() {
  var dateInput = document.querySelector(".dob").value;
  // var ageInput = document.querySelector("#age");
  var dob = new Date(dateInput);

  var month_diff = Date.now() - dob.getTime();
  var age_dt = new Date(month_diff);
  var year = age_dt.getUTCFullYear();
  var age = Math.abs(year - 1970);

  result = age;
  // ageInput.value = result;

  var votingTab = document.querySelector(".votingTab");
  var votingTabContent = document.querySelector(".votingTabContent");
  var voterToggle = document.querySelector(".regVoterToggle");
  var scToggle = document.querySelector(".scToggle");

  if (result < 15) {
    votingTab.style.display = "none";
    // votingTabContent.style.display = "none";
    // voterToggle.checked = "false";
  } else if (result >= 15) {
    // voterToggle.checked = "true";
    votingTab.style.display = "inline-block";
    // votingTabContent.style.display = "block";
  }

  if (result >= 60) {
    scToggle.checked = "true";
  } else if (result < 60) {
    scToggle.disabled = "true";
  }

  // var vaccineTab = document.querySelector("#vaccineTab");
  // var vaccineTabContent = document.querySelector("#vaccineTabContent");
  //     if (result < 12) {
  //         vaccineTab.style.display = "none";
  //         vaccineTabContent.style.display = "none";
  //     } else {
  //       vaccineTab.style.display = "inline-block";
  //       vaccineTabContent.style.display = "block";
  //     }
}

// var ageValue = document.querySelector("#age").value;

function hideVoting() {
  if (ageValue < 15) {
    votingTab.style.display = "none";
    votingTabContent.style.display = "none";
    voterToggle.disabled = "true";

    console.log(ageValue);
  } else {
    votingTab.style.display = "inline-block";
    votingTabContent.style.display = "block";
    voterToggle.disabled = "false";
  }
}

function showCertificatePurpose(selectId) {
  const certificatePurpose = document.getElementById(selectId);
  const certificatePurposeValue = certificatePurpose.value;

  const clearancePurposeContainer = document.getElementById('clearance-purpose-container');
  const residencyPurposeContainer = document.getElementById('residency-purpose-container');
  const categoryContainer = document.getElementById('category-container');

  const brgyClearanceOption = document.getElementById('brgy-certificate-purpose');
  const residencyOption = document.getElementById('residency-purpose');
  const certificatesCategory = document.getElementById('certificate-category');


  if (certificatePurposeValue === "Barangay Clearance") {

    clearancePurposeContainer.style.display = "flex";
    brgyClearanceOption.setAttribute("required", "");
    brgyClearanceOption.removeAttribute("disabled", "true");

    residencyPurposeContainer.style.display = "none";
    residencyOption.setAttribute("disabled", "");
    residencyOption.removeAttribute("required", "true");

  } else if (certificatePurposeValue === "Residency Certificate") {

    residencyPurposeContainer.style.display = "flex";
    residencyOption.setAttribute("required", "");
    residencyOption.removeAttribute("disabled", "true");

    clearancePurposeContainer.style.display = "none";
    brgyClearanceOption.setAttribute("disabled", "");
    brgyClearanceOption.removeAttribute("required", "true");

    categoryContainer.style.display = "none";
    certificatesCategory.setAttribute("disabled", "");	
    certificatesCategory.removeAttribute("required", "true");

  } else {
    categoryContainer.style.display = "none";
    clearancePurposeContainer.style.display = "none";
    brgyClearanceOption.setAttribute("disabled", "");
    brgyClearanceOption.removeAttribute("required", "true");

    residencyPurposeContainer.style.display = "none";
    residencyOption.setAttribute("disabled", "");
    residencyOption.removeAttribute("required", "true");

    
    certificatesCategory.setAttribute("disabled", "");	
    certificatesCategory.removeAttribute("required", "true");

  }

}

function showClearanceCategory (selectId, containerId, optionId) {
  const clearancePurpose = document.getElementById(selectId);
  const clearancePurposeValue = clearancePurpose.value;

  const certificateCategoryContainer = document.getElementById(containerId);
  const certificateCategory = document.getElementById(optionId);
  


  if (clearancePurposeValue === 'Employment' || clearancePurposeValue === 'Driver\'s License' || clearancePurposeValue === 'Security License' ) {
    certificateCategoryContainer.style.display = 'flex';

    certificateCategory.setAttribute('required', '');
    certificateCategory.removeAttribute('disabled', "true");	

  } else {

    certificateCategoryContainer.style.display = 'none';

    certificateCategory.value = "";
    certificateCategory.setAttribute('disabled', '');	
    certificateCategory.removeAttribute('required', 'true');
  }

}


function showInput(selectId, inputId, inputId2) {
  const selectBox = document.getElementById(selectId);
  const inputBox = document.getElementById(inputId);
  const inputBox2 = document.getElementById(inputId2);
  
  const selectValue = selectBox.value;
  if (selectValue == "Others") {
    inputBox.style.display = "flex";
    inputBox2.setAttribute("required", "");
    inputBox2.removeAttribute("disabled", "true");

  } else {
    inputBox.style.display = "none";
    inputBox2.setAttribute("disabled", "");
    inputBox2.removeAttribute("required", "true");
  
  }
}
