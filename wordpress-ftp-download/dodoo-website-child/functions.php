<?php
/**
 * dodoo-website-child functions.
 * Non modifica mai il tema padre (dodoo-website / Divi): solo enqueue e hook.
 */

defined( 'ABSPATH' ) || exit;

/**
 * Enqueue stile parent (Divi) + stile child, in coda per non alterare la cascata.
 *
 * ROS-520 Parte A: questi enqueue sono ora gestiti da inc/css-inline.php
 * (inlining nell'<head> con dequeue degli handle render-blocking).
 * Questa funzione resta per eventuali stili futuri che non devono essere inline.
 */
function dw_child_enqueue_styles() {
	// ROS-520 Parte A: i tre handle render-blocking (dodoo-website-main,
	// dodoo-website-style, dodoo-website-child-style) sono dequeueati e
	// inlinati da inc/css-inline.php. Questa funzione non li re-acquisisce.
	// Lascia spazio per eventuali stili futuri non-inline.
}
add_action( 'wp_enqueue_scripts', 'dw_child_enqueue_styles', 20 );

/**
 * ROS-520 — Font self-hosted.
 *
 * Emette inline nel <head> le @font-face di Inter (variabile, sottoinsiemi
 * latin e latin-ext) piu' il preload del solo sottoinsieme latin, che e'
 * l'unico usato above-the-fold sulle pagine it/en/es.
 *
 * Perche' inline in wp_head e non dentro style.css:
 * - le URL sono assolute, quindi restano valide anche quando il CSS del tema
 *   verra' inlineato nell'head (ROS-520 parte A), dove un url() relativo si
 *   risolverebbe contro l'URL del documento e romperebbe il font;
 * - la richiesta del woff2 parte subito, senza attendere il download e il
 *   parsing del foglio di stile.
 *
 * JetBrains Mono non e' dichiarato qui: la @font-face del parent
 * (assets/css/style.css) e' gia' corretta e self-hosted.
 */
function dw_child_font_face_inline() {
	$fonts = get_stylesheet_directory_uri() . '/fonts';
	?>
<link rel="preload" href="<?php echo esc_url( $fonts . '/inter-var-latin.woff2' ); ?>" as="font" type="font/woff2" crossorigin>
<style id="dw-child-fonts">
@font-face{font-family:'Inter';font-style:normal;font-weight:100 900;font-display:swap;src:url('<?php echo esc_url( $fonts . '/inter-var-latin.woff2' ); ?>') format('woff2');unicode-range:U+0000-00FF,U+0131,U+0152-0153,U+02BB-02BC,U+02C6,U+02DA,U+02DC,U+0304,U+0308,U+0329,U+2000-206F,U+20AC,U+2122,U+2191,U+2193,U+2212,U+2215,U+FEFF,U+FFFD}
@font-face{font-family:'Inter';font-style:normal;font-weight:100 900;font-display:swap;src:url('<?php echo esc_url( $fonts . '/inter-var-latin-ext.woff2' ); ?>') format('woff2');unicode-range:U+0100-02BA,U+02BD-02C5,U+02C7-02CC,U+02CE-02D7,U+02DD-02FF,U+0304,U+0308,U+0329,U+1D00-1DBF,U+1E00-1E9F,U+1EF2-1EFF,U+2020,U+20A0-20AB,U+20AD-20C0,U+2113,U+2C60-2C7F,U+A720-A7FF}
</style>
	<?php
}
add_action( 'wp_head', 'dw_child_font_face_inline', 1 );

/**
 * ROS-520 — Rete di sicurezza: se un plugin, il parent o una versione
 * non allineata del tema rimette in coda un CSS di Google Fonts, lo toglie.
 * Non tocca gli altri stili.
 */
