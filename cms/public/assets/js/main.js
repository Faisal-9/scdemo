/* ==========================
   GLOBAL IMAGE LIGHTBOX
========================== */

(function () {
  const lightbox = document.getElementById("imgLightbox");
  const lightboxImg = document.getElementById("lightboxImg");
  const closeBtn = document.querySelector(".img-close");

  if (!lightbox || !lightboxImg) return;

  document.querySelectorAll(".zoomable").forEach((img) => {
    img.addEventListener("click", function () {
      lightbox.style.display = "block";
      lightboxImg.src = this.src;
    });
  });

  closeBtn.onclick = () => (lightbox.style.display = "none");

  lightbox.onclick = (e) => {
    if (e.target === lightbox) lightbox.style.display = "none";
  };
})();

/* ==========================
   MOBILE DROPDOWN FIX
========================== */

document.querySelectorAll(".nav-item .has-dropdown").forEach((link) => {
  link.addEventListener("click", function (e) {
    if (window.innerWidth <= 768) {
      e.preventDefault();
      const parent = this.closest(".nav-item");
      const dropdown = parent.querySelector(".dropdown-menu");
      document.querySelectorAll(".nav-item .dropdown-menu").forEach((menu) => {
        if (menu !== dropdown) menu.classList.remove("active");
      });
      if (dropdown) dropdown.classList.toggle("active");
    }
  });
});

document.querySelectorAll(".nav-item-top .has-dropdown").forEach((link) => {
  link.addEventListener("click", function (e) {
    if (window.innerWidth <= 768) {
      e.preventDefault();
      const parent = this.closest(".nav-item-top");
      const dropdown = parent.querySelector(".dropdown-menu-top");
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
   COUNTER ANIMATION (ON VIEW)
===================================== */

(function () {
  const counters = document.querySelectorAll(".counter");
  const statsSection = document.querySelector(".index-stats-section");

  if (!counters.length || !statsSection) return;

  function animateCounter(counter) {
    const target = +counter.dataset.target;
    const duration = 2000;
    const stepTime = 16;
    const totalSteps = duration / stepTime;
    const increment = target / totalSteps;
    let current = 0;

    counter.innerText = "0";

    const timer = setInterval(() => {
      current += increment;
      if (current >= target) {
        counter.innerText = target.toLocaleString();
        clearInterval(timer);
      } else {
        counter.innerText = Math.floor(current).toLocaleString();
      }
    }, stepTime);
  }

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) counters.forEach(animateCounter);
      });
    },
    { threshold: 0.4 },
  );

  observer.observe(statsSection);
})();

/* =====================================
   Lazy Load Images
===================================== */

if (typeof LazyLoad === "function") {
  new LazyLoad({ elements_selector: ".lazy", threshold: 100 });
}

/* ==========================
   Mobile Navigation
========================== */

const menuToggle = document.querySelector(".mobile-menu-toggle");
const navRows = document.querySelector(".nav-rows");

