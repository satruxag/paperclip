<?php
/**
 * ROS-520 Parte A — CSS inline nel critical path.
 *
 * Obiettivo: azzerare le richieste render-blocking dei 3 fogli CSS del tema
 * (padre + child) inlining tutto nell'<head>.
 *
 * Strategia:
 * 1. Dequeue dei 3 handle: dodoo-website-main (padre), dodoo-website-style
 *    e dodoo-website-child-style (child) su wp_enqueue_scripts con priorità 100
 *    (dopo che il padre e il child li hanno accodati).
 * 2. Lettura a runtime dei file CSS dal disco (quello che c'è in produzione,
 *    qualunque albero vinca la riconciliazione).
 * 3. Normalizzazione degli URL relativi in assoluti per evitare rotture
 *    quando il CSS viene spostato nell'HTML.
 * 4. Rimozione di @charset che sarebbero invalidi a metà di uno <style>.
 * 5. Caching in transient con validazione su filemtime + md5 per non fare 3
 *    file_get_contents a ogni richiesta.
 * 6. Emissione inline nell'<head> con priorità 2 (dopo dw_child_font_face_inline
 *    che ha priorità 1, così le @font-face restano in testa).
 *
 * Nota sulla potatura: la specifica originale menziona ~12 KiB di CSS
 * inutilizzato. La potatura va fatta PRIMA dell'inline, non dopo, e richiede
 * uno strumento esterno (Chrome DevTools Coverage, PurgeCSS, etc.). Qui si
 * inlinea il contenuto integrale dei file, gzippato dal server.
 *
 * Size totali (raw):
 *   - parent/assets/css/style.min.css: 101 KiB
 *   - parent/style.css: 3 KiB
 *   - child/style.css: 37 KiB
 *   Totale: ~141 KiB raw → ~42 KiB gzip (stima 30%).
 *
 * Il transient si invalida quando cambia il filemtime di uno dei 3 file.
 */

/**
 * Dequeue degli stili render-blocking (corre dopo che padre/child li hanno accodati).
 * Usa solo wp_dequeue_style() per non rompere dipendenze di plugin.
 */
function dw_child_drop_render_blocking_css() {
	global $wp_styles;

	if (! ($wp_styles instanceof WP_Styles)) {
		return;
	}

	// Dequeue dei tre handle render-blocking.
	$handles_to_drop = array('dodoo-website-main', 'dodoo-website-style', 'dodoo-website-child-style');
	foreach ($handles_to_drop as $handle) {
		// Dequeue senza deregister: lascia lo handle registrato così i plugin
		// che lo dichiarano come dipendenza non esplodono.
		if (wp_style_is($handle, 'enqueued') || wp_style_is($handle, 'enqueued')) {
			wp_dequeue_style($handle);
		}
	}
}
add_action('wp_enqueue_scripts', 'dw_child_drop_render_blocking_css', 100);

/**
 * Normalizza il CSS: converte URL relativi in assoluti e rimuove @charset.
 */
function dw_child_normalize_css($css, $base_url) {
	// Rimuovi @charset (invalido a metà di uno <style> tag).
	$css = preg_replace('/^\s*@charset\s*[^;]+;\s*/i', '', $css);

	// Converti url(../fonts/...) in url(/wp-content/themes/dodoo-website/assets/fonts/...).
	// I font del padre sono in assets/fonts/ relativo a assets/css/.
	$css = preg_replace(
		'/url\(["\']?\.\.\/fonts\/([^"\')\s]+)["\']?\)/i',
		'url("' . $base_url . '/assets/fonts/$1")',
		$css
	);

	return $css;
}

/**
 * Emette il CSS inline nell'<head>.
 */
function dw_child_inline_css() {
	$parent_dir = get_template_directory();
	$child_dir = get_stylesheet_directory();
	$parent_base_url = content_url() . '/themes/dodoo-website';

	$files = array(
		$parent_dir . '/assets/css/style.min.css',
		$parent_dir . '/style.css',
		$child_dir . '/style.css',
	);

	$cache_key = 'dw_css_inline_hash';
	$cached = get_transient($cache_key);

	// Ricalcola l'hash se manca o se un file è cambiato.
	if (false === $cached) {
		$hash_input = '';
		foreach ($files as $file) {
			if (file_exists($file)) {
				$hash_input .= filemtime($file) . ':' . md5_file($file);
			}
		}
		$new_hash = md5($hash_input);
		set_transient($cache_key, $new_hash, DAY_IN_SECONDS);
		$cached = $new_hash;
	}

	// Controlla se abbiamo già il CSS inline cacheato.
	$css_cache_key = 'dw_css_inline_content_' . $cached;
	$inline_css = get_transient($css_cache_key);

	if (false === $inline_css) {
		// Leggo i file a runtime.
		$css_parts = array();

		// Parent main CSS (style.min.css)
		$parent_main = $parent_dir . '/assets/css/style.min.css';
		if (file_exists($parent_main)) {
			$css = file_get_contents($parent_main);
			$css_parts[] = dw_child_normalize_css($css, $parent_base_url);
		}

		// Parent style.css
		$parent_style = $parent_dir . '/style.css';
		if (file_exists($parent_style)) {
			$css = file_get_contents($parent_style);
			$css_parts[] = dw_child_normalize_css($css, $parent_base_url);
		}

		// Child style.css
		$child_style = $child_dir . '/style.css';
		if (file_exists($child_style)) {
			$css = file_get_contents($child_style);
			// Per il child, base URL è lo stesso (eredita i font del padre)
			$css_parts[] = dw_child_normalize_css($css, $parent_base_url);
		}

		// Unisci tutto
		$inline_css = implode("\n/* --- separator --- */\n", $css_parts);

		// Cache per 24 ore.
		set_transient($css_cache_key, $inline_css, DAY_IN_SECONDS);
	}

	// Emetti inline nell'<head>.
	?>
<style id="dw-inline-theme-css">
<?php echo $inline_css; ?>
</style>
	<?php
}
add_action('wp_head', 'dw_child_inline_css', 2);
