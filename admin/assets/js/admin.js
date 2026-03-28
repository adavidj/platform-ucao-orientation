// =================================================================
// UCAO ADMIN — JavaScript Principal
// =================================================================

document.addEventListener('DOMContentLoaded', function() {

    // =================================================================
    // SIDEBAR TOGGLE (Mobile)
    // =================================================================
    const sidebar = document.getElementById('adminSidebar');
    const overlay = document.getElementById('adminOverlay');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarClose = document.getElementById('sidebarClose');

    function openSidebar() {
        sidebar?.classList.add('open');
        overlay?.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        sidebar?.classList.remove('open');
        overlay?.classList.remove('active');
        document.body.style.overflow = '';
    }

    sidebarToggle?.addEventListener('click', openSidebar);
    sidebarClose?.addEventListener('click', closeSidebar);
    overlay?.addEventListener('click', closeSidebar);

    // =================================================================
    // FLASH ALERTS AUTO-DISMISS
    // =================================================================
    const flashAlert = document.getElementById('flashAlert');
    if (flashAlert) {
        setTimeout(() => {
            flashAlert.style.opacity = '0';
            flashAlert.style.transform = 'translateY(-10px)';
            flashAlert.style.transition = 'all 0.4s ease';
            setTimeout(() => flashAlert.remove(), 400);
        }, 5000);
    }

    // =================================================================
    // CONFIRM DELETE
    // =================================================================
    document.querySelectorAll('[data-confirm]').forEach(el => {
        el.addEventListener('click', function(e) {
            const msg = this.getAttribute('data-confirm') || 'Êtes-vous sûr de vouloir effectuer cette action ?';
            if (!confirm(msg)) {
                e.preventDefault();
            }
        });
    });

    // =================================================================
    // MODAL MANAGEMENT
    // =================================================================
    window.openModal = function(modalId) {
        const modal = document.getElementById(modalId);
        const overlay = document.getElementById('adminOverlay');
        if (modal) {
            modal.classList.add('active');
            overlay?.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    };

    window.closeModal = function(modalId) {
        const modal = document.getElementById(modalId);
        const overlay = document.getElementById('adminOverlay');
        if (modal) {
            modal.classList.remove('active');
            overlay?.classList.remove('active');
            document.body.style.overflow = '';
        }
    };

    // Close modals on overlay click
    overlay?.addEventListener('click', function() {
        document.querySelectorAll('.admin-modal.active').forEach(m => m.classList.remove('active'));
        this.classList.remove('active');
        document.body.style.overflow = '';
    });

    // Close modals on Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.admin-modal.active').forEach(m => m.classList.remove('active'));
            overlay?.classList.remove('active');
            closeSidebar();
            document.body.style.overflow = '';
        }
    });

    // =================================================================
    // ANIMATED COUNTERS
    // =================================================================
    document.querySelectorAll('[data-count]').forEach(el => {
        const target = parseInt(el.getAttribute('data-count'));
        const duration = 1500;
        const start = 0;
        const startTime = performance.now();

        function updateCount(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            // Ease out expo
            const eased = progress === 1 ? 1 : 1 - Math.pow(2, -10 * progress);
            const current = Math.floor(start + (target - start) * eased);
            el.textContent = current.toLocaleString('fr-FR');
            if (progress < 1) {
                requestAnimationFrame(updateCount);
            } else {
                el.textContent = target.toLocaleString('fr-FR');
            }
        }

        // Start animation when visible
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    requestAnimationFrame(updateCount);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.3 });

        observer.observe(el);
    });

    // =================================================================
    // TABLE SEARCH
    // =================================================================
    const tableSearch = document.getElementById('tableSearch');
    if (tableSearch) {
        tableSearch.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            const table = this.closest('.admin-card')?.querySelector('.admin-table tbody');
            if (!table) return;
            
            table.querySelectorAll('tr').forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(query) ? '' : 'none';
            });
        });
    }

    // =================================================================
    // SELECT ALL CHECKBOX
    // =================================================================
    const selectAll = document.getElementById('selectAll');
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            document.querySelectorAll('.row-checkbox').forEach(cb => {
                cb.checked = this.checked;
            });
        });
    }

});
