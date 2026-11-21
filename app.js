const burger = document.querySelector(".burger");
const nav = document.querySelector(".nav");
const siteHeader = document.querySelector(".site-header");
if (burger && nav) {
  const setMenuState = (open) => {
    nav.classList.toggle("open", open);
    burger.classList.toggle("open", open);
    siteHeader?.classList.toggle("menu-open", open);
    burger.setAttribute("aria-expanded", String(open));
    burger.setAttribute("aria-label", open ? "Close menu" : "Menu");
  };

  burger.setAttribute("aria-expanded", "false");

  burger.addEventListener("click", (event) => {
    event.stopPropagation();
    setMenuState(!nav.classList.contains("open"));
  });

  nav.addEventListener("click", (event) => event.stopPropagation());

  document.addEventListener("click", () => {
    if (nav.classList.contains("open")) setMenuState(false);
  });

  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape" && nav.classList.contains("open")) {
      setMenuState(false);
      burger.focus();
    }
  });
}
const overlay = document.querySelector(".overlay");
document.querySelectorAll("[data-open-text]").forEach((b) =>
  b.addEventListener("click", (e) => {
    e.preventDefault();
    overlay?.classList.add("open");
  }),
);
document
  .querySelectorAll("[data-close-text]")
  .forEach((b) =>
    b.addEventListener("click", () => overlay?.classList.remove("open")),
  );
document.addEventListener("keydown", (e) => {
  if (e.key === "Escape") overlay?.classList.remove("open");
});

const projectGallery = document.querySelector("[data-project-gallery]");
if (projectGallery) {
  const params = new URLSearchParams(window.location.search);
  const requestedProject = params.get("project") || "kifisia";
  const projects = window.PROJECTS || {};
  const project = projects[requestedProject] || projects.kifisia;

  if (project) {
    const images =
      Array.isArray(project.images) && project.images.length
        ? project.images
        : ["assets/project-1.jpg"];
    const image = projectGallery.querySelector("[data-project-image]");
    const counter = projectGallery.querySelector("[data-project-counter]");
    const prevButton = projectGallery.querySelector("[data-project-prev]");
    const nextButton = projectGallery.querySelector("[data-project-next]");
    const title = document.querySelector("[data-project-title]");
    const subtitle = document.querySelector("[data-project-subtitle]");
    const text = document.querySelector("[data-project-text]");

    document.title = project.location
      ? `${project.title} | ${project.location}`
      : project.title;
    if (title) title.textContent = project.title;
    if (subtitle) subtitle.textContent = project.subtitle || "";
    if (text) {
      text.replaceChildren(
        ...(project.text || []).map((copy) => {
          const paragraph = document.createElement("p");
          paragraph.textContent = copy;
          return paragraph;
        }),
      );
    }

    let current = 0;
    const renderImage = () => {
      image.src = images[current];
      image.alt = `${project.title} — image ${current + 1}`;
      counter.textContent = `${current + 1} – ${images.length}`;
    };
    const showImage = (next) => {
      current = (next + images.length) % images.length;
      image.classList.add("is-changing");
      window.setTimeout(() => {
        renderImage();
        image.classList.remove("is-changing");
      }, 140);
    };

    renderImage();
    const hasMultipleImages = images.length > 1;
    prevButton.hidden = !hasMultipleImages;
    nextButton.hidden = !hasMultipleImages;

    prevButton.addEventListener("click", () => showImage(current - 1));
    nextButton.addEventListener("click", () => showImage(current + 1));
    projectGallery.tabIndex = 0;
    projectGallery.addEventListener("keydown", (e) => {
      if (!hasMultipleImages) return;
      if (e.key === "ArrowLeft") {
        e.preventDefault();
        showImage(current - 1);
      }
      if (e.key === "ArrowRight") {
        e.preventDefault();
        showImage(current + 1);
      }
    });
  }
}

// On touch/mobile, the first tap previews the same title shown on desktop hover.
// Tapping the revealed title/card a second time follows the project link.
const homeCards = [...document.querySelectorAll(".gallery .card")];
if (homeCards.length) {
  const isTouchLike = () =>
    window.matchMedia("(hover: none), (pointer: coarse)").matches;
  homeCards.forEach((card) => {
    card.addEventListener("click", (e) => {
      if (!isTouchLike()) return;
      if (!card.classList.contains("is-previewing")) {
        e.preventDefault();
        homeCards.forEach((other) => {
          if (other !== card) other.classList.remove("is-previewing");
        });
        card.classList.add("is-previewing");
      }
    });
  });
  document.addEventListener("click", (e) => {
    if (!isTouchLike() || e.target.closest(".gallery .card")) return;
    homeCards.forEach((card) => card.classList.remove("is-previewing"));
  });
}

