// Show full email for guests and authorized users
function showEmail() {
  document.querySelectorAll('.car-details-email-view').forEach((el) => {
    el.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
      const emailLink = el.closest('.car-details-email');
      if (!emailLink) return;
      const fullEmail = emailLink.dataset.fullEmail;
      if (fullEmail) {
        emailLink.childNodes.forEach((node) => {
          if (node.nodeType === Node.TEXT_NODE && node.textContent.trim() !== '') {
            node.textContent = ' ' + fullEmail + ' ';
          }
        });
        el.style.display = 'none';
        emailLink.removeAttribute('href');
      }
    });
    el.addEventListener('mousedown', (e) => e.preventDefault());
    el.addEventListener('touchstart', (e) => e.preventDefault());
  });
}
// Show full phone number for guests and authorized users
function showPhone() {
  document.querySelectorAll('.car-details-phone-view').forEach((el) => {
    el.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
      // Find the parent .car-details-phone anchor
      const phoneLink = el.closest('.car-details-phone');
      if (!phoneLink) return;
      // Get the full phone number from data attribute or fallback
      const fullPhone = phoneLink.dataset.fullPhone;
      if (fullPhone) {
        // Replace masked text with full phone
        phoneLink.childNodes.forEach((node) => {
          if (node.nodeType === Node.TEXT_NODE && node.textContent.trim() !== '') {
            node.textContent = ' ' + fullPhone + ' ';
          }
        });
        // Optionally, remove the view full number span
        el.style.display = 'none';
        // Remove href to prevent further tel: action
        phoneLink.removeAttribute('href');
      }
    });
    // Prevent default on mousedown/touchstart to block browser app popups
    el.addEventListener('mousedown', (e) => e.preventDefault());
    el.addEventListener('touchstart', (e) => e.preventDefault());
  });
}
import './bootstrap';

