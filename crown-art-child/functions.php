<?php
/**
 * Crown Art Child Theme — Paint & Fun Norway
 *
 * @package CrownArtChild
 */

// Enqueue parent and child styles
add_action('wp_enqueue_scripts', 'crown_art_child_enqueue_styles');
function crown_art_child_enqueue_styles() {
    // Parent theme style
    wp_enqueue_style(
        'crown-art-parent-style',
        get_template_directory_uri() . '/style.css'
    );

    // Child theme style
    wp_enqueue_style(
        'crown-art-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('crown-art-parent-style'),
        wp_get_theme()->get('Version')
    );

    // Google Fonts — Cormorant Garamond + Inter
    wp_enqueue_style(
        'pf-google-fonts',
        'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Inter:wght@300;400;500&display=swap',
        array(),
        null
    );
}

// ── Polylang Language Switcher Shortcode ──
// Usage: [pf_language_switcher]
// Renders flag-based language toggle buttons
add_shortcode('pf_language_switcher', 'pf_language_switcher_shortcode');
function pf_language_switcher_shortcode() {
    if (!function_exists('pll_the_languages')) {
        return '<!-- Polylang not active -->';
    }

    $languages = pll_the_languages(array(
        'show_flags'  => 0,
        'show_names'  => 0,
        'echo'        => 0,
        'raw'         => 1,
    ));

    if (empty($languages)) {
        return '';
    }

    $flag_map = array(
        'nb' => 'no',
        'nn' => 'no',
        'no' => 'no',
        'en' => 'en',
    );

    $output = '<div class="pf-lang-switcher">';
    foreach ($languages as $lang) {
        $slug = $lang['slug'];
        $flag_file = isset($flag_map[$slug]) ? $flag_map[$slug] : $slug;
        $flag_url = get_stylesheet_directory_uri() . '/assets/flags/' . $flag_file . '.svg';
        $current_class = $lang['current_lang'] ? ' current-lang' : '';
        $output .= sprintf(
            '<a href="%s" class="lang-flag%s" title="%s" hreflang="%s"><img src="%s" alt="%s" width="24" height="16"></a>',
            esc_url($lang['url']),
            esc_attr($current_class),
            esc_attr($lang['name']),
            esc_attr($slug),
            esc_url($flag_url),
            esc_attr($lang['name'])
        );
    }
    $output .= '</div>';

    return $output;
}

// ── Copy flag SVGs to child theme assets ──
// The flags should be placed in crown-art-child/assets/flags/
// They're served from the child theme directory

// ── Add hreflang tags for SEO ──
add_action('wp_head', 'pf_add_hreflang_tags');
function pf_add_hreflang_tags() {
    if (!function_exists('pll_the_languages')) {
        return;
    }

    $languages = pll_the_languages(array(
        'raw'  => 1,
        'echo' => 0,
    ));

    if (empty($languages)) {
        return;
    }

    foreach ($languages as $lang) {
        $hreflang = $lang['slug'] === 'nb' ? 'nb-NO' : 'en';
        printf(
            '<link rel="alternate" hreflang="%s" href="%s" />' . "\n",
            esc_attr($hreflang),
            esc_url($lang['url'])
        );
    }
}

// ── Schema.org structured data ──
add_action('wp_head', 'pf_schema_org_data');
function pf_schema_org_data() {
    // Only on the front page
    if (!is_front_page()) {
        return;
    }

    $schema = array(
        '@context' => 'https://schema.org',
        '@graph'   => array(
            array(
                '@type'       => 'LocalBusiness',
                '@id'         => 'https://www.paintandfun.no/#business',
                'name'        => 'Paint & Fun Norway',
                'description' => 'Creative art experiences, painting courses, and art instruction in Son, Vestby, Norway.',
                'url'         => 'https://www.paintandfun.no/',
                'address'     => array(
                    '@type'           => 'PostalAddress',
                    'addressLocality' => 'Son, Vestby',
                    'addressCountry'  => 'NO',
                ),
                'sameAs' => array(
                    'https://www.facebook.com/ingrid.rutherford.10/',
                    'https://www.instagram.com/ingrid_rutherford/',
                    'https://www.vestbykunstforening.no/author/ingridr/',
                ),
            ),
            array(
                '@type'  => 'Person',
                '@id'    => 'https://www.paintandfun.no/#artist',
                'name'   => 'Ingrid Amuri Rutherford',
                'jobTitle' => 'Visual Artist & Art Instructor',
                'url'    => 'https://www.paintandfun.no/',
                'sameAs' => array(
                    'https://www.facebook.com/ingrid.rutherford.10/',
                    'https://www.instagram.com/ingrid_rutherford/',
                ),
                'worksFor' => array(
                    '@id' => 'https://www.paintandfun.no/#business',
                ),
                'memberOf' => array(
                    '@type' => 'Organization',
                    'name'  => 'Vestby Kunstforening',
                    'url'   => 'https://www.vestbykunstforening.no/',
                ),
            ),
        ),
    );

    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . '</script>' . "\n";
}

// ── Add social media links to header ──
// This can be configured via Appearance > Customize in Crown Art,
// but we add a fallback widget area
add_action('widgets_init', 'pf_register_header_widget');
function pf_register_header_widget() {
    register_sidebar(array(
        'name'          => 'Header Social Links',
        'id'            => 'header-social',
        'description'   => 'Social media links in the header bar',
        'before_widget' => '<div class="header-social-widget">',
        'after_widget'  => '</div>',
    ));
}