// Opening splash: type the studio name, hold briefly, then fade into the home page.
const splash = document.querySelector("[data-splash]");
if (splash) {
  const splashText = splash.querySelector("[data-splash-text]");
  const phrase = "The Visual Architect";
  const reduced = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
  let hasSeenSplash = false;
  try {
    hasSeenSplash = sessionStorage.getItem("visualArchitectSplashSeen") === "1";
  } catch (e) {}
  const finishSplash = () => {
    splash.classList.add("is-complete", "is-leaving");
    document.body.classList.remove("splash-active");
    try {
      sessionStorage.setItem("visualArchitectSplashSeen", "1");
    } catch (e) {}
    window.setTimeout(() => splash.remove(), reduced ? 300 : 850);
  };
  if (hasSeenSplash) {
    splash.remove();
    document.body.classList.remove("splash-active");
  } else if (reduced) {
    splashText.textContent = phrase;
    window.setTimeout(finishSplash, 650);
  } else {
    let i = 0;
    const typeNext = () => {
      splashText.textContent = phrase.slice(0, i);
      if (i < phrase.length) {
        i += 1;
        window.setTimeout(typeNext, 82);
      } else {
        splash.classList.add("is-complete");
        window.setTimeout(finishSplash, 600);
      }
    };
    window.setTimeout(typeNext, 1000);
  }
}

// Minimal custom validation for the project inquiry form.
const inquiryForm = document.querySelector(".inquiry-form");
if (inquiryForm) {
  const requiredFields = [...inquiryForm.querySelectorAll("[required]")];

  const clearError = (field) => {
    const row = field.closest(".form-field");
    if (!row) return;
    row.classList.remove("has-error");
    row.querySelector(".form-validation")?.remove();
    field.removeAttribute("aria-invalid");
  };

  const showError = (field, message) => {
    requiredFields.forEach((item) => {
      if (item !== field) clearError(item);
    });
    const row = field.closest(".form-field");
    if (!row) return;
    let note = row.querySelector(".form-validation");
    if (!note) {
      note = document.createElement("div");
      note.className = "form-validation";
      note.setAttribute("role", "alert");
      row.appendChild(note);
    }
    note.textContent = `! ${message}`;
    row.classList.add("has-error");
    field.setAttribute("aria-invalid", "true");
  };

  requiredFields.forEach((field) => {
    field.addEventListener("input", () => {
      if (field.validity.valid) clearError(field);
    });
    field.addEventListener("blur", () => {
      if (!field.value.trim()) showError(field, "Please fill out this field.");
      else if (!field.validity.valid)
        showError(field, "Please enter a valid email.");
    });
  });

  inquiryForm.addEventListener("submit", (event) => {
    const firstInvalid = requiredFields.find(
      (field) => !field.validity.valid || !field.value.trim(),
    );
    if (!firstInvalid) return;
    event.preventDefault();
    const message = !firstInvalid.value.trim()
      ? "Please fill out this field."
      : "Please enter a valid email.";
    showError(firstInvalid, message);
    firstInvalid.focus({ preventScroll: true });
    firstInvalid.scrollIntoView({ behavior: "smooth", block: "center" });
  });
}


