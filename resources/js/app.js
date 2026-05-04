/**
 * E-Commerce Melayu — Main JavaScript
 * Handles: mobile menu, modals, dropdowns, scroll reveals, tab switching, cart controls
 */

document.addEventListener('DOMContentLoaded', () => {
    initScrollReveal();
    initMobileMenu();
    initDropdowns();
    initModals();
    initTabs();
    initCartControls();
    initSidebar();
    initCounterAnimation();
    initDeleteConfirm();
    initPasswordToggle();
    initSearchFocus();
});

/* ============================================
   SCROLL REVEAL — IntersectionObserver
   ============================================ */
function initScrollReveal() {
    const revealElements = document.querySelectorAll('.reveal, .reveal-left, .reveal-right');
    if (!revealElements.length) return;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                // Stagger effect
                setTimeout(() => {
                    entry.target.classList.add('revealed');
                }, index * 100);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

    revealElements.forEach(el => observer.observe(el));
}

/* ============================================
   MOBILE MENU TOGGLE
   ============================================ */
function initMobileMenu() {
    const toggleBtn = document.getElementById('mobile-menu-toggle');
    const menu = document.getElementById('mobile-menu');
    const overlay = document.getElementById('mobile-menu-overlay');

    if (!toggleBtn || !menu) return;

    toggleBtn.addEventListener('click', () => {
        menu.classList.toggle('hidden');
        menu.classList.toggle('flex');
        if (overlay) overlay.classList.toggle('hidden');
        document.body.classList.toggle('overflow-hidden');
    });

    if (overlay) {
        overlay.addEventListener('click', () => {
            menu.classList.add('hidden');
            menu.classList.remove('flex');
            overlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        });
    }
}

/* ============================================
   DROPDOWN MENUS
   ============================================ */
function initDropdowns() {
    document.querySelectorAll('[data-dropdown-toggle]').forEach(btn => {
        const targetId = btn.getAttribute('data-dropdown-toggle');
        const dropdown = document.getElementById(targetId);
        if (!dropdown) return;

        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            // Close all other dropdowns
            document.querySelectorAll('.dropdown-menu.active').forEach(d => {
                if (d !== dropdown) d.classList.remove('active');
            });
            dropdown.classList.toggle('active');
        });
    });

    // Close dropdowns on outside click
    document.addEventListener('click', () => {
        document.querySelectorAll('.dropdown-menu.active').forEach(d => {
            d.classList.remove('active');
        });
    });
}

/* ============================================
   MODAL OPEN/CLOSE
   ============================================ */
function initModals() {
    // Open modal buttons
    document.querySelectorAll('[data-modal-open]').forEach(btn => {
        const targetId = btn.getAttribute('data-modal-open');
        const modal = document.getElementById(targetId);
        if (!modal) return;

        btn.addEventListener('click', () => {
            modal.classList.add('active');
            document.body.classList.add('overflow-hidden');
        });
    });

    // Close modal buttons
    document.querySelectorAll('[data-modal-close]').forEach(btn => {
        btn.addEventListener('click', () => {
            const modal = btn.closest('.modal-overlay');
            if (modal) {
                modal.classList.remove('active');
                document.body.classList.remove('overflow-hidden');
            }
        });
    });

    // Close on overlay click
    document.querySelectorAll('.modal-overlay').forEach(modal => {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.remove('active');
                document.body.classList.remove('overflow-hidden');
            }
        });
    });
}

/* ============================================
   TAB SWITCHING
   ============================================ */
function initTabs() {
    document.querySelectorAll('[data-tab-group]').forEach(tabGroup => {
        const tabs = tabGroup.querySelectorAll('[data-tab]');
        const groupName = tabGroup.getAttribute('data-tab-group');
        const panels = document.querySelectorAll(`[data-tab-panel][data-tab-group="${groupName}"]`);

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const target = tab.getAttribute('data-tab');

                // Update tab styles
                tabs.forEach(t => {
                    t.classList.remove('text-primary-600', 'border-primary-600', 'bg-primary-50');
                    t.classList.add('text-gray-500', 'border-transparent');
                });
                tab.classList.add('text-primary-600', 'border-primary-600', 'bg-primary-50');
                tab.classList.remove('text-gray-500', 'border-transparent');

                // Show/hide panels
                panels.forEach(panel => {
                    if (panel.getAttribute('data-tab-panel') === target) {
                        panel.classList.remove('hidden');
                        panel.classList.add('animate-fade-in');
                    } else {
                        panel.classList.add('hidden');
                        panel.classList.remove('animate-fade-in');
                    }
                });
            });
        });
    });
}

