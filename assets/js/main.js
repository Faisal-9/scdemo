/* =====================================
   MAIN WEBSITE SCRIPT
   Optimized for performance
===================================== */

document.addEventListener("DOMContentLoaded", function () {
  /* ==========================
   GLOBAL IMAGE LIGHTBOX
========================== */

  (function () {
    const lightbox = document.getElementById("imgLightbox");
    const lightboxImg = document.getElementById("lightboxImg");
    const closeBtn = document.querySelector(".img-close");

    if (!lightbox || !lightboxImg) return;

    // Attach click to ALL images with class "zoomable"
    document.querySelectorAll(".zoomable").forEach((img) => {
      img.addEventListener("click", function () {
        lightbox.style.display = "block";
        lightboxImg.src = this.src;
      });
    });

    // Close
    closeBtn.onclick = () => (lightbox.style.display = "none");

    // Click outside image closes
    lightbox.onclick = (e) => {
      if (e.target === lightbox) {
        lightbox.style.display = "none";
      }
    };
  })();

  /* ==========================
   MOBILE DROPDOWN FIX
   Handles BOTH bottom-row (.nav-item) and top-row (.nav-item-top) dropdowns
========================== */

  // Bottom-row dropdowns
  const dropdownLinks = document.querySelectorAll(".nav-item .has-dropdown");

  dropdownLinks.forEach((link) => {
    link.addEventListener("click", function (e) {
      if (window.innerWidth <= 768) {
        e.preventDefault();

        const parent = this.closest(".nav-item");
        const dropdown = parent.querySelector(".dropdown-menu");

        // Close others (accordion behavior)
        document
          .querySelectorAll(".nav-item .dropdown-menu")
          .forEach((menu) => {
            if (menu !== dropdown) menu.classList.remove("active");
          });

        if (dropdown) dropdown.classList.toggle("active");
      }
    });
  });

  // Top-row dropdowns
  const topDropdownLinks = document.querySelectorAll(
    ".nav-item-top .has-dropdown",
  );

  topDropdownLinks.forEach((link) => {
    link.addEventListener("click", function (e) {
      if (window.innerWidth <= 768) {
        e.preventDefault();

        const parent = this.closest(".nav-item-top");
        const dropdown = parent.querySelector(".dropdown-menu-top");

        // Close others
        document
          .querySelectorAll(".nav-item-top .dropdown-menu-top")
          .forEach((menu) => {
            if (menu !== dropdown) menu.classList.remove("active");
          });

        if (dropdown) dropdown.classList.toggle("active");
      }
    });
  });

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
     — targets .nav-rows (two-row header layout)
  ========================== */

  const menuToggle = document.querySelector(".mobile-menu-toggle");
  const navRows = document.querySelector(".nav-rows");

  if (menuToggle && navRows) {
    menuToggle.addEventListener("click", function () {
      this.classList.toggle("active");
      navRows.classList.toggle("active");

      // 🔥 Prevent background scroll
      document.body.classList.toggle("menu-open");
    });

    // 🔥 Close when clicking outside (backdrop)
    navRows.addEventListener("click", function (e) {
      if (e.target === navRows) {
        menuToggle.classList.remove("active");
        navRows.classList.remove("active");
        document.body.classList.remove("menu-open");
      }
    });

    // 🔥 Close on link click (non-dropdown)
    navRows.querySelectorAll(".nav-link, .nav-link-top").forEach((link) => {
      link.addEventListener("click", function () {
        if (!this.classList.contains("has-dropdown")) {
          menuToggle.classList.remove("active");
          navRows.classList.remove("active");
          document.body.classList.remove("menu-open");
        }
      });
    });
  }

  /* ==========================
     Hero Slider
========================== */

  if (typeof Swiper !== "undefined" && document.querySelector(".heroSwiper")) {
    const slideDelay = 10000;

    const heroSwiper = new Swiper(".heroSwiper", {
      loop: true,
      speed: 1000,
      autoplay: {
        delay: slideDelay,
        disableOnInteraction: false,
      },
      effect: "slide",
    });

    const indicators = document.querySelectorAll(".hero-indicator-item");
    const indicatorsContainer = document.querySelector(".hero-indicators");
    const totalSlides = indicators.length;

    /* Set CSS variable for animation duration */
    indicators.forEach((ind) => {
      ind.style.setProperty("--slide-delay", slideDelay + "ms");
    });

    function setActiveIndicator(realIndex) {
      const index = realIndex % totalSlides;

      indicators.forEach((ind, i) => {
        ind.classList.remove("active");

        const bar = ind.querySelector(".hero-indicator-progress");

        // Reset animation
        bar.style.animation = "none";
        bar.offsetHeight; // force reflow
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

    // Sync indicators with slides
    heroSwiper.on("slideChange", () => {
      setActiveIndicator(heroSwiper.realIndex);
    });

    // Pause autoplay + progress animation on hover
    if (indicatorsContainer) {
      indicatorsContainer.addEventListener("mouseenter", () => {
        heroSwiper.autoplay.stop();

        // Pause progress bars
        indicators.forEach((ind) => {
          const bar = ind.querySelector(".hero-indicator-progress");
          bar.style.animationPlayState = "paused";
        });
      });

      indicatorsContainer.addEventListener("mouseleave", () => {
        heroSwiper.autoplay.start();

        // Resume progress bars
        indicators.forEach((ind) => {
          const bar = ind.querySelector(".hero-indicator-progress");
          bar.style.animationPlayState = "running";
        });
      });
    }

    // Init
    setActiveIndicator(0);
  }

  /* ==========================
   INDEX CLIENTS INFINITE SLIDER 
========================== */

  (function () {
    const track = document.getElementById("clientsTrack");
    const section = document.querySelector(".clients-section");

    if (!track || !section) return;

    let position = 0;
    let speed = 0.9;
    let isRunning = false;
    let animationFrame;

    /* 
     DRAG VARIABLES
   */
    let isDragging = false;
    let startX = 0;
    let lastX = 0;

    /* 
     HELPERS
   */
    function getHalfWidth() {
      return track.scrollWidth / 2;
    }

    function setPosition(x) {
      track.style.transform = `translateX(${x}px)`;
    }

    /* 
     AUTO SCROLL
   */
    function animate() {
      if (!isRunning || isDragging) return;

      position -= speed;

      if (Math.abs(position) >= getHalfWidth()) {
        position = 0;
      }

      setPosition(position);
      animationFrame = requestAnimationFrame(animate);
    }

    function start() {
      if (!isRunning) {
        isRunning = true;
        animate();
      }
    }

    function stop() {
      isRunning = false;
      cancelAnimationFrame(animationFrame);
    }

    /* 
     DRAG START
   */
    function dragStart(e) {
      isDragging = true;
      stop();

      startX = e.type.includes("mouse") ? e.pageX : e.touches[0].pageX;
      lastX = startX;

      track.style.cursor = "grabbing";
    }

    /* 
     DRAG MOVE
   */
    function dragMove(e) {
      if (!isDragging) return;

      const currentX = e.type.includes("mouse") ? e.pageX : e.touches[0].pageX;

      const delta = currentX - lastX;
      lastX = currentX;

      position += delta;

      // seamless loop while dragging
      if (position > 0) position = -getHalfWidth();
      if (Math.abs(position) >= getHalfWidth()) position = 0;

      setPosition(position);
    }

    /* 
     DRAG END
   */
    function dragEnd() {
      isDragging = false;
      track.style.cursor = "grab";
      start();
    }

    /* 
     EVENTS (MOUSE + TOUCH)
   */
    track.addEventListener("mousedown", dragStart);
    window.addEventListener("mousemove", dragMove);
    window.addEventListener("mouseup", dragEnd);

    track.addEventListener("touchstart", dragStart, { passive: true });
    track.addEventListener("touchmove", dragMove, { passive: true });
    track.addEventListener("touchend", dragEnd);

    /* 
     INTERSECTION OBSERVER
   */
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) start();
          else stop();
        });
      },
      { threshold: 0.2 },
    );

    observer.observe(section);

    /* 
     HOVER PAUSE
   */
    track.addEventListener("mouseenter", stop);
    track.addEventListener("mouseleave", start);

    /* 
     INIT
   */
    track.style.cursor = "grab";
  })();

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

  /* ==========================
   About Page Section System (FINAL)
========================== */

  const aboutLinks = document.querySelectorAll(
    ".about-sidebar .nav-link[data-section]",
  );
  const aboutPanels = document.querySelectorAll(".about-panel");

  /* ===== CORE FUNCTION ===== */
  function activateSection(targetId, scroll = true) {
    aboutLinks.forEach((l) => {
      l.classList.toggle("active", l.dataset.section === targetId);
    });

    aboutPanels.forEach((panel) => {
      panel.classList.toggle("active", panel.id === targetId);
    });

    if (scroll) {
      const el = document.getElementById(targetId);
      if (el) {
        window.scrollTo({
          top: el.offsetTop - (window.innerWidth < 768 ? 80 : 110),
          behavior: "smooth",
        });
      }
    }
  }

  /* ===== SIDEBAR CLICK ===== */
  if (aboutLinks.length) {
    aboutLinks.forEach((link) => {
      link.addEventListener("click", function (e) {
        e.preventDefault();

        const target = this.dataset.section;

        // update URL without reload
        history.pushState(null, null, "#" + target);

        activateSection(target);
      });
    });
  }

  /* ===== PAGE LOAD (direct URL or from other page) ===== */
  window.addEventListener("load", function () {
    const hash = window.location.hash.replace("#", "");

    if (hash && document.getElementById(hash)) {
      activateSection(hash, false);

      setTimeout(() => {
        const el = document.getElementById(hash);
        if (el) {
          window.scrollTo({
            top: el.offsetTop - 110,
            behavior: "smooth",
          });
        }
      }, 200);
    }
  });

  /* ===== HASH CHANGE (clicking header while already on about page) ===== */
  window.addEventListener("hashchange", function () {
    const hash = window.location.hash.replace("#", "");
    if (hash && document.getElementById(hash)) {
      activateSection(hash);
    }
  });

  /* ===== HEADER MENU FIX ===== */
  document.querySelectorAll('a[href*="about.php#"]').forEach((link) => {
    link.addEventListener("click", function (e) {
      if (!window.location.pathname.includes("about.php")) return;

      e.preventDefault();
      const hash = this.getAttribute("href").split("#")[1];

      if (hash && document.getElementById(hash)) {
        history.pushState(null, null, "#" + hash);
        activateSection(hash);
      }
    });
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
   Mobile Milestone Picker
========================== */
  (function () {
    const pills = document.querySelectorAll(".mob-mile-pill");
    if (!pills.length) return;

    function mobShow(i) {
      const pill = pills[i];
      pills.forEach((p) => p.classList.remove("active"));
      pills[i].classList.add("active");

      document.getElementById("mobMileImg").src = pill.dataset.img;
      document.getElementById("mobMileName").innerText = pill.dataset.title;
      document.getElementById("mobMileYear").innerText = pill.dataset.year;
      document.getElementById("mobMileDesc").innerText = pill.dataset.desc;
    }

    pills.forEach((pill, i) =>
      pill.addEventListener("click", () => mobShow(i)),
    );
  })();

  /* ==========================
   Growth Timeline
========================== */

  // make function GLOBAL
  window.showMilestone = function (el) {
    const items = document.querySelectorAll(".timeline-item");
    const detail = document.querySelector(".timeline-detail");

    // remove active
    items.forEach((item) => item.classList.remove("active"));

    // set active
    el.classList.add("active");

    // fade out
    if (detail) detail.style.opacity = 0;

    setTimeout(() => {
      // update content
      const titleEl = document.getElementById("mileTitle");
      const yearEl = document.getElementById("mileYear");
      const descEl = document.getElementById("mileDesc");
      const imgEl = document.getElementById("mileImg");

      if (titleEl) titleEl.innerText = el.dataset.title;
      if (yearEl) yearEl.innerText = el.dataset.year;
      if (descEl) descEl.innerText = el.dataset.desc;
      if (imgEl) imgEl.src = el.dataset.img;

      // fade in
      if (detail) detail.style.opacity = 1;
    }, 200);
  };

  /* ==========================
   MILESTONES AUTOPLAY (CLEAN)
========================== */

  (function () {
    const section = document.getElementById("milestones");
    const items = document.querySelectorAll(".timeline-item");

    if (!section || !items.length) return;

    let index = 0;
    let interval = null;

    /* ===== CORE FUNCTION ===== */
    function show(item) {
      items.forEach((el) => el.classList.remove("active"));
      item.classList.add("active");

      document.getElementById("mileTitle").innerText = item.dataset.title;
      document.getElementById("mileYear").innerText = item.dataset.year;
      document.getElementById("mileDesc").innerText = item.dataset.desc;
      document.getElementById("mileImg").src = item.dataset.img;
    }

    /* ===== AUTOPLAY ===== */
    function playTimeline() {
      clearInterval(interval);

      interval = setInterval(() => {
        index = (index + 1) % items.length;
        show(items[index]);
      }, 2500); // ⏱ slightly smoother timing
    }

    function stopTimeline() {
      clearInterval(interval);
    }

    /* ===== OBSERVER ===== */
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            playTimeline();
          } else {
            stopTimeline();
          }
        });
      },
      { threshold: 0.3 },
    );

    observer.observe(section);

    /* ===== CLICK ===== */
    items.forEach((item, i) => {
      item.addEventListener("click", function () {
        index = i;
        show(this);
        playTimeline(); // restart from clicked
      });
    });

    /* ===== HOVER PAUSE ===== */
    const detail = document.querySelector(".timeline-detail");

    if (detail) {
      detail.addEventListener("mouseenter", stopTimeline);
      detail.addEventListener("mouseleave", playTimeline);
    }

    /* ===== INIT ===== */
    show(items[0]);
  })();

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

      let show = true;

      if (sector !== "all" && sector !== itemSector) show = false;
      if (status !== "all" && status !== itemStatus) show = false;

      item.style.display = show ? "flex" : "none";
    });

    // Hide empty sections
    document
      .querySelectorAll(".project-category-section")
      .forEach((section) => {
        const visibleItems = section.querySelectorAll(
          ".project-item[style*='flex']",
        );
        section.style.display = visibleItems.length ? "block" : "none";
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

  /* ==========================
     TABS 
  ========================== */
  const tabs = document.querySelectorAll(".media-menu li");
  const contents = document.querySelectorAll(".media-tab-content");

  tabs.forEach((tab) => {
    tab.addEventListener("click", function () {
      tabs.forEach((t) => t.classList.remove("active"));
      contents.forEach((c) => c.classList.remove("active"));

      this.classList.add("active");

      const target = document.getElementById("tab-" + this.dataset.tab);
      if (target) target.classList.add("active");
    });
  });

  /* 
     SHOW MORE
   */
  const buttons = document.querySelectorAll(".media-show-more-btn");

  buttons.forEach((btn) => {
    btn.addEventListener("click", function () {
      const tabKey = this.dataset.tab;
      const list = document.getElementById("list-" + tabKey);

      if (!list) return;

      const cards = list.querySelectorAll(".media-card");
      let visible = parseInt(list.getAttribute("data-visible")) || 5;

      const nextLimit = visible + 5;

      cards.forEach((card, index) => {
        if (index < nextLimit) {
          card.classList.remove("media-card--hidden");
        }
      });

      list.setAttribute("data-visible", nextLimit);

      // hide button if all shown
      if (nextLimit >= cards.length) {
        this.style.display = "none";
      }
    });
  });

  /* =============================
     SIDEBAR CLICK TO FEATURED
  ============================= */
  const sidebarItems = document.querySelectorAll(".media-sidebar-item");

  sidebarItems.forEach((item) => {
    item.addEventListener("click", function () {
      const parentTab = this.closest(".media-tab-content");
      const featured = parentTab.querySelector(".media-featured");

      // Update featured content
      const img = featured.querySelector(".media-featured-img");
      const title = featured.querySelector(".media-featured-title");
      const desc = featured.querySelector(".media-featured-desc");
      const date = featured.querySelector(".media-featured-date");
      const tagsContainer = featured.querySelector(".media-tags");

      // Update values
      img.src = this.querySelector("img")?.src || this.dataset.image;
      img.alt = this.querySelector(".media-sidebar-title").innerText;
      title.innerText = this.querySelector(".media-sidebar-title").innerText;
      date.innerText = this.querySelector(".media-sidebar-date").innerText;
      desc.innerText = this.dataset.description || this.dataset.desc || "";

      // Update tags
      if (tagsContainer) {
        tagsContainer.innerHTML = "";
        const tags = JSON.parse(this.dataset.tags || "[]");
        tags.forEach((tag) => {
          const span = document.createElement("span");
          span.className = "media-tag";
          span.innerText = tag;
          tagsContainer.appendChild(span);
        });
      }
    });
  });

  /* 
   SIDEBAR PAGINATION
 */
  (function () {
    let currentPage = 0;
    const sidebarList = document.getElementById("mediaSidebarList");
    if (!sidebarList) return;

    const itemsPerPage = parseInt(sidebarList.dataset.itemsPerPage) || 5;
    const sidebarItems = sidebarList.querySelectorAll(".media-sidebar-item");
    const totalPages = Math.ceil(sidebarItems.length / itemsPerPage);

    window.mediaPage = function (dir) {
      currentPage += dir;
      if (currentPage < 0) currentPage = 0;
      if (currentPage >= totalPages) currentPage = totalPages - 1;

      sidebarItems.forEach((el, i) => {
        const page = Math.floor(i / itemsPerPage);
        el.classList.toggle("d-none", page !== currentPage);
      });

      document.getElementById("mediaPrev").disabled = currentPage === 0;
      document.getElementById("mediaNext").disabled =
        currentPage >= totalPages - 1;
    };
  })();

  
});
