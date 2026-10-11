/* ===================================================================
   Khushi Enterprises - B2B Wholesale Supplier (Pune)
   Frontend Logic: Product Filtering, Search, WhatsApp Order Builder,
   Modal Quick View, and Contact Form Submission
   =================================================================== */

(function () {
  'use strict';

  const PRIMARY_PHONE = '918050653180';
  const SECONDARY_PHONE = '918149665755';

  let currentCategory = 'all';
  let searchQuery = '';
  let activeProducts = [];

  // DOM Elements
  const productsContainer = document.getElementById('products-grid');
  const searchInput = document.getElementById('search-input');
  const clearSearchBtn = document.getElementById('clear-search-btn');
  const filterPills = document.querySelectorAll('.filter-pill');
  const categoryCards = document.querySelectorAll('.category-card');
  const productCountEl = document.getElementById('product-count');
  const modalBackdrop = document.getElementById('product-modal');
  const modalCloseBtn = document.getElementById('modal-close-btn');
  const mobileMenuBtn = document.getElementById('mobile-menu-btn');
  const mobileDrawer = document.getElementById('mobile-drawer');
  const drawerBackdrop = document.getElementById('drawer-backdrop');
  const drawerCloseBtn = document.getElementById('drawer-close-btn');
  const drawerLinks = document.querySelectorAll('.drawer-nav a');
  const requirementForm = document.getElementById('whatsapp-builder-form');
  const contactForm = document.getElementById('contact-form');
  const contactAlert = document.getElementById('contact-alert');

  // Initialize
  function init() {
    if (window.KHUSHI_PRODUCTS && Array.isArray(window.KHUSHI_PRODUCTS)) {
      activeProducts = [...window.KHUSHI_PRODUCTS];
      renderProducts(activeProducts);
    }

    setupEventListeners();
    populateRequirementSelect();
  }

  // Render Product Cards
  function renderProducts(items) {
    if (!productsContainer) return;

    if (items.length === 0) {
      productsContainer.innerHTML = `
        <div style="grid-column: 1 / -1; text-align: center; padding: 40px 20px; background: #fff; border-radius: 12px; border: 1px dashed #cbd5e1;">
          <h3 style="color: var(--navy-primary); font-size: 18px; margin-bottom: 8px;">Koi Product Match Nahi Hua</h3>
          <p style="color: var(--text-muted); font-size: 14px; margin-bottom: 16px;">Aap jo product dhoond rahe hain wo shayad alag naam se ho. Direct WhatsApp par photo ya requirement bhejiye.</p>
          <a href="https://wa.me/${PRIMARY_PHONE}?text=${encodeURIComponent('Hello Khushi Enterprises, Mujhe wholesale requirement ke baare me poochhna hai.')}" target="_blank" class="btn btn-whatsapp btn-sm">
            WhatsApp Par Direct Requirement Bheje
          </a>
        </div>
      `;
      if (productCountEl) productCountEl.innerText = '0 Products';
      return;
    }

    let html = '';
    items.forEach(function (product) {
      const waText = encodeURIComponent(
        `Hello Khushi Enterprises, mujhe ${product.name} (ID: #${product.id}) ka wholesale rate aur availability janni hai. Bulk order requirement hai.`
      );
      const waUrl = `https://wa.me/${PRIMARY_PHONE}?text=${waText}`;

      html += `
        <div class="product-card" data-id="${product.id}">
          <div class="product-img-wrapper" onclick="window.khushiOpenModal(${product.id})">
            <span class="wholesale-badge">Wholesale</span>
            <span class="brand-badge">${escapeHtml(product.brand)}</span>
            <img src="${product.image}" alt="${escapeHtml(product.name)}" loading="lazy" onerror="this.src='assets/images/brand/logo.png'">
          </div>
          <div class="product-body">
            <span class="product-cat-name">${escapeHtml(product.categoryLabel)}</span>
            <h3 class="product-name" title="${escapeHtml(product.name)}">${escapeHtml(product.name)}</h3>
            <p class="product-desc">${escapeHtml(product.description)}</p>
            <div class="product-pricing-tag">
              <span>Best Wholesale Rates</span>
              <small>No Minimum Order Limit</small>
            </div>
            <div class="product-actions">
              <a href="${waUrl}" target="_blank" class="btn-card-wa" rel="noopener noreferrer">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                Rate on WhatsApp
              </a>
              <button type="button" class="btn-card-quick" onclick="window.khushiOpenModal(${product.id})">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                Details & Packing
              </button>
            </div>
          </div>
        </div>
      `;
    });

    productsContainer.innerHTML = html;
    if (productCountEl) {
      productCountEl.innerHTML = `Showing <strong>${items.length}</strong> Products`;
    }
  }

  // Filter & Search Logic
  function applyFilterAndSearch() {
    if (!window.KHUSHI_PRODUCTS) return;

    let filtered = window.KHUSHI_PRODUCTS.filter(function (p) {
      const matchCat = currentCategory === 'all' || p.category === currentCategory;
      const q = searchQuery.toLowerCase().trim();
      const matchSearch =
        q === '' ||
        p.name.toLowerCase().includes(q) ||
        p.description.toLowerCase().includes(q) ||
        p.brand.toLowerCase().includes(q) ||
        p.categoryLabel.toLowerCase().includes(q);

      return matchCat && matchSearch;
    });

    activeProducts = filtered;
    renderProducts(filtered);
  }

  // Setup Event Listeners
  function setupEventListeners() {
    // Search input
    if (searchInput) {
      searchInput.addEventListener('input', function (e) {
        searchQuery = e.target.value;
        if (clearSearchBtn) {
          clearSearchBtn.style.display = searchQuery ? 'block' : 'none';
        }
        applyFilterAndSearch();
      });
    }

    if (clearSearchBtn) {
      clearSearchBtn.addEventListener('click', function () {
        searchInput.value = '';
        searchQuery = '';
        clearSearchBtn.style.display = 'none';
        applyFilterAndSearch();
        searchInput.focus();
      });
    }

    // Filter pills
    filterPills.forEach(function (pill) {
      pill.addEventListener('click', function () {
        filterPills.forEach((p) => p.classList.remove('active'));
        pill.classList.add('active');
        currentCategory = pill.getAttribute('data-category');

        // Sync category cards if any
        categoryCards.forEach((c) => {
          c.classList.toggle('active', c.getAttribute('data-category') === currentCategory);
        });

        applyFilterAndSearch();
      });
    });

    // Category cards jump
    categoryCards.forEach(function (card) {
      card.addEventListener('click', function () {
        const cat = card.getAttribute('data-category');
        currentCategory = cat;

        categoryCards.forEach((c) => c.classList.remove('active'));
        card.classList.add('active');

        filterPills.forEach((p) => {
          p.classList.toggle('active', p.getAttribute('data-category') === cat);
        });

        applyFilterAndSearch();

        const catSection = document.getElementById('products-section');
        if (catSection) {
          catSection.scrollIntoView({ behavior: 'smooth' });
        }
      });
    });

    // Modal close
    if (modalCloseBtn) {
      modalCloseBtn.addEventListener('click', closeModal);
    }
    if (modalBackdrop) {
      modalBackdrop.addEventListener('click', function (e) {
        if (e.target === modalBackdrop) closeModal();
      });
    }

    // Mobile drawer toggle
    if (mobileMenuBtn && mobileDrawer && drawerBackdrop) {
      mobileMenuBtn.addEventListener('click', function () {
        mobileDrawer.classList.add('open');
        drawerBackdrop.classList.add('open');
      });

      const closeDrawer = function () {
        mobileDrawer.classList.remove('open');
        drawerBackdrop.classList.remove('open');
      };

      if (drawerCloseBtn) drawerCloseBtn.addEventListener('click', closeDrawer);
      drawerBackdrop.addEventListener('click', closeDrawer);
      drawerLinks.forEach((link) => link.addEventListener('click', closeDrawer));
    }

    // WhatsApp Bulk Requirement Builder Form
    if (requirementForm) {
      requirementForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const shopName = document.getElementById('b-shop')?.value || '';
        const phone = document.getElementById('b-phone')?.value || '';
        const location = document.getElementById('b-location')?.value || '';
        const product = document.getElementById('b-product')?.value || '';
        const quantity = document.getElementById('b-quantity')?.value || '';
        const notes = document.getElementById('b-notes')?.value || '';

        let text = `*WHLESALE REQUIREMENT ENQUIRY*\n`;
        text += `------------------------------------\n`;
        if (shopName) text += `*Dukaan/Shop:* ${shopName}\n`;
        if (phone) text += `*Phone:* ${phone}\n`;
        if (location) text += `*Area/City:* ${location}\n`;
        if (product) text += `*Product:* ${product}\n`;
        if (quantity) text += `*Quantity/Packing:* ${quantity}\n`;
        if (notes) text += `*Notes:* ${notes}\n`;
        text += `------------------------------------\n`;
        text += `Please wholesale quotation aur best rate list share kijiye.`;

        const waUrl = `https://wa.me/${PRIMARY_PHONE}?text=${encodeURIComponent(text)}`;
        window.open(waUrl, '_blank');
      });
    }

    // Contact form AJAX submission
    if (contactForm) {
      contactForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const submitBtn = contactForm.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Submitting Requirement...';

        const formData = new FormData(contactForm);

        fetch('api/enquiry.php', {
          method: 'POST',
          body: formData,
        })
          .then((res) => res.json())
          .then((data) => {
            if (contactAlert) {
              contactAlert.className = 'form-alert ' + (data.success ? 'success' : 'error');
              contactAlert.innerText = data.message || (data.success ? 'Enquiry submitted successfully! Hum aapse jald hi contact karenge.' : 'Kuch gadbad hui. Please WhatsApp par contact karein.');
              contactAlert.style.display = 'block';
            }
            if (data.success) {
              contactForm.reset();
            }
          })
          .catch((err) => {
            console.error(err);
            // Graceful fallback to WhatsApp direct redirect
            const name = formData.get('name') || '';
            const shop = formData.get('shop_name') || '';
            const phone = formData.get('phone') || '';
            const message = formData.get('message') || '';

            const waFallback = `*WHOLESALE CONTACT ENQUIRY*\nNaam: ${name}\nDukaan: ${shop}\nPhone: ${phone}\nRequirement: ${message}`;
            window.open(`https://wa.me/${PRIMARY_PHONE}?text=${encodeURIComponent(waFallback)}`, '_blank');

            if (contactAlert) {
              contactAlert.className = 'form-alert success';
              contactAlert.innerText = 'Direct WhatsApp connect open ho raha hai. Aap wahan requirement confirm kar sakte hain.';
              contactAlert.style.display = 'block';
            }
          })
          .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
          });
      });
    }
  }

  // Populate Requirement select box
  function populateRequirementSelect() {
    const select = document.getElementById('b-product');
    if (!select || !window.KHUSHI_PRODUCTS) return;

    window.KHUSHI_PRODUCTS.slice(0, 30).forEach(function (p) {
      const opt = document.createElement('option');
      opt.value = p.name;
      opt.textContent = `${p.name} (${p.categoryLabel})`;
      select.appendChild(opt);
    });
  }

  // Open Modal Quick View
  window.khushiOpenModal = function (id) {
    if (!window.KHUSHI_PRODUCTS) return;
    const product = window.KHUSHI_PRODUCTS.find((p) => p.id === id);
    if (!product || !modalBackdrop) return;

    const modalImg = document.getElementById('modal-img');
    const modalTitle = document.getElementById('modal-title');
    const modalCat = document.getElementById('modal-category');
    const modalBrand = document.getElementById('modal-brand');
    const modalDesc = document.getElementById('modal-desc');
    const modalWaBtn = document.getElementById('modal-wa-btn');

    if (modalImg) modalImg.src = product.image;
    if (modalTitle) modalTitle.innerText = product.name;
    if (modalCat) modalCat.innerText = product.categoryLabel;
    if (modalBrand) modalBrand.innerText = product.brand;
    if (modalDesc) modalDesc.innerText = product.description;

    const waText = encodeURIComponent(
      `Hello Khushi Enterprises, mujhe ${product.name} (Category: ${product.categoryLabel}, Brand: ${product.brand}) ke wholesale rate, carton packing aur supply details chahiye.`
    );
    if (modalWaBtn) {
      modalWaBtn.href = `https://wa.me/${PRIMARY_PHONE}?text=${waText}`;
    }

    modalBackdrop.classList.add('open');
    document.body.style.overflow = 'hidden';
  };

  function closeModal() {
    if (modalBackdrop) {
      modalBackdrop.classList.remove('open');
      document.body.style.overflow = '';
    }
  }

  function escapeHtml(str) {
    if (!str) return '';
    return str
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#039;');
  }

  // Run on DOM ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
