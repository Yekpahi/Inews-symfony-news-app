"use strict";

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance"); }

function _iterableToArray(iter) { if (Symbol.iterator in Object(iter) || Object.prototype.toString.call(iter) === "[object Arguments]") return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } }

function myfun() {
  var filesAmount = document.getElementById("myinput").files.length;

  for (var i = 0; i < filesAmount; i++) {
    reader = new FileReader();

    reader.onload = function () {
      if (reader.readyState = "complete") {
        placeToInsertImagePreview = document.getElementById("showImg");
        CreateIMGANDapendedImg = $($.parseHTML('<img class="appendedImg">')).attr("src", event.target.result); // IMGsurroundedByDiv = `<div class="imgHolder">` + CreateIMGANDapendedImg + `</div>`;

        IMGsurroundedByDiv = $($.parseHTML('<div class="imgHolder">')).html(CreateIMGANDapendedImg);
        IMGsurroundedByDiv.append('<span class="closeIT_removeImg">X</span>');
        $("#showImg").append(IMGsurroundedByDiv);
      } // readyState

    }; // onload


    setTimeout(function () {
      closeIT_removeImg = document.getElementsByClassName("closeIT_removeImg");
      arrayFormCloseBtn = _toConsumableArray(closeIT_removeImg);
      arrayFormCloseBtn.forEach(function (onebyone) {
        onebyone.addEventListener("click", function (e) {
          document.getElementById("showModelB4Del_removeImg").style.display = "flex";
          document.addEventListener("click", function (e) {
            if (e.target.classList[0] == "closeIT_removeImg") {
              closeIT_removeImg = e.target;
              document.getElementById("showModelB4Del_removeImg").style.display = "flex";
              showModelB4Del_removeImg.addEventListener("click", function (e) {
                if (e.target.id == "yesDelContact") {
                  closeIT_removeImg.parentElement.classList.add("b4Remove");
                  closeIT_removeImg.parentElement.addEventListener("transitionend", function () {
                    closeIT_removeImg.parentElement.remove();
                  });
                  document.getElementById("showModelB4Del_removeImg").style.display = "none";
                } else if (e.target.id == "closModalMsg") {
                  document.getElementById("showModelB4Del_removeImg").style.display = "none";
                }
              });
            }
          });
        });
      });
    }, 500);
    reader.readAsDataURL(document.getElementById("myinput").files[i]);
  }
}