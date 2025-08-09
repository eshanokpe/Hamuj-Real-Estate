/*
  Template Name: NewVilla - Real Estate HTML Template
  Author Name: Hook theme
  Author URL: https://themeforest.net/user/hooktheme
  Version: 1.0.0
*/
AOS.init({
  once: true,
  disable: function () {
    var maxWidth = 767;
    return window.innerWidth < maxWidth;
  },
});


"use strict";


const preLoader = function () {
  let preloaderWrapper = document.getElementById("preloader");
  window.onload = () => {
    let isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test( navigator.userAgent) ? true : false;
    if (!isMobile) {
      setTimeout(function () {
        preloaderWrapper.classList.add("preloaded");
      }, 300);
      setTimeout(function () {
        preloaderWrapper.remove();
      }, 1000);
    } else {
      preloaderWrapper.remove();
    }    
  };
};
preLoader();

/* getSiblings */
var getSiblings = function (elem) {
  const siblings = [];
  let sibling = elem.parentNode.firstChild;
  while (sibling) {
    if (sibling.nodeType === 1 && sibling !== elem) {
      siblings.push(sibling);
    }
    sibling = sibling.nextSibling;
  }
  return siblings;
};

/* Slide Up */
var slideUp = (target, time) => {
  const duration = time ? time : 500;
  target.style.transitionProperty = "height, margin, padding";
  target.style.transitionDuration = duration + "ms";
  target.style.boxSizing = "border-box";
  target.style.height = target.offsetHeight + "px";
  target.offsetHeight;
  target.style.overflow = "hidden";
  target.style.height = 0;
  window.setTimeout(() => {
    target.style.display = "none";
    target.style.removeProperty("height");
    target.style.removeProperty("overflow");
    target.style.removeProperty("transition-duration");
    target.style.removeProperty("transition-property");
  }, duration);
};

/* Slide Down */
var slideDown = (target, time) => {
  const duration = time ? time : 500;
  target.style.removeProperty("display");
  let display = window.getComputedStyle(target).display;
  if (display === "none") display = "block";
  target.style.display = display;
  const height = target.offsetHeight;
  target.style.overflow = "hidden";
  target.style.height = 0;
  target.offsetHeight;
  target.style.boxSizing = "border-box";
  target.style.transitionProperty = "height, margin, padding";
  target.style.transitionDuration = duration + "ms";
  target.style.height = height + "px";
  window.setTimeout(() => {
    target.style.removeProperty("height");
    target.style.removeProperty("overflow");
    target.style.removeProperty("transition-duration");
    target.style.removeProperty("transition-property");
  }, duration);
};

/* Get window top offset */
function TopOffset(el) {
  let rect = el.getBoundingClientRect(),
    scrollTop = window.pageYOffset || document.documentElement.scrollTop;
  return { top: rect.top + scrollTop };
}

/* Header sticky activation */
const headerStickyWrapper = document.querySelector("header");
const headerStickyTarget = document.querySelector(".header__sticky");

if (headerStickyTarget) {
  let headerHeight = headerStickyWrapper.clientHeight;
  window.addEventListener("scroll", function () {
    let StickyTargetElement = TopOffset(headerStickyWrapper);
    let TargetElementTopOffset = StickyTargetElement.top;

    if (window.scrollY > TargetElementTopOffset) {
      headerStickyTarget.classList.add("sticky");
    } else {
      headerStickyTarget.classList.remove("sticky");
    }
  });
}

/* Scroll up activation */
const scrollTop = document.getElementById("scroll__top");
if (scrollTop) {
  scrollTop.addEventListener("click", function () {
    window.scroll({ top: 0, left: 0, behavior: "smooth" });
  });
  window.addEventListener("scroll", function () {
    if (window.scrollY > 300) {
      scrollTop.classList.add("active");
    } else {
      scrollTop.classList.remove("active");
    }
  });
}


/* active class remove class activation */
const activeClassAction = function (toggle, target) {
  const to = document.querySelector(toggle),
    ta = document.querySelector(target);
  if (to && ta) {
    to.addEventListener("click", function (e) {
      e.preventDefault();
      let triggerItem = e.target;
      if (triggerItem.classList.contains("active")) {
        triggerItem.classList.remove("active");
        ta.classList.remove("active");
      } else {
        triggerItem.classList.add("active");
        ta.classList.add("active");
      }
    });
    document.addEventListener("click", function (event) {
      if (
        !event.target.closest(toggle) &&
        !event.target.classList.contains(toggle.replace(/\./, ""))
      ) {
        if (
          !event.target.closest(target) &&
          !event.target.classList.contains(target.replace(/\./, ""))
        ) {
          to.classList.remove("active");
          ta.classList.remove("active");
        }
      }
    });
  }
};

