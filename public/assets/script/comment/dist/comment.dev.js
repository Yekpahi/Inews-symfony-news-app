"use strict";

(function () {
  var modalTrigger = document.getElementById("modal-trigger");
  var modal = document.getElementById("modal");
  var closeButton = document.getElementById("close-modal"); // Detect the click on the #modal-trigger

  modalTrigger.addEventListener("click", function (event) {
    // Open the modal window - #modal (add is-visible class)
    event.preventDefault();
    modal.classList.add("is-visible");
  }); // Detect click on close button

  closeButton.addEventListener("click", function (event) {
    // Remove the is-visible class
    modal.classList.remove("is-visible");
  });
  document.addEventListener("keyup", function (event) {
    // Find the keycode of the escape key
    // console.log(event.keyCode); -> 27
    if (event.keyCode === 27) {
      modal.classList.remove("is-visible");
    }
  }); // On met un écouteur d'évènements sur tous les boutons répondre

  document.querySelectorAll("[data-reply]").forEach(function (element) {
    element.addEventListener("click", function () {
      document.querySelector("#comments_parentid").value = this.dataset.id;
    });
  });
})();