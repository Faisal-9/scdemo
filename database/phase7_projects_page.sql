USE statecorps_db;

/*
 * Phase 7: project listing-page hero content.
 *
 * The current static site keeps $projecthero separate from $projects.
 * These settings preserve that content in MySQL before the public page
 * starts reading from the database.
 */

INSERT INTO site_settings
    (setting_key, setting_value, setting_type, description)
VALUES
    (
        'projects_hero_background',
        'assets/images/slider_04.jpg',
        'image',
        'Projects page hero background image'
    ),
    (
        'projects_hero_title',
        'Turning Ambition Into <span>Lasting</span> Impact',
        'text',
        'Projects page hero title; existing frontend intentionally renders this as HTML'
    ),
    (
        'projects_hero_subtitle',
        'Delivering infrastructure, power & energy, mining, and development projects across regions.',
        'textarea',
        'Projects page hero subtitle'
    ),
    (
        'projects_hero_stat_1_count',
        '100+',
        'text',
        'Projects hero statistic 1 value'
    ),
    (
        'projects_hero_stat_1_label',
        'Completed Projects',
        'text',
        'Projects hero statistic 1 label'
    ),
    (
        'projects_hero_stat_2_count',
        '100%',
        'text',
        'Projects hero statistic 2 value'
    ),
    (
        'projects_hero_stat_2_label',
        'On Time Delivery',
        'text',
        'Projects hero statistic 2 label'
    ),
    (
        'projects_hero_stat_3_count',
        '99% +',
        'text',
        'Projects hero statistic 3 value'
    ),
    (
        'projects_hero_stat_3_label',
        'Accuracy',
        'text',
        'Projects hero statistic 3 label'
    );