if (menuToggle && navRows) {
  menuToggle.addEventListener("click", function () {
    this.classList.toggle("active");
    navRows.classList.toggle("active");
    document.body.classList.toggle("menu-open");
  });

  navRows.addEventListener("click", function (e) {
    if (e.target === navRows) {
      menuToggle.classList.remove("active");
      navRows.classList.remove("active");
      document.body.classList.remove("menu-open");
    }
  });

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
    autoplay: { delay: slideDelay, disableOnInteraction: false },
    effect: "slide",
  });

  const indicators = document.querySelectorAll(".hero-indicator-item");
  const indicatorsContainer = document.querySelector(".hero-indicators");
  const totalSlides = indicators.length;

  indicators.forEach((ind) => {
    ind.style.setProperty("--slide-delay", slideDelay + "ms");
  });

  function setActiveIndicator(realIndex) {
    const index = realIndex % totalSlides;
    indicators.forEach((ind) => {
      ind.classList.remove("active");
      const bar = ind.querySelector(".hero-indicator-progress");
      bar.style.animation = "none";
      bar.offsetHeight;
      bar.style.animation = "";
    });
    indicators[index].classList.add("active");
  }

  indicators.forEach((ind, i) => {
    ind.addEventListener("click", () => heroSwiper.slideToLoop(i));
  });

  heroSwiper.on("slideChange", () => setActiveIndicator(heroSwiper.realIndex));

  if (indicatorsContainer) {
    indicatorsContainer.addEventListener("mouseenter", () => {
      heroSwiper.autoplay.stop();
      indicators.forEach((ind) => {
        ind.querySelector(".hero-indicator-progress").style.animationPlayState =
          "paused";
      });
    });

    indicatorsContainer.addEventListener("mouseleave", () => {
      heroSwiper.autoplay.start();
      indicators.forEach((ind) => {
        ind.querySelector(".hero-indicator-progress").style.animationPlayState =
          "running";
      });
    });
  }

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
  let speed = 0.6;
  let isRunning = false;
  let animationFrame;
  let isDragging = false;
  let startX = 0;
  let lastX = 0;

  function getHalfWidth() {
    return track.scrollWidth / 2;
  }
  function setPosition(x) {
    track.style.transform = `translateX(${x}px)`;
  }

  function animate() {
    if (!isRunning || isDragging) return;
    position -= speed;
    if (Math.abs(position) >= getHalfWidth()) position = 0;
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

  function dragStart(e) {
    isDragging = true;
    stop();
    startX = e.type.includes("mouse") ? e.pageX : e.touches[0].pageX;
    lastX = startX;
    track.style.cursor = "grabbing";
  }

  function dragMove(e) {
    if (!isDragging) return;
    const currentX = e.type.includes("mouse") ? e.pageX : e.touches[0].pageX;
    const delta = currentX - lastX;
    lastX = currentX;
    position += delta;
    if (position > 0) position = -getHalfWidth();
    if (Math.abs(position) >= getHalfWidth()) position = 0;
    setPosition(position);
  }

  function dragEnd() {
    isDragging = false;
    track.style.cursor = "grab";
    start();
  }

  track.addEventListener("mousedown", dragStart);
  window.addEventListener("mousemove", dragMove);
  window.addEventListener("mouseup", dragEnd);
  track.addEventListener("touchstart", dragStart, { passive: true });
  track.addEventListener("touchmove", dragMove, { passive: true });
  track.addEventListener("touchend", dragEnd);

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

  track.addEventListener("mouseenter", stop);
  track.addEventListener("mouseleave", start);
  track.style.cursor = "grab";
})();

/* ==========================
   Header Shrink
========================== */

const header = document.querySelector(".header");

if (header) {
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
}

/* ==========================
   About Page Section System
========================== */

const aboutLinks = document.querySelectorAll(
  ".about-sidebar .nav-link[data-section]",
);
const aboutPanels = document.querySelectorAll(".about-panel");

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

if (aboutLinks.length) {
  aboutLinks.forEach((link) => {
    link.addEventListener("click", function (e) {
      e.preventDefault();
      const target = this.dataset.section;
      history.pushState(null, null, "#" + target);
      activateSection(target);
    });
  });
}

window.addEventListener("load", function () {
  const hash = window.location.hash.replace("#", "");
  if (hash && document.getElementById(hash)) {
    activateSection(hash, false);
    setTimeout(() => {
      const el = document.getElementById(hash);
      if (el) window.scrollTo({ top: el.offsetTop - 110, behavior: "smooth" });
    }, 200);
  }
});

window.addEventListener("hashchange", function () {
  const hash = window.location.hash.replace("#", "");
  if (hash && document.getElementById(hash)) activateSection(hash);
});

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
   Growth Timeline + Autoplay
========================== */

(function () {
  const section = document.getElementById("general-info");
  const items = document.querySelectorAll(".timeline-item");
  const detail = document.querySelector(".timeline-detail");
  const mobileMQ = window.matchMedia("(max-width: 768px)");

  if (!items.length) return;

  let index = 0;
  let interval = null;

  function isMobile() {
    return mobileMQ.matches;
  }

  /* SHOW */
  function show(item) {
    items.forEach((el) => el.classList.remove("active"));
    item.classList.add("active");

    if (detail) detail.style.opacity = 0;

    setTimeout(() => {
      const titleEl = document.getElementById("mileTitle");
      const yearEl = document.getElementById("mileYear");
      const descEl = document.getElementById("mileDesc");
      const imgEl = document.getElementById("mileImg");

      if (titleEl) titleEl.innerText = item.dataset.title;
      if (yearEl) yearEl.innerText = item.dataset.year;
      if (descEl) descEl.innerText = item.dataset.desc;
      if (imgEl) {
        imgEl.src = item.dataset.img;
        imgEl.alt = item.dataset.title;
      }

      if (detail) detail.style.opacity = 1;
    }, 200);
  }

  /* AUTOPLAY */
  function playTimeline() {
    clearInterval(interval);

    if (isMobile()) return; // no autoplay on mobile

    interval = setInterval(() => {
      index = (index + 1) % items.length;
      show(items[index]);
    }, 2500);
  }

  function stopTimeline() {
    clearInterval(interval);
    interval = null;
  }

  function syncTimelineMode() {
    stopTimeline();

    if (!isMobile()) {
      playTimeline();
    }
  }

  /* CLICK */
  items.forEach((item, i) => {
    item.addEventListener("click", function () {
      index = i;
      show(this);

      // Desktop keeps autoplay; mobile stays manual only
      if (!isMobile()) {
        playTimeline();
      } else {
        stopTimeline();
      }
    });
  });

  /* HOVER PAUSE (desktop only) */
  if (detail) {
    detail.addEventListener("mouseenter", () => {
      if (!isMobile()) stopTimeline();
    });

    detail.addEventListener("mouseleave", () => {
      if (!isMobile()) playTimeline();
    });
  }

  /* OBSERVER */
  if (section && "IntersectionObserver" in window) {
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            syncTimelineMode();
          } else {
            stopTimeline();
          }
        });
      },
      { threshold: 0 },
    );

    observer.observe(section);
  } else {
    syncTimelineMode();
  }

  /* Stop/start correctly if screen size changes */
  mobileMQ.addEventListener("change", syncTimelineMode);

  show(items[0]);
  syncTimelineMode();
})();

