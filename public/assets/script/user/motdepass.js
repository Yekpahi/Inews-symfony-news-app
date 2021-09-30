var parent = document.querySelector(".parent");

// password show/hide helper function
function showHide(input, showText) {
  if (input.getAttribute("type") === "password") {
    input.setAttribute("type", "text");
    showText.innerText = "hide";
  } else {
    input.setAttribute("type", "password");
    showText.innerText = "show";
  }
}

// event delegation on event target match
parent.addEventListener("click", (event) => {
  if (event.target.matches("span")) {
    var spanElm = event.target;
    var inputElm = spanElm.previousElementSibling;
    showHide(inputElm, spanElm);
  }
});
