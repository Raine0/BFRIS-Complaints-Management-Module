/*=============== ALERTS ===============*/
const alert = document.querySelector(".alert");
// const alertClose = document.querySelector('.alert__close');

if (alert) {
  // alertClose.addEventListener("click", () => {
  //   alert.classList.add("alert--hide");
  // });

  setTimeout(function () {
    alert.classList.add("alert--hide");

  }, 2000);
}