activeClassAction(".account__currency--link", ".dropdown__currency");
activeClassAction(".language__switcher", ".dropdown__language");


/* Offcanvas Mobile Menu Function */
const offcanvasHeader = function () {
  const offcanvasOpen = document.querySelector(
      ".offcanvas__header--menu__open--btn"
    ),
    offcanvasClose = document.querySelector(".offcanvas__close--btn"),
    offcanvasHeader = document.querySelector(".offcanvas__header"),
    offcanvasMenu = document.querySelector(".offcanvas__menu"),
    body = document.querySelector("body");
  /* Offcanvas SubMenu Toggle */
  if (offcanvasMenu) {
    offcanvasMenu
      .querySelectorAll(".offcanvas__sub_menu")
      .forEach(function (ul) {
        const subMenuToggle = document.createElement("button");
        subMenuToggle.classList.add("offcanvas__sub_menu_toggle");
        ul.parentNode.appendChild(subMenuToggle);
      });
  }
  /* Open/Close Menu On Click Toggle Button */
  if (offcanvasOpen) {
    offcanvasOpen.addEventListener("click", function (e) {
      e.preventDefault();
      if (e.target.dataset.offcanvas != undefined) {
        offcanvasHeader.classList.add("open");
        body.classList.add("mobile_menu_open");
      }
    });
  }
  if (offcanvasClose) {
    offcanvasClose.addEventListener("click", function (e) {
      e.preventDefault();
      if (e.target.dataset.offcanvas != undefined) {
        offcanvasHeader.classList.remove("open");
        body.classList.remove("mobile_menu_open");
      }
    });
  }

  /* Mobile submenu slideToggle Activation */
  let mobileMenuWrapper = document.querySelector(".offcanvas__menu_ul");
  if (mobileMenuWrapper) {
    mobileMenuWrapper.addEventListener("click", function (e) {
      let targetElement = e.target;
      if (targetElement.classList.contains("offcanvas__sub_menu_toggle")) {
        const parent = targetElement.parentElement;
        if (parent.classList.contains("active")) {
          targetElement.classList.remove("active");
          parent.classList.remove("active");
          parent
            .querySelectorAll(".offcanvas__sub_menu")
            .forEach(function (subMenu) {
              subMenu.parentElement.classList.remove("active");
              subMenu.nextElementSibling.classList.remove("active");
              slideUp(subMenu);
            });
        } else {
          targetElement.classList.add("active");
          parent.classList.add("active");
          slideDown(targetElement.previousElementSibling);
          getSiblings(parent).forEach(function (item) {
            item.classList.remove("active");
            item
              .querySelectorAll(".offcanvas__sub_menu")
              .forEach(function (subMenu) {
                subMenu.parentElement.classList.remove("active");
                subMenu.nextElementSibling.classList.remove("active");
                slideUp(subMenu);
              });
          });
        }
      }
    });
  }

  if (offcanvasHeader) {
    document.addEventListener("click", function (event) {
      if (
        !event.target.closest(".offcanvas__header--menu__open--btn") &&
        !event.target.classList.contains(
          ".offcanvas__header--menu__open--btn".replace(/\./, "")
        )
      ) {
        if (
          !event.target.closest(".offcanvas__header") &&
          !event.target.classList.contains(
            ".offcanvas__header".replace(/\./, "")
          )
        ) {
          offcanvasHeader.classList.remove("open");
          body.classList.remove("mobile_menu_open");
        }
      }
    });
  }

  /* Remove Mobile Menu Open Class & Hide Mobile Menu When Window Width in More Than 991 */
  if (offcanvasHeader) {
    window.addEventListener("resize", function () {
      if (window.outerWidth >= 992) {
        offcanvasHeader.classList.remove("open");
        body.classList.remove("mobile_menu_open");
      }
    });
  }
};
offcanvasHeader();



