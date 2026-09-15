(function () {
  "use strict";

  function openImagePreview(image) {
    const existing = document.querySelector("[data-admin-image-preview]");
    if (existing) existing.remove();

    const overlay = document.createElement("div");
    overlay.dataset.adminImagePreview = "1";
    overlay.className = "admin-image-preview-overlay";
    overlay.innerHTML =
      '<div class="admin-image-preview-dialog" role="dialog" aria-modal="true" aria-label="Image preview">' +
      '<button type="button" class="admin-image-preview-close" aria-label="Close image preview">&times;</button>' +
      '<img src="' +
      escapeHtml(image.currentSrc || image.src) +
      '" alt="' +
      escapeHtml(image.alt || "") +
      '">' +
      "</div>";
    document.body.appendChild(overlay);

    const close = () => overlay.remove();
    overlay
      .querySelector(".admin-image-preview-close")
      .addEventListener("click", close);
    overlay.addEventListener("click", (event) => {
      if (event.target === overlay) close();
    });
    document.addEventListener("keydown", function handleEscape(event) {
      if (event.key === "Escape") {
        close();
        document.removeEventListener("keydown", handleEscape);
      }
    });
    overlay.querySelector(".admin-image-preview-close").focus();
  }

  document.addEventListener(
    "click",
    (event) => {
      const image = event.target.closest("img");
      if (
        !image ||
        image.closest("[data-admin-image-preview]") ||
        !document.body.classList.contains("admin-body")
      )
        return;
      event.preventDefault();
      event.stopPropagation();
      openImagePreview(image);
    },
    true,
  );

  function escapeHtml(s) {
    return String(s).replace(
      /[&<>'"]/g,
      (c) =>
        ({
          "&": "&amp;",
          "<": "&lt;",
          ">": "&gt;",
          "'": "&#39;",
          '"': "&quot;",
        })[c],
    );
  }
  function openPicker(field) {
    const type = field.dataset.mediaPickerType || "image";
    const input = field.querySelector("[data-media-picker-input]");
    const overlay = document.createElement("div");
    overlay.className = "media-picker-overlay";
    overlay.innerHTML =
      '<div class="media-picker-modal"><div class="media-picker-modal-head"><strong>Select ' +
      (type === "image" ? "Image" : "File") +
      '</strong><button type="button" data-close>×</button></div><div class="media-picker-search"><input type="search" placeholder="Start typing a name..." data-search autofocus></div><div class="media-picker-results" data-results></div></div>';
    document.body.appendChild(overlay);
    const results = overlay.querySelector("[data-results]"),
      search = overlay.querySelector("[data-search]");
    async function load(q) {
      results.innerHTML = '<div class="media-picker-loading">Searching…</div>';
      try {
        const pickerUrl = String(
          window.SC_MEDIA_PICKER_URL || "scadmin/assets-library/picker.php",
        );
        const separator = pickerUrl.includes("?") ? "&" : "?";
        const r = await fetch(
          pickerUrl +
            separator +
            "format=json&type=" +
            encodeURIComponent(type) +
            "&q=" +
            encodeURIComponent(q),
          {
            credentials: "same-origin",
            headers: { "X-Requested-With": "XMLHttpRequest" },
          },
        );
        const data = await r.json();
        results.innerHTML = "";
        if (!data.items?.length) {
          results.innerHTML =
            '<div class="media-picker-empty">No matching assets.</div>';
          return;
        }
        data.items.forEach((item) => {
          const b = document.createElement("button");
          b.type = "button";
          b.className = "media-picker-result";
          b.dataset.path = item.relative_path;
          const baseUrl = String(window.SC_BASE_URL || "").replace(/\/$/, "");
          b.innerHTML =
            (String(item.mime_type).startsWith("image/")
              ? '<img src="' +
                escapeHtml(baseUrl + "/" + item.relative_path) +
                '" alt="">'
              : '<span class="media-picker-result-file">FILE</span>') +
            "<strong>" +
            escapeHtml(item.original_name) +
            "</strong><small>" +
            escapeHtml(item.relative_path) +
            "</small>";
          b.addEventListener("click", () => {
            input.value = item.relative_path;
            input.dispatchEvent(new Event("change", { bubbles: true }));
            const cur = field.querySelector("[data-media-picker-current-name]");
            if (cur) cur.textContent = item.original_name;
            overlay.remove();
          });
          results.appendChild(b);
        });
      } catch (e) {
        results.innerHTML =
          '<div class="media-picker-empty">Unable to load the media library.</div>';
      }
    }
    let timer;
    search.addEventListener("input", () => {
      clearTimeout(timer);
      timer = setTimeout(() => load(search.value), 180);
    });
    overlay.addEventListener("click", (e) => {
      if (e.target === overlay || e.target.closest("[data-close]"))
        overlay.remove();
    });
    load(input.value ? input.value.split("/").pop() : "");
  }
  document.addEventListener("click", function (e) {
    const btn = e.target.closest("[data-media-picker-open]");
    if (btn) openPicker(btn.closest("[data-media-picker]"));
  });
})();