document.addEventListener("DOMContentLoaded", function () {
  const initSlider = () => {
    const slides = document.querySelectorAll(".hero-slide");
    let currentIndex = 0; // Track the current slide
    const totalSlides = slides.length;

    function moveToSlide(n) {
      slides.forEach((slide, index) => {
        slide.style.transform = `translateX(${-100 * n}%)`;
        if (n === index) {
          slide.classList.add("active");
        } else {
          slide.classList.remove("active");
        }
      });
      currentIndex = n;
    }

    // Function to go to the next slide
    function nextSlide() {
      if (currentIndex === totalSlides - 1) {
        moveToSlide(0); // Go to the first slide if we're at the last
      } else {
        moveToSlide(currentIndex + 1);
      }
    }

    // Function to go to the previous slide
    function prevSlide() {
      if (currentIndex === 0) {
        moveToSlide(totalSlides - 1); // Go to the last slide if we're at the first
      } else {
        moveToSlide(currentIndex - 1);
      }
    }

    // Example usage with buttons
    // Assuming you have buttons with classes `.next` and `.prev` for navigation
    const carouselNextButton = document.querySelector(".hero-slide-next");
    if (carouselNextButton) {
      carouselNextButton.addEventListener("click", nextSlide);
    }
    const carouselPrevButton = document.querySelector(".hero-slide-prev");
    if (carouselPrevButton) {
      carouselPrevButton.addEventListener("click", prevSlide);
    }

    // Initialize the slider
    moveToSlide(0);
  };

  const initImagePicker = () => {
    const fileInput = document.querySelector("#carFormImageUpload");
    const imagePreview = document.querySelector("#imagePreviews");
    if (!fileInput) {
      return;
    }
    fileInput.onchange = (ev) => {
      imagePreview.innerHTML = "";
      const files = ev.target.files;
      for (let file of files) {
        readFile(file).then((url) => {
          const img = createImage(url);
          imagePreview.append(img);
        });
      }
    };

    function readFile(file) {
      return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.onload = (ev) => {
          resolve(ev.target.result);
        };
        reader.onerror = (ev) => {
          reject(ev);
        };
        reader.readAsDataURL(file);
      });
    }

    function createImage(url) {
      const a = document.createElement("a");
      a.classList.add("car-form-image-preview");
      a.innerHTML = `
        <img src="${url}" />
      `;
      return a;
    }
  };

  const initMobileNavbar = () => {
    const btnToggle = document.querySelector(".btn-navbar-toggle");
    if (!btnToggle) {
      return;
    }

    btnToggle.onclick = () => {
      document.body.classList.toggle("navbar-opened");
    };
  };

  const initPasswordToggle = () => {
    const toggleButtons = document.querySelectorAll('[data-password-toggle]');
    if (!toggleButtons.length) {
      return;
    }

    toggleButtons.forEach((button) => {
      const targetId = button.dataset.target;
      if (!targetId) {
        return;
      }

      const passwordInput = document.getElementById(targetId);
      if (!passwordInput) {
        return;
      }

      button.addEventListener('click', () => {
        const isPasswordHidden = passwordInput.type === 'password';
        passwordInput.type = isPasswordHidden ? 'text' : 'password';
        button.textContent = isPasswordHidden ? 'Hide' : 'Show';
        button.setAttribute('aria-label', isPasswordHidden ? 'Hide password' : 'Show password');
        button.setAttribute('aria-pressed', isPasswordHidden ? 'true' : 'false');
      });
    });
  };

  const imageCarousel = () => {
    const carousel = document.querySelector('.car-images-carousel');
    if (!carousel) {
      return;
    }
    const thumbnails = document.querySelectorAll('.car-image-thumbnails img');
    const activeImage = document.getElementById('activeImage');
    const prevButton = document.getElementById('prevButton');
    const nextButton = document.getElementById('nextButton');


    let currentIndex = 0;

    // Initialize active thumbnail class
    thumbnails.forEach((thumbnail, index) => {
      if (thumbnail.src === activeImage.src) {
        thumbnail.classList.add('active-thumbnail');
        currentIndex = index;
      }
    });

    // Function to update the active image and thumbnail
    const updateActiveImage = (index) => {
      activeImage.src = thumbnails[index].src;
      thumbnails.forEach(thumbnail => thumbnail.classList.remove('active-thumbnail'));
      thumbnails[index].classList.add('active-thumbnail');
    };

    // Add click event listeners to thumbnails
    thumbnails.forEach((thumbnail, index) => {
      thumbnail.addEventListener('click', () => {
        currentIndex = index;
        updateActiveImage(currentIndex);
      });
    });

    // Add click event listener to the previous button
    prevButton.addEventListener('click', () => {
      currentIndex = (currentIndex - 1 + thumbnails.length) % thumbnails.length;
      updateActiveImage(currentIndex);
    });

    // Add click event listener to the next button
    nextButton.addEventListener('click', () => {
      currentIndex = (currentIndex + 1) % thumbnails.length;
      updateActiveImage(currentIndex);
    });
  }

  const initMobileFilters = () => {
    const filterButton = document.querySelector('.show-filters-button');
    const sidebar = document.querySelector('.search-cars-sidebar');
    const closeButton = document.querySelector('.close-filters-button');

    if (!filterButton) return;

    console.log(filterButton.classList)
    filterButton.addEventListener('click', () => {
      if (sidebar.classList.contains('opened')) {
        sidebar.classList.remove('opened')
      } else {
        sidebar.classList.add('opened')
      }
    });

    if (closeButton) {
      closeButton.addEventListener('click', () => {
        sidebar.classList.remove('opened')
      })
    }
  }

  const initCascadingDropdown = (parentSelector, childSelector) => {
    const parentDropdown = document.querySelector(parentSelector);
    const childDropdown = document.querySelector(childSelector);

    if (!parentDropdown || !childDropdown) return;

    hideModelOptions(parentDropdown.value)

    parentDropdown.addEventListener('change', (ev) => {
      hideModelOptions(ev.target.value)
      childDropdown.value = ''
    });

    function hideModelOptions(parentValue) {
      const models = childDropdown.querySelectorAll('option');
      models.forEach(model => {
        if (model.dataset.parent === parentValue || model.value === '') {
          model.style.display = 'block';
        } else {
          model.style.display = 'none';
        }
      });
    }
  }

  const initSortingDropdown = () => {
    const sortingDropdown = document.querySelector('.sort-dropdown');
    if (!sortingDropdown) return;

    // Init sorting dropdown with the current value
    const url = new URL(window.location.href);
    const sortValue = url.searchParams.get('sort');
    if (sortValue) {
      sortingDropdown.value = sortValue;
    }

    sortingDropdown.addEventListener('change', (ev) => {
      const url = new URL(window.location.href);
      url.searchParams.set('sort', ev.target.value);
      window.location.href = url.toString();
    });
  }

  const sendWatchlistRequest = async (form, shouldBeInWatchlist) => {
    const formData = new FormData(form);
    if (shouldBeInWatchlist) {
      formData.delete('_method');
    } else {
      formData.set('_method', 'DELETE');
    }

    const response = await fetch(form.action, {
      method: 'POST',
      body: formData,
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json',
      },
    });

    if (!response.ok) {
      throw new Error('Failed to toggle watchlist');
    }
  };

  const showWatchlistToast = (message, type = 'success', options = {}) => {
    let container = document.querySelector('.watchlist-toast-container');
    if (!container) {
      container = document.createElement('div');
      container.className = 'watchlist-toast-container';
      document.body.appendChild(container);
    }

    const toast = document.createElement('div');
    toast.className = `watchlist-toast watchlist-toast-${type}`;
    toast.textContent = message;

    if (options.actionLabel && typeof options.onAction === 'function') {
      const actionButton = document.createElement('button');
      actionButton.type = 'button';
      actionButton.className = 'watchlist-toast-action';
      actionButton.textContent = options.actionLabel;
      actionButton.addEventListener('click', () => {
        options.onAction();
        toast.remove();
      });
      toast.appendChild(actionButton);
    }

    container.appendChild(toast);

    requestAnimationFrame(() => {
      toast.classList.add('watchlist-toast-visible');
    });

    setTimeout(() => {
      toast.classList.remove('watchlist-toast-visible');
      setTimeout(() => {
        toast.remove();
      }, 250);
    }, 2000);
  };

  const initWatchlistToggle = () => {
    const watchlistForms = document.querySelectorAll('[data-watchlist-form]');
    if (!watchlistForms.length) return;

    const outlineHeartIcon = `
      <svg
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke-width="1.5"
        stroke="currentColor"
        style="width: 16px"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"
        />
      </svg>
    `;

    const filledHeartIcon = `
      <svg
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 24 24"
        fill="currentColor"
        style="width: 16px"
      >
        <path
          d="m11.645 20.91-.007-.003-.022-.012a15.247 15.247 0 0 1-.383-.218 25.18 25.18 0 0 1-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0 1 12 5.052 5.5 5.5 0 0 1 16.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 0 1-4.244 3.17 15.247 15.247 0 0 1-.383.219l-.022.012-.007.004-.003.001a.752.752 0 0 1-.704 0l-.003-.001Z"
        />
      </svg>
    `;

    const getIconSize = (button) => {
      return button.closest('.car-details') ? 20 : 16;
    };

    const setButtonState = (form, isInWatchlist) => {
      const button = form.querySelector('.btn-heart');
      if (!button) return;

      const icon = isInWatchlist ? filledHeartIcon : outlineHeartIcon;
      const iconWithSize = icon.replace('width: 16px', `width: ${getIconSize(button)}px`);
      button.innerHTML = iconWithSize;
      button.setAttribute('aria-label', isInWatchlist ? 'Remover de la lista de deseos' : 'Agregar a la lista de deseos');
      form.dataset.inWatchlist = isInWatchlist ? 'true' : 'false';

      const methodInput = form.querySelector('input[name="_method"]');
      if (isInWatchlist) {
        if (!methodInput) {
          const input = document.createElement('input');
          input.type = 'hidden';
          input.name = '_method';
          input.value = 'DELETE';
          form.appendChild(input);
        }
      } else if (methodInput) {
        methodInput.remove();
      }
    };

    watchlistForms.forEach((form) => {
      form.addEventListener('submit', async (ev) => {
        ev.preventDefault();

        if (form.dataset.loading === 'true') return;
        form.dataset.loading = 'true';

        const button = form.querySelector('.btn-heart');
        if (button) button.disabled = true;

          try {
            const isCurrentlyInWatchlist = form.dataset.inWatchlist === 'true';
            await sendWatchlistRequest(form, !isCurrentlyInWatchlist);

          setButtonState(form, !isCurrentlyInWatchlist);

            if (isCurrentlyInWatchlist) {
              showWatchlistToast('Automóvil eliminado de la lista de deseos', 'success', {
                actionLabel: 'Deshacer',
                onAction: async () => {
                  try {
                    if (form.dataset.loading === 'true') return;
                    form.dataset.loading = 'true';
                    if (button) button.disabled = true;

                    await sendWatchlistRequest(form, true);
                    setButtonState(form, true);
                    showWatchlistToast('Automóvil restaurado en la lista de deseos');
                  } catch (error) {
                    showWatchlistToast('No se pudo restaurar el automóvil en la lista de deseos.', 'error');
                  } finally {
                    form.dataset.loading = 'false';
                    if (button) button.disabled = false;
                  }
                },
              });
            } else {
              showWatchlistToast('Automóvil agregado a la lista de deseos');
            }
        } catch (error) {
          showWatchlistToast('No se pudo actualizar la lista de deseos. Por favor, inténtalo de nuevo.', 'error');
        } finally {
          form.dataset.loading = 'false';
          if (button) button.disabled = false;
        }
      });
    });
  };

  initSlider();
  initImagePicker();
  initMobileNavbar();
  imageCarousel();
  initMobileFilters();
  initCascadingDropdown('#makerSelect', '#modelSelect');
  initCascadingDropdown('#stateSelect', '#citySelect');
  initSortingDropdown();
  initWatchlistToggle();
  initPasswordToggle();
  showPhone();
  showEmail();

  // Reset button for car search form
  document.querySelectorAll('.btn-find-a-car-reset').forEach(function(btn) {
    btn.addEventListener('click', function() {
      const form = btn.closest('form');
      if (!form) return;
      // Clear all input/select fields
      form.querySelectorAll('input, select').forEach(function(el) {
        if (el.type === 'checkbox' || el.type === 'radio') {
          el.checked = false;
        } else {
          el.value = '';
        }
      });
      // Submit the form with no filters
      form.submit();
    });
  });

  ScrollReveal().reveal(".hero-slide.active .hero-slider-title", {
    delay: 200,
    reset: true,
  });
  ScrollReveal().reveal(".hero-slide.active .hero-slider-content", {
    delay: 200,
    origin: "bottom",
    distance: "50%",
  });
});