/* lightbox Activation */
const customLightboxHTML = `<div id="glightbox-body" class="glightbox-container">
    <div class="gloader visible"></div>
    <div class="goverlay"></div>
    <div class="gcontainer">
    <div id="glightbox-slider" class="gslider"></div>
    <button class="gnext gbtn" tabindex="0" aria-label="Next" data-customattribute="example">{nextSVG}</button>
    <button class="gprev gbtn" tabindex="1" aria-label="Previous">{prevSVG}</button>
    <button class="gclose gbtn" tabindex="2" aria-label="Close">{closeSVG}</button>
    </div>
    </div>`;
const lightbox = GLightbox({
  touchNavigation: true,
  lightboxHTML: customLightboxHTML,
  loop: true,
});

/* hero thumbnail swiper activation */
var swiper = new Swiper(".hero__thumbnail--swiper", {
  slidesPerView: 1,
  loop: true,
  clickable: true,
  spaceBetween: 30,
  speed: 1700,
  autoplay: {
    delay: 2000,
    disableOnInteraction: false,
  },
  breakpoints: {
    0: {
      slidesPerView: 1,
    },
  },
  pagination: {
    el: ".hero__thumbnail--slider .swiper-pagination",
    clickable: true,
  },
});

/* product swiper column4 activation */
var swiper = new Swiper(".featured__column4", {
  slidesPerView: 4,
  loop: false,
  clickable: true,
  spaceBetween: 30,
  speed: 800,
  breakpoints: {
    1366: {
      slidesPerView: 4,
    },
    1200: {
      slidesPerView: 3,
    },
    992: {
      slidesPerView: 2,
    },
    768: {
      slidesPerView: 2,
      spaceBetween: 30,
    },
    576: {
      slidesPerView: 2,
      spaceBetween: 20,
    },
    0: {
      slidesPerView: 1,
    },
  },
  navigation: {
    nextEl: ".featured__inner .swiper-button-next",
    prevEl: ".featured__inner .swiper-button-prev",
  },
});