/* ==========================
   Sister Companies Swiper
========================== */

if (typeof Swiper !== "undefined" && document.querySelector(".sisterSwiper")) {
  new Swiper(".sisterSwiper", {
    slidesPerView: 3,
    spaceBetween: 30,
    grid: { rows: 2, fill: "row" },
    navigation: { nextEl: ".sister-next", prevEl: ".sister-prev" },
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

document.querySelectorAll(".sub-tab").forEach((tab) => {
  tab.addEventListener("click", () => {
    document
      .querySelectorAll(".sub-tab")
      .forEach((t) => t.classList.remove("active"));
    document
      .querySelectorAll(".subservice-content")
      .forEach((c) => c.classList.remove("active"));
    tab.classList.add("active");
    document.getElementById(tab.dataset.sub).classList.add("active");
  });
});

document.querySelectorAll(".sub-sub-list li[data-target]").forEach((item) => {
  item.addEventListener("click", () => {
    const container = item.closest(".subservice-content");
    container
      .querySelectorAll("li[data-target]")
      .forEach((li) => li.classList.remove("active"));
    container
      .querySelectorAll(".detail-panel")
      .forEach((p) => p.classList.remove("active"));
    item.classList.add("active");
    const target = document.getElementById(item.dataset.target);
    if (target) target.classList.add("active");
  });
});

document.querySelectorAll(".services-menu li").forEach((item) => {
  item.addEventListener("click", () => {
    document
      .querySelectorAll(".services-menu li")
      .forEach((li) => li.classList.remove("active"));
    document
      .querySelectorAll(".service-section")
      .forEach((sec) => sec.classList.remove("active"));
    item.classList.add("active");
    const section = document.getElementById(item.dataset.target);
    if (section) section.classList.add("active");
  });
});

/* ==========================
   Services Page tab param
========================== */

if (window.location.pathname.endsWith("services.php")) {
  const params = new URLSearchParams(window.location.search);
  const serviceTab = params.get("tab");
  const hashAnchor = window.location.hash.replace("#", "");

  if (serviceTab) {
    document
      .querySelectorAll(".service-section")
      .forEach((sec) => sec.classList.remove("active"));
    const activeSection = document.getElementById(serviceTab);
    if (activeSection) activeSection.classList.add("active");

    if (hashAnchor) {
      setTimeout(() => {
        const targetSubservice = document.getElementById(hashAnchor);
        if (
          targetSubservice &&
          targetSubservice.classList.contains("subservice-content")
        ) {
          activeSection
            .querySelectorAll(".subservice-content")
            .forEach((sc) => sc.classList.remove("active"));
          targetSubservice.classList.add("active");

          const correspondingSubTab = activeSection.querySelector(
            `.sub-tab[data-sub="${targetSubservice.id}"]`,
          );
          if (correspondingSubTab) {
            activeSection
              .querySelectorAll(".sub-tab")
              .forEach((tab) => tab.classList.remove("active"));
            correspondingSubTab.classList.add("active");
          }

          targetSubservice.scrollIntoView({
            behavior: "smooth",
            block: "start",
          });
        } else {
          const anchor = document.querySelector("#" + hashAnchor);
          if (anchor)
            anchor.scrollIntoView({ behavior: "smooth", block: "start" });
        }
      }, 150);
    }
  }
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

  const sectorParams = new URLSearchParams(window.location.search);
  const sectorTab = sectorParams.get("tab");

  if (sectorTab && document.getElementById(sectorTab)) {
    activateSectorTab(sectorTab);
    if (window.location.hash) {
      setTimeout(() => {
        const anchor = document.querySelector(window.location.hash);
        if (anchor)
          anchor.scrollIntoView({ behavior: "smooth", block: "start" });
      }, 100);
    }
  }

  sectorMenuItems.forEach((item) => {
    item.addEventListener("click", function () {
      activateSectorTab(this.dataset.target);
      const page = document.querySelector(".sectors-page");
      if (page)
        window.scrollTo({ top: page.offsetTop - 90, behavior: "smooth" });
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
    container.innerHTML += `<button class="btn btn-sm btn-outline-secondary" data-category="${cat}">${cat.charAt(0).toUpperCase() + cat.slice(1)}</button>`;
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

  document.querySelectorAll(".project-category-section").forEach((section) => {
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
    document.querySelectorAll(".project-filters button").forEach((b) => {
      b.classList.toggle("active", b.dataset.sector === "all");
    });
    updateCategoryButtons("all");
    document
      .querySelectorAll(".project-category-filters button")
      .forEach((b) => {
        b.classList.toggle("active", b.dataset.category === urlCategory);
      });
    filterProjects();
  } else if (urlSector !== "all") {
    sector = urlSector;
    document.querySelectorAll(".project-filters button").forEach((b) => {
      b.classList.toggle("active", b.dataset.sector === urlSector);
    });
    updateCategoryButtons(urlSector);
    setTimeout(() => filterProjects(), 50);
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
      pagination: { el: ".project-pagination", clickable: true },
      navigation: { nextEl: ".project-next", prevEl: ".project-prev" },
    });
  } else if (typeof Swiper === "undefined") {
    setTimeout(initProjectSwiper, 100);
  }
}

initProjectSwiper();

/* ==========================
   Media Tabs
========================== */

(function () {
  const mediaTabs = document.querySelectorAll(".media-menu li");
  const mediaContents = document.querySelectorAll(".media-tab-content");

  mediaTabs.forEach((tab) => {
    tab.addEventListener("click", function () {
      mediaTabs.forEach((t) => t.classList.remove("active"));
      mediaContents.forEach((c) => c.classList.remove("active"));
      this.classList.add("active");
      const targetContent = document.getElementById("tab-" + this.dataset.tab);
      if (targetContent) targetContent.classList.add("active");
    });
  });

  document.querySelectorAll(".media-split").forEach((split) => {
    const items = split.querySelectorAll(".media-list-item");
    const panels = split.querySelectorAll(".media-detail-panel");

    items.forEach((item) => {
      item.addEventListener("click", function () {
        items.forEach((i) => i.classList.remove("active"));
        panels.forEach((p) => p.classList.remove("active"));
        this.classList.add("active");
        const targetPanel = split.querySelector("#" + this.dataset.target);
        if (targetPanel) targetPanel.classList.add("active");
        history.replaceState(
          null,
          "",
          window.location.pathname +
            "?tab=" +
            this.dataset.tab +
            "&id=" +
            this.dataset.id,
        );
      });
    });
  });
})();

/* ==========================
   Services Accordion Menu
========================== */

document.querySelectorAll(".sub-sub-list").forEach((menuList) => {
  menuList
    .querySelectorAll(".group-title")
    .forEach((t) => t.classList.remove("active"));
  menuList
    .querySelectorAll(".group-list")
    .forEach((l) => l.classList.remove("active"));
});

document.querySelectorAll(".sub-sub-list .group-title").forEach((title) => {
  title.addEventListener("click", function () {
    const groupList = this.nextElementSibling;
    const activeContent = this.closest(".subservice-content");

    if (!groupList || !groupList.classList.contains("group-list")) return;

    const parentList = this.closest(".sub-sub-list");
    parentList
      .querySelectorAll(".group-list")
      .forEach((l) => l.classList.remove("active"));
    parentList
      .querySelectorAll(".group-title")
      .forEach((t) => t.classList.remove("active"));
    parentList
      .querySelectorAll("li[data-target]")
      .forEach((i) => i.classList.remove("active"));

    groupList.classList.add("active");
    this.classList.add("active");

    const firstChildItem = groupList.querySelector("li[data-target]");
    if (firstChildItem) {
      firstChildItem.classList.add("active");
      if (activeContent) {
        activeContent
          .querySelectorAll(".detail-panel")
          .forEach((p) => p.classList.remove("active"));
        const targetPanel = document.getElementById(
          firstChildItem.dataset.target,
        );
        if (targetPanel) targetPanel.classList.add("active");
      }
    }
  });
});

/* ==========================
   Policy / Privacy Tabs
========================== */

document.querySelectorAll(".policy-tab").forEach((tab) => {
  tab.addEventListener("click", function () {
    document
      .querySelectorAll(".policy-tab")
      .forEach((t) => t.classList.remove("active"));
    document
      .querySelectorAll(".policy-content")
      .forEach((c) => c.classList.remove("active"));
    this.classList.add("active");
    document.getElementById(this.dataset.tab).classList.add("active");
  });
});
