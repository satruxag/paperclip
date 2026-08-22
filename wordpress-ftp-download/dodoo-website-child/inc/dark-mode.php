<?php
/**
 * Step 7 del brief (opzionale): dark mode toggle.
 *
 * Le custom properties per .dw-dark esistono già in style.css (§1). Qui
 * manca solo il meccanismo: pulsante toggle + persistenza in localStorage,
 * applicata a <html> il prima possibile per evitare flash del tema sbagliato.
 */

defined( 'ABSPATH' ) || exit;

/**
 * Script inline nell'<head>, prima del CSS: legge la preferenza salvata (o
 * quella di sistema al primo accesso) e applica subito .dw-dark su <html>.
 * Eseguito inline (non come file esterno) per evitare qualunque flash.
 */
function dw_dark_mode_early_apply() {
	?>
	<script>
	(function () {
		try {
			var stored = localStorage.getItem( 'dw-theme' );
			var dark = stored ? stored === 'dark' : window.matchMedia( '(prefers-color-scheme: dark)' ).matches;
			if ( dark ) {
				document.documentElement.classList.add( 'dw-dark' );
			}
		} catch ( e ) {}
	})();
	</script>
	<?php
}
add_action( 'wp_head', 'dw_dark_mode_early_apply', 1 );

/**
 * Markup del pulsante toggle: fisso in alto a destra, sopra tutto il resto.
 */
function dw_dark_mode_toggle_markup() {
	ob_start();
	?>
	<button type="button" class="dw-dark-toggle" id="dw-dark-toggle" aria-label="Attiva/disattiva tema scuro" aria-pressed="false">
		<span class="dw-dark-toggle-icon" aria-hidden="true">🌙</span>
	</button>
	<script>
	(function () {
		var btn = document.getElementById( 'dw-dark-toggle' );
		var html = document.documentElement;
		if ( ! btn ) {
			return;
		}
		function sync() {
			var isDark = html.classList.contains( 'dw-dark' );
			btn.setAttribute( 'aria-pressed', isDark ? 'true' : 'false' );
			btn.querySelector( '.dw-dark-toggle-icon' ).textContent = isDark ? '☀️' : '🌙';
		}
		sync();
		btn.addEventListener( 'click', function () {
			html.classList.toggle( 'dw-dark' );
			try {
				localStorage.setItem( 'dw-theme', html.classList.contains( 'dw-dark' ) ? 'dark' : 'light' );
			} catch ( e ) {}
			sync();
		} );
	})();
	</script>
	<?php
	return ob_get_clean();
}
add_shortcode( 'dw_dark_toggle', 'dw_dark_mode_toggle_markup' );

/**
 * Stampa il pulsante subito dopo <body>, su tutte le pagine. Priorità 4:
 * prima del dropdown categorie (priorità 5), stacking indipendente
 * (position: fixed) quindi l'ordine nel DOM non incide sul layout visivo.
 */
function dw_print_dark_mode_toggle() {
	if ( is_admin() ) {
		return;
	}
	echo dw_dark_mode_toggle_markup();
}
add_action( 'wp_body_open', 'dw_print_dark_mode_toggle', 4 );
