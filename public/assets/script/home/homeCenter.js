//Masque articles

$(".expand-button").on("click", function () {
  $(".special-text").toggleClass("-expanded");

  if ($(".special-text").hasClass("-expanded")) {
    $(".expand-button").html("Collapse Content");
  } else {
    $(".expand-button").html("Continue Reading");
  }
});

// texte defilement haut

(function ($) {
  $(function () {
    var agMarqueeOptions = {
      //speed in milliseconds of the marquee
      // duration: 15500,
      duration: 20500,
      // duration: 5500,
      //gap in pixels between the tickers
      gap: 0,
      //time in milliseconds before the marquee will start animating
      delayBeforeStart: 0,
      //'left' or 'right'
      direction: "left",
      //true or false - should the marquee be duplicated to show an effect of continues flow
      duplicated: true,
      pauseOnHover: true,
      startVisible: true,
    };

    $(window).on("load", function () {
      var agMarqueeBlock = $(".js-marquee");

      agMarqueeBlock.marquee(agMarqueeOptions);
    });
  });
})(jQuery);

//card droit

function myFunction() {
  var element = document.getElementById("focus");
  element.classList.toggle("dark-mode");

  var x = document.getElementById("btnValue");
  if (x.innerHTML === "Dark mode") {
    x.innerHTML = "Light mode";
    x.classList.remove("btn-dark");
    x.classList.toggle("btn-light");
  } else {
    x.innerHTML = "Dark mode";
    x.classList.remove("btn-light");
    x.classList.toggle("btn-dark");
  }
}