/* popular featured column5 activation */
var swiper = new Swiper(".popular__featured--column5", {
  slidesPerView: 5,
  loop: true,
  clickable: true,
  spaceBetween: 30,
  speed: 1200,
  autoplay: {
    delay: 2000,
    disableOnInteraction: false,
  },
  breakpoints: {
    1200: {
      slidesPerView: 5,
      spaceBetween: 30,
    },
    992: {
      slidesPerView: 4,
      spaceBetween: 30,
    },
    768: {
      slidesPerView: 3,
      spaceBetween: 30,
    },
    480: {
      slidesPerView: 2,
      spaceBetween: 20,
    },
    0: {
      slidesPerView: 1,
    },
  },
  navigation: {
    nextEl: " .swiper-button-next",
    prevEl: " .swiper-button-prev",
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
});


/* testimonial swiper column2 activation */
var swiper = new Swiper(".testimonial__swiper--column2", {
  slidesPerView: 2,
  loop: false,
  clickable: true,
  spaceBetween: 30,
  speed: 800,
  breakpoints: {
    1200: {
      spaceBetween: 30,
      slidesPerView: 2,
    },
    992: {
      spaceBetween: 30,
      slidesPerView: 2,
    },
    768: {
      spaceBetween: 30,
      slidesPerView: 2,
    },
    576: {
      slidesPerView: 1,
      spaceBetween: 20,
    },
    0: {
      slidesPerView: 1,
    },
  },
  navigation: {
    nextEl: ".testimonial__container .swiper-button-next",
    prevEl: ".testimonial__container .swiper-button-prev",
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
});

/* blog column3 activation */
var swiper = new Swiper(".blog__column3", {
  slidesPerView: 3,
  loop: false,
  clickable: true,
  spaceBetween: 30,
  speed: 800,
  breakpoints: {
    1200: {
      spaceBetween: 30,
      slidesPerView: 3,
    },
    992: {
      spaceBetween: 30,
      slidesPerView: 3,
    },
    768: {
      spaceBetween: 30,
      slidesPerView: 2,
    },
    576: {
      slidesPerView: 1,
      spaceBetween: 20,
    },
    0: {
      slidesPerView: 1,
    },
  },
  navigation: {
    nextEl: " .swiper-button-next",
    prevEl: " .swiper-button-prev",
  },
});

/* brand logo column6 activation */
var swiper = new Swiper(".brand__logo--column6", {
  slidesPerView: 6,
  loop: false,
  clickable: true,
  spaceBetween: 30,
  speed: 800,
  breakpoints: {
    1200: {
      spaceBetween: 30,
    },
    992: {
      spaceBetween: 30,
      slidesPerView: 6,
    },
    992: {
      spaceBetween: 30,
      slidesPerView: 6,
    },
    576: {
      slidesPerView: 5,
      spaceBetween: 30,
    },
    480: {
      slidesPerView: 4,
      spaceBetween: 30,
    },
    300: {
      slidesPerView: 3,
      spaceBetween: 20,
    },
    200: {
      slidesPerView: 2,
    },
    0: {
      slidesPerView: 1,
    },
  },
});

/* about thumbnail swiper activation */
var swiper = new Swiper(".about__thumbnail--swiper", {
  slidesPerView: 1,
  loop: false,
  clickable: true,
  spaceBetween: 30,
  speed: 1500,
  // autoplay: {
  //   delay: 2000,
  //   disableOnInteraction: false,
  // },
  breakpoints: {
    0: {
      slidesPerView: 1,
    },
  },
  pagination: {
    el: ".about__thumbnail--slider .swiper-pagination",
    clickable: true,
  },
});

/* testimonial swiper column1 activation */
var swiper = new Swiper(".testimonial__swiper--column1", {
  slidesPerView: 1,
  loop: false,
  clickable: true,
  spaceBetween: 30,
  speed: 1500,
  autoplay: {
    delay: 2000,
    disableOnInteraction: false,
  },
  breakpoints: {
    0: {
      slidesPerView: 1,
    },
  },
  pagination: {
    el: " .swiper-pagination",
    clickable: true,
  },
});

/* testimonial style4 column1 activation */
var swiper = new Swiper(".testimonial__style4--column1", {
  slidesPerView: 1,
  loop: false,
  clickable: true,
  spaceBetween: 30,
  speed: 800,
  breakpoints: {
    0: {
      slidesPerView: 1,
    },
  },
  navigation: {
    nextEl: " .swiper-button-next",
    prevEl: " .swiper-button-prev",
  },
});

/* best selling column1 activation */
var swiper = new Swiper(".best__selling--column1", {
  slidesPerView: 1,
  loop: false,
  clickable: true,
  spaceBetween: 30,
  speed: 800,
  breakpoints: {
    0: {
      slidesPerView: 1,
    },
  },
  navigation: {
    nextEl: " .swiper-button-next",
    prevEl: " .swiper-button-prev",
  },
});

/* team member column2 activation */
var swiper = new Swiper(".team__member--column2", {
  slidesPerView: 2,
  loop: false,
  clickable: true,
  spaceBetween: 30,
  speed: 800,
  breakpoints: {
    480: {
      slidesPerView: 2,
    },
    0: {
      slidesPerView: 1,
    },
  },
  navigation: {
    nextEl: " .swiper-button-next",
    prevEl: " .swiper-button-prev",
  },
});


/* hero swiper column3 activation */
var swiperColumn3 = new Swiper(".hero__swiper--column3", {
  slidesPerView: 3,
  loop: false,
  clickable: true,
  spaceBetween: 15,
  speed: 800,
  breakpoints: {
    350: {
      slidesPerView: 3,
      spaceBetween: 15,
    },
    200: {
      slidesPerView: 2,
      spaceBetween: 15,
    },
    0: {
      slidesPerView: 1,
    },
  },
  navigation: {
    nextEl: " .swiper-button-next",
    prevEl: " .swiper-button-prev",
  },
});

/* hero swiper column1 activation */
var swiper = new Swiper(".hero__swiper--column1", {
  slidesPerView: 3,
  loop: false,
  clickable: true,
  spaceBetween: 20,
  speed: 1500,
  breakpoints: {
    0: {
      slidesPerView: 1,
    },
  },
  thumbs: {
    swiper: swiperColumn3,
  },
});


/* hero swiper column3 activation */
var swiperColumnGallery = new Swiper(".testimonial__gallery--swiper", {
  slidesPerView: 3,
  loop: true,
  clickable: true,
  spaceBetween: 15,
  speed: 800,
  direction: 'vertical',
  autoHeight: true,
  centeredSlides: true,
  breakpoints: {
    350: {
      slidesPerView: 3,
      spaceBetween: 15,
    },
    200: {
      slidesPerView: 3,
      spaceBetween: 15,
    },
    0: {
      slidesPerView: 1,
    },
  },
  pagination: {
    el: " .swiper-pagination",
    clickable: true,
  },
  
});

/* hero swiper column1 activation */
var swiper = new Swiper(".testimonial__content--swiper", {
  slidesPerView: 1,
  loop: true,
  clickable: true,
  spaceBetween: 20,
  speed: 1500,
  autoplay: {
    delay: 2000,
    disableOnInteraction: false,
  },
  breakpoints: {
    0: {
      slidesPerView: 1,
    },
  },
  thumbs: {
    swiper: swiperColumnGallery,
  },
  pagination: {
    el: " .swiper-pagination",
    clickable: true,
  },
});


/* product swiper column4 activation */
var swiper = new Swiper(".featured__column3", {
  slidesPerView: 3,
  loop: false,
  clickable: true,
  spaceBetween: 30,
  speed: 800,
  breakpoints: {
    1200: {
      slidesPerView: 3,
    },
    992: {
      slidesPerView: 2,
    },
    768: {
      slidesPerView: 2,
      spaceBetween: 30,
    },
    576: {
      slidesPerView: 2,
      spaceBetween: 20,
    },
    0: {
      slidesPerView: 1,
    },
  },
  pagination: {
    el: " .swiper-pagination",
    clickable: true,
  },
});


/* gallery swiper activation */
var swiper = new Swiper(".gallery__column3", {
  loop: true,
  clickable: true,
  slidesPerView: 3,
  spaceBetween: 30,
  slidesPerView: "auto",
  breakpoints: {
    1200: {
      slidesPerView: 3,
    },
    1200: {
      slidesPerView: 3,
    },
    768: {
      slidesPerView: 3,
      spaceBetween: 30,
    },
    480: {
      slidesPerView: 2,
      spaceBetween: 20,
    },
    0: {
      slidesPerView: 1,
    },
  },
});


/* CounterUp Activation */
const wrapper = document.getElementById("funfactId");
if (wrapper) {
  const counters = wrapper.querySelectorAll(".js-counter");
  const duration = 1000;

  let isCounted = false;
  document.addEventListener("scroll", function () {
    const wrapperPos = wrapper.offsetTop - window.innerHeight;
    if (!isCounted && window.scrollY > wrapperPos) {
      counters.forEach((counter) => {
        const countTo = counter.dataset.count;

        const countPerMs = countTo / duration;

        let currentCount = 0;
        const countInterval = setInterval(function () {
          if (currentCount >= countTo) {
            clearInterval(countInterval);
          }
          counter.textContent = Math.round(currentCount);
          currentCount = currentCount + countPerMs;
        }, 1);
      });
      isCounted = true;
    }
  });
}

/* Footer widget Activation */ 
let accordion = true;
const footerWidgetAccordion = function () {
  accordion = false;
  let footerWidgetContainer = document.querySelector(".main__footer");
  footerWidgetContainer?.addEventListener("click", function (evt) {
    let singleItemTarget = evt.target;
    if (singleItemTarget.classList.contains("footer__widget--button")) {
      const footerWidget = singleItemTarget.closest(".footer__widget"),
        footerWidgetInner = footerWidget.querySelector(
          ".footer__widget--inner"
        );
      if (footerWidget.classList.contains("active")) {
        footerWidget.classList.remove("active");
        slideUp(footerWidgetInner);
      } else {
        footerWidget.classList.add("active");
        slideDown(footerWidgetInner);
        getSiblings(footerWidget).forEach(function (item) {
          const footerWidgetInner = item.querySelector(
            ".footer__widget--inner"
          );

          item.classList.remove("active");
          slideUp(footerWidgetInner);
        });
      }
    }
  });
};

window.addEventListener("load", function () {
  if (accordion) {
    footerWidgetAccordion();
  }
});
window.addEventListener("resize", function () {
  document.querySelectorAll(".footer__widget").forEach(function (item) {
    if (window.outerWidth >= 768) {
      item.classList.remove("active");
      item.querySelector(".footer__widget--inner").style.display = "";
    }
  });
  if (accordion) {
    footerWidgetAccordion();
  }
});

/* fullwidth video  Activation */
const video = document.getElementById("video");
const circlePlayButton = document.getElementById("circle-play-b");
function togglePlay() {
	if (video.paused || video.ended) {
		video.play();
	} else {
		video.pause();
	}
}
if(video){
  video.addEventListener("click", togglePlay);
  video.addEventListener("playing", function () {
    circlePlayButton.style.opacity = 0;
  });
  video.addEventListener("pause", function () {
    circlePlayButton.style.opacity = 1;
  });

}

/* Price filtering Activation */
const rangeInput = document.querySelectorAll(".range-input input"),
  priceInput = document.querySelectorAll(".price-input input"),
  range = document.querySelector(".price-slider .progress");
let priceGap = 1000;

priceInput.forEach((input) => {
  input.addEventListener("input", (e) => {
    let minPrice = parseInt(priceInput[0].value),
      maxPrice = parseInt(priceInput[1].value);

    if (maxPrice - minPrice >= priceGap && maxPrice <= rangeInput[1].max) {
      if (e.target.className === "input-min") {
        rangeInput[0].value = minPrice;
        range.style.left = (minPrice / rangeInput[0].max) * 100 + "%";
      } else {
        rangeInput[1].value = maxPrice;
        range.style.right = 100 - (maxPrice / rangeInput[1].max) * 100 + "%";
      }
    }
  });
});

rangeInput.forEach((input) => {
  input.addEventListener("input", (e) => {
    let minVal = parseInt(rangeInput[0].value),
      maxVal = parseInt(rangeInput[1].value);

    if (maxVal - minVal < priceGap) {
      if (e.target.className === "range-min") {
        rangeInput[0].value = maxVal - priceGap;
      } else {
        rangeInput[1].value = minVal + priceGap;
      }
    } else {
      priceInput[0].value = minVal;
      priceInput[1].value = maxVal;
      range.style.left = (minVal / rangeInput[0].max) * 100 + "%";
      range.style.right = 100 - (maxVal / rangeInput[1].max) * 100 + "%";
    }
  });
});


/* OffCanvas Sidebar Activation */
function offcanvsSidebar(openTrigger, closeTrigger, wrapper) {
  let OpenTriggerprimary__btn = document.querySelectorAll(openTrigger);
  let closeTriggerprimary__btn = document.querySelector(closeTrigger);
  let WrapperSidebar = document.querySelector(wrapper);
  let wrapperOverlay = wrapper.replace(".", "");

  function handleBodyClass(evt) {
    let eventTarget = evt.target;
    if (!eventTarget.closest(wrapper) && !eventTarget.closest(openTrigger)) {
      WrapperSidebar.classList.remove("active");
      document
        .querySelector("body")
        .classList.remove(`${wrapperOverlay}_active`);
    }
  }
  if (OpenTriggerprimary__btn && WrapperSidebar) {
    OpenTriggerprimary__btn.forEach(function (singleItem) {
      singleItem.addEventListener("click", function (e) {
        if (e.target.dataset.offcanvas != undefined) {
          WrapperSidebar.classList.add("active");
          document
            .querySelector("body")
            .classList.add(`${wrapperOverlay}_active`);
          document.body.addEventListener("click", handleBodyClass.bind(this));
        }
      });
    });
  }

  if (closeTriggerprimary__btn && WrapperSidebar) {
    closeTriggerprimary__btn.addEventListener("click", function (e) {
      if (e.target.dataset.offcanvas != undefined) {
        WrapperSidebar.classList.remove("active");
        document
          .querySelector("body")
          .classList.remove(`${wrapperOverlay}_active`);
        document.body.removeEventListener("click", handleBodyClass.bind(this));
      }
    });
  }
}

/* Search Bar */
offcanvsSidebar(
  ".search__open--btn",
  ".predictive__search--close__btn",
  ".predictive__search--box"
);

/* Location Tab JS */
const countryList = document.querySelectorAll(".location__list");
const countryThumbList = document.querySelectorAll(".location__thumbnail");

if(countryList.length > 0){
  countryList.forEach((country) => {
    country?.addEventListener("click", (event) => {
      countryList.forEach((childItem) => {
        childItem.classList.remove("active");  
      })
      country.classList.add("active");
      // Thumbnail active class
      countryThumbList.forEach((countryThumb) => {
        countryThumb.classList.add("d-none");
        countryThumb.classList.remove("d-block");
        if(countryThumb.dataset.locationName === country.dataset.locationName){
          countryThumb.classList.remove("d-none");
          countryThumb.classList.add("d-block");
        }
      })
    })
  })
}