function dw_child_drop_google_fonts() {
	global $wp_styles;

	if ( ! ( $wp_styles instanceof WP_Styles ) ) {
		return;
	}

	foreach ( $wp_styles->registered as $handle => $style ) {
		if ( ! empty( $style->src ) && strpos( $style->src, 'fonts.googleapis.com' ) !== false ) {
			wp_dequeue_style( $handle );
			wp_deregister_style( $handle );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'dw_child_drop_google_fonts', 100 );

/**
 * Include dei moduli funzionali del child theme (uno per feature del brief).
 */
require_once get_stylesheet_directory() . '/inc/css-inline.php';  // ROS-520 Parte A
require_once get_stylesheet_directory() . '/inc/homepage-hero.php';
require_once get_stylesheet_directory() . '/inc/category-nav.php';
require_once get_stylesheet_directory() . '/inc/services-cta.php';
require_once get_stylesheet_directory() . '/inc/chi-sono.php';
require_once get_stylesheet_directory() . '/inc/dark-mode.php';
require_once get_stylesheet_directory() . '/inc/seo-chi-sono.php';

/*
 * SEO pagina "Chi Sono" — implementazione unica in inc/seo-chi-sono.php,
 * incluso dal require_once qui sopra.
 *
 * Qui esisteva un secondo blocco che ridichiarava dw_chi_sono_custom_title()
 * e dw_chi_sono_custom_title_parts(), gia' definite in quel file: PHP muore
 * con "Cannot redeclare function" e WordPress serve la pagina di errore
 * critico. E' successo davvero in produzione durante ROS-520, rilevato e
 * ripristinato nel giro di pochi minuti.
 *
 * `php -l` non intercetta questo caso: controlla un file per volta e le due
 * dichiarazioni erano in file diversi. Serve un controllo sui nomi di
 * funzione duplicati tra i file caricati insieme.
 *
 * La versione in inc/seo-chi-sono.php e' un sovrainsieme di quella rimossa:
 * stessi override di title e meta description, in piu' il match sull'ID 101
 * oltre allo slug e gli override di Open Graph e Twitter Card.
 */

/**
 * ROS-529 — Blocchi recuperati dalla produzione.
 *
 * Quanto segue era live su www.dodoo.it ma non risultava in nessun commit di
 * questo repository (verificato con `git log --all -S` su ogni nome di
 * funzione: zero occorrenze). E' stato riportato qui prima di qualunque
 * upload, perche' un deploy del repo cosi' com'era lo avrebbe cancellato.
 *
 * Origine: ROS-141 (preconnect + preload font) e ROS-401 (title homepage).
 */

/*
 * ROS-141 — dw_child_preload_fonts() NON viene reintrodotta, di proposito.
 *
 * In produzione i preload dei font del parent sono emessi da tre punti
 * diversi (child/functions.php, parent/inc/performance.php e
 * parent/inc/seo.php), ed e' il motivo per cui l'HTML live contiene
 * fjalla-one-400.woff2 e outfit-var.woff2 duplicati.
 *
 * La copertura resta completa senza il blocco del child: nel repo
 * dodoo_performance_hints() (parent/inc/seo.php, hook wp_head priorita' 0)
 * gia' preloada Fjalla One e Outfit, cioe' i due font dei titoli
 * above-the-fold.
 *
 * jetbrains-mono-var.woff2 non viene piu' preloadato da nessuno: e' il
 * monospace dei blocchi di codice, che above-the-fold non compare. Il
 * preload gli faceva occupare banda in concorrenza con l'LCP.
 */

/**
 * ROS-141 + ROS-520 parte C — Preconnect, ridotti da 5 origini a 2.
 *
 * Rimossi perche' ora sono connessioni verso domini che la pagina non
 * contatta piu': fonts.googleapis.com e fonts.gstatic.com (Inter e'
 * self-hosted dalla parte B, il parent self-hosta gli altri font).
 * Rimosso anche secure.gravatar.com: gli avatar non compaiono
 * above-the-fold, quindi occupava uno slot di connessione nel momento
 * peggiore senza anticipare nulla di critico.
 *
 * Restano le due origini che vengono davvero contattate presto dal tag
 * di analytics. Il JS di GTM resta fuori scope per ROS-517.
 */
function dw_child_preconnect_hints() {
	?>
	<link rel="preconnect" href="https://www.googletagmanager.com">
	<link rel="preconnect" href="https://www.google-analytics.com">
	<?php
}
add_action( 'wp_head', 'dw_child_preconnect_hints', 1 );

/**
 * ROS-401 — Title tag della homepage, da ~95 a ~60 caratteri.
 *
 * Riportato dalla produzione senza modifiche funzionali: il comportamento
 * live va preservato tale e quale finche' ROS-401 non decide altrimenti.
 * Vedi la nota su document_title_parts nel commento di dw_child_rankmath_title().
 */
function dw_child_optimize_home_title($title) {
    if (is_front_page()) {
        $title = 'Consulente Sysadmin & Cybersecurity | Rosario Giordano | Dodoo.it';
    }
    return $title;
}
add_filter('pre_get_document_title', 'dw_child_optimize_home_title', -9999);

/**
 * ROS-401 — Filtro specifico per RankMath.
 *
 * NOTA (rilevata durante ROS-529, non corretta qui di proposito): questa
 * funzione e' agganciata anche a 'document_title_parts', che passa e si
 * aspetta un array, mentre in homepage restituisce una stringa. E' un
 * comportamento gia' live: correggerlo dentro ROS-520 significherebbe
 * cambiare in silenzio l'output SEO di un altro ticket. Segnalato a ROS-401.
 */
function dw_child_rankmath_title($title) {
    // Controllo homepage via REQUEST_URI
    $request_uri = $_SERVER['REQUEST_URI'] ?? '/';
    $parsed = parse_url($request_uri);
    $path = $parsed['path'] ?? '/';

    // Homepage: path vuoto, '/', o '?parametri' senza path
    $is_home = ($path === '' || $path === '/' || $path === '/index.php');

    if ($is_home) {
        $new_title = 'Consulente Sysadmin & Cybersecurity | Rosario Giordano | Dodoo.it';
        return $new_title;
    }
    return $title;
}
// Priorità massima su tutti i filter di title
add_filter('rank_math/frontend/title', 'dw_child_rankmath_title', -9999, 1);
add_filter('rank_math/title', 'dw_child_rankmath_title', -9999, 1);
add_filter('pre_get_document_title', 'dw_child_rankmath_title', -9999, 1);
add_filter('document_title_parts', 'dw_child_rankmath_title', -9999, 1);