/* ============================================
   CART QUANTITY CONTROLS
   ============================================ */
function initCartControls() {
    document.querySelectorAll('.qty-control').forEach(control => {
        const minusBtn = control.querySelector('.qty-minus');
        const plusBtn = control.querySelector('.qty-plus');
        const input = control.querySelector('.qty-input');
        if (!minusBtn || !plusBtn || !input) return;

        minusBtn.addEventListener('click', () => {
            let val = parseInt(input.value) || 1;
            if (val > 1) {
                input.value = val - 1;
                input.dispatchEvent(new Event('change'));
            }
        });

        plusBtn.addEventListener('click', () => {
            let val = parseInt(input.value) || 1;
            input.value = val + 1;
            input.dispatchEvent(new Event('change'));
        });
    });
}

/* ============================================
   SIDEBAR TOGGLE (Mobile)
   ============================================ */
function initSidebar() {
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebar-overlay');

    if (!sidebarToggle || !sidebar) return;

    sidebarToggle.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
        if (sidebarOverlay) sidebarOverlay.classList.toggle('hidden');
    });

    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
        });
    }
}

/* ============================================
   ANIMATED COUNTER (for dashboard stats)
   ============================================ */
function initCounterAnimation() {
    const counters = document.querySelectorAll('[data-counter]');
    if (!counters.length) return;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const el = entry.target;
                const target = parseInt(el.getAttribute('data-counter'));
                const prefix = el.getAttribute('data-counter-prefix') || '';
                const suffix = el.getAttribute('data-counter-suffix') || '';
                const duration = 2000;
                const startTime = performance.now();

                function animate(currentTime) {
                    const elapsed = currentTime - startTime;
                    const progress = Math.min(elapsed / duration, 1);
                    // Ease out cubic
                    const easeOut = 1 - Math.pow(1 - progress, 3);
                    const current = Math.floor(easeOut * target);
                    el.textContent = prefix + current.toLocaleString('ms-MY') + suffix;

                    if (progress < 1) {
                        requestAnimationFrame(animate);
                    }
                }

                requestAnimationFrame(animate);
                observer.unobserve(el);
            }
        });
    }, { threshold: 0.5 });

    counters.forEach(el => observer.observe(el));
}

/* ============================================
   DELETE CONFIRMATION
   ============================================ */
function initDeleteConfirm() {
    document.querySelectorAll('[data-confirm-delete]').forEach(btn => {
        btn.addEventListener('click', (e) => {
            if (!confirm('Adakah anda pasti mahu memadam item ini?')) {
                e.preventDefault();
            }
        });
    });
}

/* ============================================
   PASSWORD VISIBILITY TOGGLE
   ============================================ */
function initPasswordToggle() {
    document.querySelectorAll('[data-toggle-password]').forEach(btn => {
        btn.addEventListener('click', () => {
            const targetId = btn.getAttribute('data-toggle-password');
            const input = document.getElementById(targetId);
            if (!input) return;

            if (input.type === 'password') {
                input.type = 'text';
                btn.innerHTML = `<svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path></svg>`;
            } else {
                input.type = 'password';
                btn.innerHTML = `<svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>`;
            }
        });
    });
}

/* ============================================
   SEARCH INPUT FOCUS SHORTCUT
   ============================================ */
function initSearchFocus() {
    document.addEventListener('keydown', (e) => {
        // Ctrl+K or Cmd+K to focus search
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            const searchInput = document.querySelector('.search-global');
            if (searchInput) searchInput.focus();
        }
    });
}
