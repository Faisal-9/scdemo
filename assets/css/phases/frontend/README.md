# Frontend CSS phases

`assets/css/styles.css` is the public stylesheet entrypoint loaded by `includes/head.php`. It imports these modules in cascade order:

1. `phase-1-foundation.css` - variables, reset, typography, lightbox, shared animations
2. `phase-1-navigation.css` - public header, navigation, dropdowns, and responsive navigation rules
3. `phase-2-homepage.css` - homepage hero, stats, Why State Corps, services, featured projects, clients, news
4. `phase-3-about.css` - About page, company profile, timeline, clients, certificates, awards, sister companies
5. `phase-4-services-sectors.css` - Services and Expertise/Sectors pages
6. `phase-5-projects.css` - Projects listing, project cards, project details, galleries
7. `phase-6-media.css` - News, events, and gallery media page
8. `phase-7-legal-footer-contact.css` - policies, footer, and contact page
9. `phase-8-responsive.css` - shared responsive rules, kept last to preserve overrides

## Consumers

- `includes/head.php` loads `assets/css/styles.css` for every public page.
- `includes/head.php` also loads `assets/css/navigation.css` for the public header/navigation; that file imports `phase-1-navigation.css` after the main stylesheet, preserving the previous cascade.
- `scadmin/partials/header.php` loads `assets/css/media-picker.css` for the admin media picker; it is not a frontend stylesheet.
- Bootstrap, Font Awesome, Animate.css, Swiper, and Magnific Popup are external/vendor dependencies loaded by `includes/head.php`.

Keep the import order stable unless a deliberate cascade change is being made.