// Client gallery index: open project information before entering a gallery.
const clientProjectOverlay = document.querySelector("[data-client-overlay]");
if (clientProjectOverlay) {
  const clientTitle = clientProjectOverlay.querySelector("[data-client-title]");
  const clientSubtitle = clientProjectOverlay.querySelector("[data-client-subtitle]");
  const clientText = clientProjectOverlay.querySelector("[data-client-text]");
  const clientView = clientProjectOverlay.querySelector("[data-client-view]");
  const closeClientOverlay = () => {
    clientProjectOverlay.classList.remove("open");
    clientProjectOverlay.setAttribute("aria-hidden", "true");
  };

  document.querySelectorAll("[data-client-project]").forEach((card) => {
    card.addEventListener("click", (event) => {
      event.preventDefault();
      if (clientTitle) clientTitle.textContent = card.dataset.clientTitle || "Client project";
      if (clientSubtitle) clientSubtitle.textContent = card.dataset.clientSubtitle || "";
      if (clientText) {
        clientText.replaceChildren();
        const p = document.createElement("p");
        p.textContent = card.dataset.clientText || "";
        clientText.appendChild(p);
      }
      const url = card.dataset.clientUrl || "";
      if (clientView) {
        if (url) {
          clientView.href = url;
          clientView.hidden = false;
        } else {
          clientView.removeAttribute("href");
          clientView.hidden = true;
        }
      }
      clientProjectOverlay.classList.add("open");
      clientProjectOverlay.setAttribute("aria-hidden", "false");
    });
  });

  clientProjectOverlay.querySelector("[data-client-close]")?.addEventListener("click", closeClientOverlay);
  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape" && clientProjectOverlay.classList.contains("open")) {
      closeClientOverlay();
    }
  });
}

// Private client gallery passcode gate. This works on static hosting and keeps
// access for the current browser tab/session after a successful unlock.
const clientPasscodeOverlay = document.querySelector("[data-client-passcode-overlay]");
if (clientProjectOverlay && clientPasscodeOverlay) {
  const passcodeForm = clientPasscodeOverlay.querySelector("[data-client-passcode-form]");
  const passcodeInput = clientPasscodeOverlay.querySelector("[data-client-passcode-input]");
  const passcodeError = clientPasscodeOverlay.querySelector("[data-client-passcode-error]");
  const passcodeClose = clientPasscodeOverlay.querySelector("[data-client-passcode-close]");
  const clientView = clientProjectOverlay.querySelector("[data-client-view]");
  let pendingGallery = null;

  const closePasscodeOverlay = () => {
    clientPasscodeOverlay.classList.remove("open");
    clientPasscodeOverlay.setAttribute("aria-hidden", "true");
    if (passcodeInput) passcodeInput.value = "";
    if (passcodeError) passcodeError.textContent = "";
  };

  const openPasscodeOverlay = (details) => {
    pendingGallery = details;
    clientProjectOverlay.classList.remove("open");
    clientProjectOverlay.setAttribute("aria-hidden", "true");
    clientPasscodeOverlay.classList.add("open");
    clientPasscodeOverlay.setAttribute("aria-hidden", "false");
    window.setTimeout(() => passcodeInput?.focus(), 50);
  };

  // Carry the selected gallery's access settings onto the View gallery link.
  document.querySelectorAll("[data-client-project]").forEach((card) => {
    card.addEventListener("click", () => {
      window.setTimeout(() => {
        if (!clientView || clientView.hidden) return;
        clientView.dataset.galleryKey = card.dataset.clientKey || "";
        clientView.dataset.galleryPasscode = card.dataset.clientPasscode || "";
      }, 0);
    });
  });

  clientView?.addEventListener("click", (event) => {
    const url = clientView.getAttribute("href") || "";
    const key = clientView.dataset.galleryKey || "";
    const passcode = clientView.dataset.galleryPasscode || "";
    if (!url || !key || !passcode) return;

    event.preventDefault();
    try {
      if (sessionStorage.getItem(`clientGalleryAccess:${key}`) === "1") {
        window.location.href = url;
        return;
      }
    } catch (error) {}
    openPasscodeOverlay({ url, key, passcode });
  });

  passcodeForm?.addEventListener("submit", (event) => {
    event.preventDefault();
    if (!pendingGallery || !passcodeInput) return;
    if (passcodeInput.value === pendingGallery.passcode) {
      try {
        sessionStorage.setItem(`clientGalleryAccess:${pendingGallery.key}`, "1");
      } catch (error) {}
      const destination = pendingGallery.url;
      closePasscodeOverlay();
      window.location.href = destination;
      return;
    }
    if (passcodeError) passcodeError.textContent = "Incorrect passcode. Please try again.";
    passcodeInput.select();
  });

  passcodeInput?.addEventListener("input", () => {
    if (passcodeError) passcodeError.textContent = "";
  });
  passcodeClose?.addEventListener("click", closePasscodeOverlay);
  clientPasscodeOverlay.addEventListener("click", (event) => {
    if (event.target === clientPasscodeOverlay) closePasscodeOverlay();
  });
  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape" && clientPasscodeOverlay.classList.contains("open")) {
      closePasscodeOverlay();
    }
  });
}
