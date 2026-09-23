(function () {
    'use strict';

    const menuButton = document.getElementById('adminMenuButton');
    const sidebar = document.getElementById('adminSidebar');

    if (!sidebar) {
        return;
    }

    const sidebarScrollHash = 'admin-sidebar-scroll';
    const restoreSidebarScroll = function () {
        const hash = window.location.hash.replace(/^#/, '');
        const prefix = sidebarScrollHash + '=';

        if (!hash.startsWith(prefix)) {
            return;
        }

        const scrollTop = Number.parseInt(hash.slice(prefix.length), 10);
        if (Number.isFinite(scrollTop) && scrollTop > 0) {
            sidebar.scrollTop = scrollTop;
        }

        window.history.replaceState(null, document.title, window.location.pathname + window.location.search);
    };

    restoreSidebarScroll();

    if (!menuButton) {
        return;
    }

    menuButton.addEventListener('click', function () {
        const isOpen = sidebar.classList.toggle('sidebar-open');
        menuButton.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });

    sidebar.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', function () {
            if (sidebar.scrollTop > 0) {
                const targetUrl = new URL(link.href, window.location.href);
                targetUrl.hash = sidebarScrollHash + '=' + Math.round(sidebar.scrollTop);
                link.href = targetUrl.href;
            }

            if (window.innerWidth <= 850) {
                sidebar.classList.remove('sidebar-open');
                menuButton.setAttribute('aria-expanded', 'false');
            }
        });
    });

    window.addEventListener('resize', function () {
        if (window.innerWidth > 850) {
            sidebar.classList.remove('sidebar-open');
            menuButton.setAttribute('aria-expanded', 'false');
        }
    });
}());
