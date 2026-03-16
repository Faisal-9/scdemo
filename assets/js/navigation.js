document.addEventListener('DOMContentLoaded', function () {

    const mobileToggle = document.querySelector('.mobile-menu-toggle');
    const navMenu = document.querySelector('.nav-menu');

    if (mobileToggle) {
        mobileToggle.addEventListener('click', function (e) {
            e.stopPropagation();
            this.classList.toggle('active');
            navMenu.classList.toggle('active');
        });
    }

    const dropdownToggles = document.querySelectorAll('.has-dropdown');

    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function (e) {
            if (window.innerWidth <= 768) {
                e.preventDefault();
                const dropdown = this.parentElement.querySelector('.dropdown-menu');
                if (dropdown) dropdown.classList.toggle('active');
            }
        });
    });

    document.addEventListener('click', function (e) {
        if (!e.target.closest('.nav-item')) {
            document.querySelectorAll('.dropdown-menu')
                .forEach(menu => menu.classList.remove('active'));

            if (window.innerWidth <= 768) {
                navMenu.classList.remove('active');
                mobileToggle?.classList.remove('active');
            }
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.dropdown-menu')
                .forEach(menu => menu.classList.remove('active'));
        }
    });

});