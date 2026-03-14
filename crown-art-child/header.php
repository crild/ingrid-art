<?php
/**
 * Crown Art Child Theme Header Override
 *
 * This file adds the language switcher and social links to the header.
 * It loads the parent theme's header and injects the custom elements.
 *
 * NOTE: For most Crown Art installations, modifying the header is better
 * done through the Theme Options panel (Appearance > Customize > Header).
 * This file is provided as a fallback for elements the theme options
 * don't support (like the Polylang flag switcher).
 *
 * IMPORTANT: After a Crown Art theme update, check if the parent header.php
 * has changed and update this file accordingly.
 *
 * @package CrownArtChild
 */

// Load parent header
get_template_part('templates/header', 'default');
?>

<?php
// Add language switcher after header loads
// This gets injected via JavaScript since modifying the parent header
// template directly is fragile across theme updates.
?>
<script>
(function() {
    'use strict';

    function injectLanguageSwitcher() {
        // Find the header menu area
        var menuContainer = document.querySelector('.sc_layouts_row_type_compact .sc_layouts_column:last-child')
            || document.querySelector('.top_panel .menu_main_nav_area')
            || document.querySelector('.sc_layouts_menu');

        if (!menuContainer) return;

        // Check if switcher already exists
        if (document.querySelector('.pf-lang-switcher')) return;

        // Try to use the PHP-rendered shortcode output first
        var phpSwitcher = document.querySelector('[data-pf-lang-switcher]');
        if (phpSwitcher) {
            menuContainer.appendChild(phpSwitcher);
            return;
        }

        // Fallback: Create switcher with Polylang's data attributes
        var switcher = document.createElement('div');
        switcher.className = 'pf-lang-switcher';

        // If Polylang provides language data
        var langItems = document.querySelectorAll('.lang-item');
        if (langItems.length > 0) {
            langItems.forEach(function(item) {
                var link = item.querySelector('a');
                if (link) {
                    var flag = document.createElement('a');
                    flag.href = link.href;
                    flag.className = item.classList.contains('current-lang') ? 'lang-flag current-lang' : 'lang-flag';
                    flag.title = link.textContent;

                    var img = document.createElement('img');
                    var slug = item.classList.contains('lang-item-nb') || item.classList.contains('lang-item-no') ? 'no' : 'en';
                    img.src = '<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/flags/' + slug + '.svg';
                    img.alt = link.textContent;
                    img.width = 24;
                    img.height = 16;

                    flag.appendChild(img);
                    switcher.appendChild(flag);
                }
            });
        }

        if (switcher.children.length > 0) {
            menuContainer.appendChild(switcher);
        }
    }

    // Run on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', injectLanguageSwitcher);
    } else {
        injectLanguageSwitcher();
    }
})();
</script>
