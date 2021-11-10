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

//card Share facebook

/* 
Social Share Links:
WhatsApp:
https://wa.me/?text=[post-title] [post-url]
Facebook:
https://www.facebook.com/sharer.php?u=[post-url]
Twitter:
https://twitter.com/share?url=[post-url]&text=[post-title]
Pinterest:
https://pinterest.com/pin/create/bookmarklet/?media=[post-img]&url=[post-url]&is_video=[is_video]&description=[post-title]
LinkedIn:
https://www.linkedin.com/shareArticle?url=[post-url]&title=[post-title]
*/

const facebookBtn = document.querySelector(".facebook-btn");
const twitterBtn = document.querySelector(".twitter-btn");
const pinterestBtn = document.querySelector(".pinterest-btn");
const linkedinBtn = document.querySelector(".linkedin-btn");
const whatsappBtn = document.querySelector(".whatsapp-btn");

function init() {
  const pinterestImg = document.querySelector(".pinterest-img");

  let postUrl = encodeURI(document.location.href);
  let postTitle = encodeURI("Hi everyone, please check this out: ");
  let postImg = encodeURI(pinterestImg.src);

  facebookBtn.setAttribute(
    "href",
    `https://www.facebook.com/sharer.php?u=${postUrl}`
  );

  twitterBtn.setAttribute(
    "href",
    `https://twitter.com/share?url=${postUrl}&text=${postTitle}`
  );

  pinterestBtn.setAttribute(
    "href",
    `https://pinterest.com/pin/create/bookmarklet/?media=${postImg}&url=${postUrl}&description=${postTitle}`
  );

  linkedinBtn.setAttribute(
    "href",
    `https://www.linkedin.com/shareArticle?url=${postUrl}&title=${postTitle}`
  );

  whatsappBtn.setAttribute(
    "href",
    `https://wa.me/?text=${postTitle} ${postUrl}`
  );
}

init();
