// LinksBase Client Scripts

document.addEventListener('DOMContentLoaded', () => {
    initClock();
    initModal();
    initCardClicks();
    initCopyButtons();
    initUrlHelper();
});

/**
 * Live Date & Time Clock
 * Preserves and polishes the user's original clock feature.
 */
function initClock() {
    const clockEl = document.getElementById('live-clock-time');
    if (!clockEl) return;

    function update() {
        const now = new Date();
        const options = {
            weekday: 'short',
            month: 'short',
            day: 'numeric',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: true
        };
        clockEl.textContent = now.toLocaleString(undefined, options);
    }

    update();
    setInterval(update, 1000);
}

/**
 * Modal Open / Close Logic
 */
function initModal() {
    const modal = document.getElementById('add-link-modal');
    const openBtn = document.getElementById('open-add-modal-btn');
    const closeBtn = document.getElementById('close-modal-btn');
    const cancelBtn = document.getElementById('cancel-modal-btn');

    if (!modal) return;

    function openModal() {
        modal.classList.add('active');
        modal.setAttribute('aria-hidden', 'false');
        setTimeout(() => {
            const urlInput = document.getElementById('link-url');
            if (urlInput) urlInput.focus();
        }, 50);
    }

    function closeModal() {
        modal.classList.remove('active');
        modal.setAttribute('aria-hidden', 'true');
    }

    if (openBtn) openBtn.addEventListener('click', openModal);
    if (closeBtn) closeBtn.addEventListener('click', closeModal);
    if (cancelBtn) cancelBtn.addEventListener('click', closeModal);

    // Close when clicking outside card
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeModal();
        }
    });

    // Close on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal.classList.contains('active')) {
            closeModal();
        }
    });

    // Expose open helper globally for category pages
    window.openAddModalWithTags = function(major, minor) {
        if (major) {
            const majorInput = document.getElementById('link-major');
            if (majorInput) majorInput.value = major;
        }
        if (minor) {
            const minorInput = document.getElementById('link-minor');
            if (minorInput) minorInput.value = minor;
        }
        openModal();
    };
}

/**
 * Card Click Behavior:
 * Clicking anywhere on a link card opens destination in a new tab.
 */
function initCardClicks() {
    document.querySelectorAll('.link-card[data-url]').forEach(card => {
        card.addEventListener('click', (e) => {
            // If the user clicked a form, button, or anchor inside, do not trigger card open
            if (e.target.closest('button') || e.target.closest('a') || e.target.closest('form')) {
                return;
            }
            const url = card.getAttribute('data-url');
            if (url) {
                window.open(url, '_blank', 'noopener,noreferrer');
            }
        });
    });
}

/**
 * Copy Link to Clipboard with Toast Notification
 */
function initCopyButtons() {
    document.querySelectorAll('.copy-link-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            const url = btn.getAttribute('data-url');
            if (!url) return;

            navigator.clipboard.writeText(url).then(() => {
                showToast('URL copied to clipboard!');
            }).catch(() => {
                // Fallback prompt if clipboard API is restricted
                showToast('Copied: ' + url);
            });
        });
    });
}

/**
 * Floating Toast Notification
 */
function showToast(message) {
    let container = document.getElementById('toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'toast-container';
        document.body.appendChild(container);
    }

    const toast = document.createElement('div');
    toast.className = 'toast';
    toast.innerHTML = `<span>✓</span><span>${escapeHtml(message)}</span>`;
    container.appendChild(toast);

    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(10px)';
        toast.style.transition = 'all 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 2800);
}

/**
 * URL Auto-Helper (Suggest title based on URL host)
 */
function initUrlHelper() {
    const urlInput = document.getElementById('link-url');
    const titleInput = document.getElementById('link-title');
    if (!urlInput || !titleInput) return;

    urlInput.addEventListener('blur', () => {
        const val = urlInput.value.trim();
        if (val && !titleInput.value.trim()) {
            try {
                if (val.startsWith('http://') || val.startsWith('https://')) {
                    const u = new URL(val);
                    const host = u.hostname.replace(/^www\./, '');
                    const cleanTitle = host.split('.')[0];
                    titleInput.value = cleanTitle.charAt(0).toUpperCase() + cleanTitle.slice(1);
                } else if (val.startsWith('file:///')) {
                    const parts = val.split('/');
                    titleInput.value = decodeURIComponent(parts[parts.length - 1] || 'Local File');
                }
            } catch (err) {
                // Ignore parse errors
            }
        }
    });
}

function escapeHtml(str) {
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
}
