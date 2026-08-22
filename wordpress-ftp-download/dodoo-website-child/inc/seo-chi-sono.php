<?php
/**
 * SEO override per pagina "Chi Sono" (ID 101)
 * Ottimizza title tag e meta description per personal branding Rosario Giordano
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Override title tag per pagina Chi Sono
 */
function dw_chi_sono_custom_title($title) {
    global $post;
    
    if (is_page('chi-sono') || (is_singular() && !empty($post) && $post->ID === 101)) {
        return 'Rosario Giordano - Sysadmin & Cybersecurity Expert | Dodoo.it';
    }
    return $title;
}
add_filter('wp_title', 'dw_chi_sono_custom_title', 10, 2);

/**
 * Override document title parts (WordPress 4.1+)
 */
function dw_chi_sono_custom_title_parts($title) {
    global $post;
    
    if (is_page('chi-sono') || (is_singular() && !empty($post) && $post->ID === 101)) {
        $title['title'] = 'Rosario Giordano - Sysadmin & Cybersecurity Expert';
        $title['site'] = 'Dodoo.it';
    }
    return $title;
}
add_filter('document_title_parts', 'dw_chi_sono_custom_title_parts');

/**
 * Override meta description per pagina Chi Sono
 * Priorità alta per sovrascrivere sia Rank Math che custom theme functions
 */
function dw_chi_sono_meta_description_override($description) {
    global $post;
    
    if (is_page('chi-sono') || (is_singular() && !empty($post) && $post->ID === 101)) {
        return 'Rosario Giordano, IT Engineer e Senior Sysadmin con 20+ anni di esperienza in produzione. Esperto di Linux, Cybersecurity, Cloud, Database e Automazione. Guide pratiche basate su esperienza reale.';
    }
    return $description;
}

// Hook per Rank Math
add_filter('rank_math/frontend/description', 'dw_chi_sono_meta_description_override', 20);

// Hook per Yoast SEO
add_filter('wpseo_metadesc', 'dw_chi_sono_meta_description_override', 20);

// Override per la funzione custom del theme
if (function_exists('dodoo_get_meta_description')) {
    // Creiamo un wrapper che controlla prima la pagina Chi Sono
    function dw_chi_sono_wrapper_description() {
        global $post;
        
        if (is_page('chi-sono') || (is_singular() && !empty($post) && $post->ID === 101)) {
            return 'Rosario Giordano, IT Engineer e Senior Sysadmin con 20+ anni di esperienza in produzione. Esperto di Linux, Cybersecurity, Cloud, Database e Automazione. Guide pratiche basate su esperienza reale.';
        }
        return dodoo_get_meta_description();
    }
    
    // Sostituiamo la funzione originale con il nostro wrapper
    // Questo funziona perché dodoo_seo_meta_tags chiama dodoo_get_meta_description()
    if (function_exists('dodoo_seo_meta_tags')) {
        // Usiamo un hook wp_head ad alta priorità per emettere meta tag direttamente
        function dw_chi_sono_direct_meta_output() {
            global $post;
            
            if (is_page('chi-sono') || (is_singular() && !empty($post) && $post->ID === 101)) {
                echo '<meta name="description" content="Rosario Giordano, IT Engineer e Senior Sysadmin con 20+ anni di esperienza in produzione. Esperto di Linux, Cybersecurity, Cloud, Database e Automazione. Guide pratiche basate su esperienza reale.">' . "\n";
                echo '<meta name="author" content="Rosario Giordano">' . "\n";
                
                // Emettiamo anche OG e Twitter Card override
                echo '<meta property="og:title" content="Rosario Giordano - Sysadmin & Cybersecurity Expert">' . "\n";
                echo '<meta property="og:description" content="Rosario Giordano, IT Engineer e Senior Sysadmin con 20+ anni di esperienza in produzione. Esperto di Linux, Cybersecurity, Cloud, Database e Automazione.">' . "\n";
                echo '<meta name="twitter:title" content="Rosario Giordano - Sysadmin & Cybersecurity Expert">' . "\n";
                echo '<meta name="twitter:description" content="Rosario Giordano, IT Engineer e Senior Sysadmin con 20+ anni di esperienza in produzione. Esperto di Linux, Cybersecurity, Cloud, Database e Automazione.">' . "\n";
            }
        }
        add_action('wp_head', 'dw_chi_sono_direct_meta_output', 0); // Priorità massima
    }
}
