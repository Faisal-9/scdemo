/* =====================================
   MAIN WEBSITE SCRIPT
   Optimized for performance
===================================== */

document.addEventListener("DOMContentLoaded", function () {
  /* =====================================
       COUNTER ANIMATION
    ===================================== */

  const counters = document.querySelectorAll(".counter");

  counters.forEach((counter) => {
    const target = +counter.dataset.target;
    let count = 0;
    const update = () => {
      const increment = target / 100;
      count += increment;
      if (count < target) {
        counter.innerText = Math.floor(count);
        requestAnimationFrame(update);
      } else {
        counter.innerText = target;
      }
    };
    update();
  });

  /* =====================================
       Lazy Load Images
    ===================================== */
  if (typeof LazyLoad === "function") {
    new LazyLoad({
      elements_selector: ".lazy",
      threshold: 100,
    });
  }

  /* =====================================
   Global Image Error Handler
===================================== */
  document.addEventListener(
    "error",
    function (e) {
      if (e.target.tagName === "IMG") {
        e.target.src =
          "https://images.pexels.com/photos/33045/lion-wild-africa-african.jpg";
        e.target.classList.add("img-error");
      }
    },
    true,
  );

  /* ==========================
   Mobile Navigation
========================== */

  const menuToggle = document.querySelector(".mobile-menu-toggle");
  const navMenu = document.querySelector(".nav-menu");

  if (menuToggle) {
    menuToggle.addEventListener("click", function () {
      this.classList.toggle("active");
      navMenu.classList.toggle("active");
    });
  }

  /* ==========================
Hero Slider
========================== */

  if (typeof Swiper !== "undefined" && document.querySelector(".heroSwiper")) {
    new Swiper(".heroSwiper", {
      loop: true,
      speed: 1000,

      autoplay: {
        delay: 3500,
        disableOnInteraction: false,
      },

      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },

      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },

      effect: "slide",
    });
  }

  /* ==========================
Header Shrink
========================== */

  const header = document.querySelector(".header");

  let isSmall = false;

  window.addEventListener("scroll", () => {
    const scrollY = window.scrollY;

    if (!isSmall && scrollY > 100) {
      header.classList.add("header-small");
      isSmall = true;
    }

    if (isSmall && scrollY < 60) {
      header.classList.remove("header-small");
      isSmall = false;
    }
  });

  const scrollSpy = new bootstrap.ScrollSpy(document.body, {
    target: "#aboutSidebar",
  });

  /* ==========================
about us mission - vision
========================== */
  const panels = document.querySelectorAll(".mv-panel");
  panels.forEach((panel) => {
    panel.addEventListener("click", () => {
      panels.forEach((p) => p.classList.remove("active"));
      panel.classList.add("active");
    });
  });

  /* ==========================
   ABOUT US MILESTONES
========================== */

  window.mileToggle = function (header) {
    const clickedCard = header.closest(".mile-card");
    const accordion = document.getElementById("milestoneAccordion");
    const allCards = accordion.querySelectorAll(".mile-card");
    allCards.forEach((card) => {
      const iconLine = card.querySelector(".h-line");
      if (card !== clickedCard) {
        card.classList.remove("active");
        if (iconLine) {
          iconLine.style.display = "";
        }
      }
    });
    const isActive = clickedCard.classList.toggle("active");
    const clickedIcon = clickedCard.querySelector(".h-line");
    if (clickedIcon) {
      clickedIcon.style.display = isActive ? "none" : "";
    }
  };

  /* ==========================
about us Sister Companies Swiper
========================== */
  if (
    typeof Swiper !== "undefined" &&
    document.querySelector(".sisterSwiper")
  ) {
    new Swiper(".sisterSwiper", {
      slidesPerView: 3,
      spaceBetween: 30,

      grid: {
        rows: 2,
        fill: "row",
      },

      navigation: {
        nextEl: ".sister-next",
        prevEl: ".sister-prev",
      },

      breakpoints: {
        0: {
          slidesPerView: 1,
          grid: { rows: 1 },
        },

        768: {
          slidesPerView: 2,
          grid: { rows: 2 },
        },

        1200: {
          slidesPerView: 3,
          grid: { rows: 2 },
        },
      },
    });
  }

  /* ==========================
   SERVICES PAGE TABS
========================== */

  document.querySelectorAll(".services-menu li").forEach((item) => {
    item.addEventListener("click", function () {

      document.querySelectorAll(".services-menu li")
        .forEach((el) => el.classList.remove("active"));

      this.classList.add("active");

      const target = this.dataset.target;

      document.querySelectorAll(".service-section")
        .forEach((sec) => sec.classList.remove("active"));

      document.getElementById(target).classList.add("active");

    });
  });
});
