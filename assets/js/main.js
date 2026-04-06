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
    const slideDelay = 2000;

    const heroSwiper = new Swiper(".heroSwiper", {
      loop: true,
      speed: 1000,
      autoplay: {
        delay: slideDelay,
        disableOnInteraction: false,
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      effect: "slide",
    });

    const indicators = document.querySelectorAll(".hero-indicator-item");
    const totalSlides = indicators.length;

    // Set CSS variable for animation duration
    indicators.forEach((ind) => {
      ind.style.setProperty("--slide-delay", slideDelay + "ms");
    });

    function setActiveIndicator(realIndex) {
      const index = realIndex % totalSlides;
      indicators.forEach((ind, i) => {
        ind.classList.remove("active");
        // Reset progress animation
        const bar = ind.querySelector(".hero-indicator-progress");
        bar.style.animation = "none";
        bar.offsetHeight; // reflow
        bar.style.animation = "";
      });
      indicators[index].classList.add("active");
    }

    // Click indicator to go to slide
    indicators.forEach((ind, i) => {
      ind.addEventListener("click", () => {
        heroSwiper.slideToLoop(i);
      });
    });

    // Sync on slide change
    heroSwiper.on("slideChange", () => {
      setActiveIndicator(heroSwiper.realIndex);
    });

    // Init
    setActiveIndicator(0);
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
     About Us Mission - Vision
  ========================== */

  const panels = document.querySelectorAll(".mv-panel");
  panels.forEach((panel) => {
    panel.addEventListener("click", () => {
      panels.forEach((p) => p.classList.remove("active"));
      panel.classList.add("active");
    });
  });

  /* ==========================
     About Us Milestones
  ========================== */

  window.mileToggle = function (header) {
    const clickedCard = header.closest(".mile-card");
    const accordion = document.getElementById("milestoneAccordion");
    const allCards = accordion.querySelectorAll(".mile-card");
    allCards.forEach((card) => {
      const iconLine = card.querySelector(".h-line");
      if (card !== clickedCard) {
        card.classList.remove("active");
        if (iconLine) iconLine.style.display = "";
      }
    });
    const isActive = clickedCard.classList.toggle("active");
    const clickedIcon = clickedCard.querySelector(".h-line");
    if (clickedIcon) {
      clickedIcon.style.display = isActive ? "none" : "";
    }
  };

  /* ==========================
     Sister Companies Swiper
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
        0: { slidesPerView: 1, grid: { rows: 1 } },
        768: { slidesPerView: 2, grid: { rows: 2 } },
        1200: { slidesPerView: 3, grid: { rows: 2 } },
      },
    });
  }

  /* ==========================
     Services Page Tabs + Sidebar
  ========================== */

  const serviceMenuItems = document.querySelectorAll(".services-menu li");
  const servicePageSections = document.querySelectorAll(".service-section");

  if (serviceMenuItems.length) {
    let activeServiceBlocks = [];
    let activeServiceLinks = [];

    function updateActiveServiceData() {
      const activeService = document.querySelector(".service-section.active");
      if (!activeService) return;
      activeServiceBlocks = Array.from(
        activeService.querySelectorAll(".about-section-block"),
      );
      activeServiceLinks = Array.from(
        activeService.querySelectorAll(".about-sidebar .nav-link"),
      );
    }

    function highlightServiceSidebar() {
      if (!activeServiceBlocks.length) return;
      const scrollPos = window.scrollY + 160;
      activeServiceBlocks.forEach((section, index) => {
        const top = section.offsetTop;
        const bottom = top + section.offsetHeight;
        if (scrollPos >= top && scrollPos < bottom) {
          activeServiceLinks.forEach((link) => link.classList.remove("active"));
          if (activeServiceLinks[index])
            activeServiceLinks[index].classList.add("active");
        }
      });
    }

    function activateServiceTab(target) {
      serviceMenuItems.forEach((el) => el.classList.remove("active"));
      servicePageSections.forEach((sec) => sec.classList.remove("active"));

      const matchedMenu = Array.from(serviceMenuItems).find(
        (el) => el.dataset.target === target,
      );
      if (matchedMenu) matchedMenu.classList.add("active");

      const activeSection = document.getElementById(target);
      if (!activeSection) return;
      activeSection.classList.add("active");

      updateActiveServiceData();
      highlightServiceSidebar();
    }

    // Handle ?tab= param from mega menu links
    const serviceParams = new URLSearchParams(window.location.search);
    const serviceTab = serviceParams.get("tab");
    if (serviceTab && document.getElementById(serviceTab)) {
      activateServiceTab(serviceTab);
      // scroll to anchor if present
      if (window.location.hash) {
        setTimeout(() => {
          const anchor = document.querySelector(window.location.hash);
          if (anchor) {
            anchor.scrollIntoView({ behavior: "smooth", block: "start" });
          }
        }, 100);
      }
    }

    serviceMenuItems.forEach((item) => {
      item.addEventListener("click", function () {
        const target = this.dataset.target;
        activateServiceTab(target);
        const page = document.querySelector(".services-page");
        if (page) {
          window.scrollTo({ top: page.offsetTop - 90, behavior: "smooth" });
        }
      });
    });

    window.addEventListener("scroll", highlightServiceSidebar);
    updateActiveServiceData();
    highlightServiceSidebar();
  }

  /* ==========================
     Sectors Page Tabs + Sidebar
  ========================== */

  const sectorMenuItems = document.querySelectorAll(".sectors-menu li");
  const sectorPageSections = document.querySelectorAll(".sector-section");

  if (sectorMenuItems.length) {
    let activeSectorBlocks = [];
    let activeSectorLinks = [];

    function updateActiveSectorData() {
      const activeSector = document.querySelector(".sector-section.active");
      if (!activeSector) return;
      activeSectorBlocks = Array.from(
        activeSector.querySelectorAll(".about-section-block"),
      );
      activeSectorLinks = Array.from(
        activeSector.querySelectorAll(".about-sidebar .nav-link"),
      );
    }

    function highlightSectorSidebar() {
      if (!activeSectorBlocks.length) return;
      const scrollPos = window.scrollY + 160;
      activeSectorBlocks.forEach((section, index) => {
        const top = section.offsetTop;
        const bottom = top + section.offsetHeight;
        if (scrollPos >= top && scrollPos < bottom) {
          activeSectorLinks.forEach((link) => link.classList.remove("active"));
          if (activeSectorLinks[index])
            activeSectorLinks[index].classList.add("active");
        }
      });
    }

    function activateSectorTab(target) {
      sectorMenuItems.forEach((el) => el.classList.remove("active"));
      sectorPageSections.forEach((sec) => sec.classList.remove("active"));

      const matchedMenu = Array.from(sectorMenuItems).find(
        (el) => el.dataset.target === target,
      );
      if (matchedMenu) matchedMenu.classList.add("active");

      const activeSection = document.getElementById(target);
      if (!activeSection) return;
      activeSection.classList.add("active");

      updateActiveSectorData();
      highlightSectorSidebar();
    }

    // Handle ?tab= param from mega menu links
    const sectorParams = new URLSearchParams(window.location.search);
    const sectorTab = sectorParams.get("tab");
    if (sectorTab && document.getElementById(sectorTab)) {
      activateSectorTab(sectorTab);
      // scroll to anchor if present
      if (window.location.hash) {
        setTimeout(() => {
          const anchor = document.querySelector(window.location.hash);
          if (anchor) {
            anchor.scrollIntoView({ behavior: "smooth", block: "start" });
          }
        }, 100);
      }
    }

    sectorMenuItems.forEach((item) => {
      item.addEventListener("click", function () {
        const target = this.dataset.target;
        activateSectorTab(target);
        const page = document.querySelector(".sectors-page");
        if (page) {
          window.scrollTo({ top: page.offsetTop - 90, behavior: "smooth" });
        }
      });
    });

    window.addEventListener("scroll", highlightSectorSidebar);
    updateActiveSectorData();
    highlightSectorSidebar();
  }

  /* ==========================
     Projects Filter + Sort
  ========================== */

  let sector = "all";
  let status = "all";
  let category = "all";
  let sortOrder = "newest";

  const projectItems = document.querySelectorAll(".project-item");

  document.querySelectorAll(".project-filters button").forEach((btn) => {
    btn.addEventListener("click", function () {
      document
        .querySelectorAll(".project-filters button")
        .forEach((b) => b.classList.remove("active"));
      this.classList.add("active");
      sector = this.dataset.sector;
      category = "all";
      updateCategoryButtons(sector);
      filterProjects();
    });
  });

  function attachCategoryListeners() {
    document
      .querySelectorAll(".project-category-filters button")
      .forEach((btn) => {
        btn.addEventListener("click", function () {
          document
            .querySelectorAll(".project-category-filters button")
            .forEach((b) => b.classList.remove("active"));
          this.classList.add("active");
          category = this.dataset.category.toLowerCase();
          filterProjects();
        });
      });
  }

  attachCategoryListeners();

  const statusFilter = document.getElementById("statusFilter");
  if (statusFilter) {
    statusFilter.addEventListener("change", function () {
      status = this.value.toLowerCase();
      filterProjects();
    });
  }

  const sortSelect = document.getElementById("sortProjects");
  if (sortSelect) {
    sortSelect.addEventListener("change", function () {
      sortOrder = this.value;
      sortProjects(sortOrder);
    });
  }

  function updateCategoryButtons(selectedSector) {
    const container = document.querySelector(".project-category-filters");
    if (!container) return;

    const categories = new Set();
    projectItems.forEach((item) => {
      if (selectedSector === "all" || item.dataset.sector === selectedSector) {
        categories.add(item.dataset.category.toLowerCase());
      }
    });

    container.innerHTML = `<button class="btn btn-sm btn-outline-secondary active" data-category="all">All Categories</button>`;
    categories.forEach((cat) => {
      container.innerHTML += `
        <button class="btn btn-sm btn-outline-secondary" data-category="${cat}">
          ${cat.charAt(0).toUpperCase() + cat.slice(1)}
        </button>`;
    });

    attachCategoryListeners();
  }

  function filterProjects() {
    projectItems.forEach((item) => {
      const itemSector = item.dataset.sector.toLowerCase();
      const itemStatus = item.dataset.status.toLowerCase();
      const itemCategory = item.dataset.category.toLowerCase();

      let show = true;
      if (sector !== "all" && sector !== itemSector) show = false;
      if (status !== "all" && status !== itemStatus) show = false;
      if (category !== "all" && category !== itemCategory) show = false;

      item.style.display = show ? "block" : "none";
    });
  }

  function sortProjects(order) {
    const grid = document.getElementById("projectsGrid");
    if (!grid) return;
    const items = Array.from(grid.querySelectorAll(".project-item"));
    items.sort((a, b) => {
      const yearA = parseInt(a.dataset.year);
      const yearB = parseInt(b.dataset.year);
      return order === "newest" ? yearB - yearA : yearA - yearB;
    });
    items.forEach((item) => grid.appendChild(item));
  }

  if (projectItems.length) {
    sortProjects("newest");
    updateCategoryButtons("all");
  }

  /* ==========================
   URL Parameter Filtering
========================== */
  if (typeof urlSector !== "undefined" && typeof urlCategory !== "undefined") {
    if (urlCategory !== "all") {
      sector = "all";
      category = urlCategory;

      // Activate All sector button
      document.querySelectorAll(".project-filters button").forEach((b) => {
        b.classList.toggle("active", b.dataset.sector === "all");
      });

      // Rebuild category buttons for all sectors
      updateCategoryButtons("all");

      // Activate matching category button
      document
        .querySelectorAll(".project-category-filters button")
        .forEach((b) => {
          b.classList.toggle("active", b.dataset.category === urlCategory);
        });

      filterProjects();
    } else if (urlSector !== "all") {
      sector = urlSector;

      // Activate matching sector button
      document.querySelectorAll(".project-filters button").forEach((b) => {
        b.classList.toggle("active", b.dataset.sector === urlSector);
      });

      updateCategoryButtons(urlSector);
      filterProjects();
    }
  }

  /* ==========================
     Project Details Swiper
  ========================== */

  function initProjectSwiper() {
    if (
      typeof Swiper !== "undefined" &&
      document.querySelector(".project-gallery")
    ) {
      new Swiper(".project-gallery", {
        loop: true,
        slidesPerView: 1,
        spaceBetween: 20,
        autoplay: {
          delay: 2000,
          disableOnInteraction: false,
          pauseOnMouseEnter: true,
        },
        pagination: {
          el: ".project-pagination",
          clickable: true,
        },
        navigation: {
          nextEl: ".project-next",
          prevEl: ".project-prev",
        },
      });
    } else if (typeof Swiper === "undefined") {
      setTimeout(initProjectSwiper, 100);
    }
  }

  initProjectSwiper();
});
