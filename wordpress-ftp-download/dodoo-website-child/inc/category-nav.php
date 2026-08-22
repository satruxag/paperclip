<?php
/**
 * Step 4 del brief: card categorie + dropdown categorie in navigazione.
 *
 * Il parent theme espone già un blocco nativo "category-grid" in homepage
 * (7 card statiche) e un menu piatto senza dropdown. Nessuno dei due viene
 * riscritto: il primo viene solo restylato via CSS (vedi style.css §3), il
 * secondo viene affiancato — non sostituito — da un pannello dropdown
 * iniettato via `wp_body_open`, popolato con la tassonomia reale (nessuna
 * chiamata REST lato client: elenco calcolato lato server con WP_Query).
 *
 * Bug di dato risolto qui: le voci "AI" e "Automazione" del menu/della
 * category-grid nativi puntano a due categorie vuote (0 post), mentre i 36
 * contenuti reali vivono sotto la categoria distinta "ai-automazione". Il
 * pannello dropdown mostra quindi una sola voce "AI & Automazione" verso
 * /category/ai-automazione/, oltre a "Best Repository" (20 post), assente
 * dalla category-grid nativa.
 */

defined( 'ABSPATH' ) || exit;

/**
 * Elenco curato delle categorie reali (esclude le due vuote ai/automazione
 * e i duplicati di lingua Polylang, che condividono lo stesso slug base).
 */
function dw_real_categories() {
	$slugs = array(
		'cybersecurity'   => 'Cybersecurity',
		'ai-automazione'  => 'AI &amp; Automazione',
		'sysadmin'        => 'Sysadmin',
		'cloud'           => 'Cloud',
		'best-repository' => 'Best Repository',
		'database'        => 'Database',
		'networking'      => 'Networking',
	);

	$items = array();
	foreach ( $slugs as $slug => $label ) {
		$term = get_term_by( 'slug', $slug, 'category' );
		if ( ! $term || is_wp_error( $term ) ) {
			continue;
		}
		$items[] = array(
			'label' => $label,
			'url'   => get_term_link( $term ),
			'count' => (int) $term->count,
		);
	}

	return $items;
}

/**
 * Markup del pannello dropdown categorie (toggle via JS inline, CSP-safe).
 */
function dw_categories_dropdown_markup() {
	$categories = dw_real_categories();
	if ( empty( $categories ) ) {
		return '';
	}

	ob_start();
	?>
	<div class="dw-cat-nav">
		<button type="button" class="dw-cat-nav-toggle" id="dw-cat-nav-toggle" aria-expanded="false" aria-controls="dw-cat-dropdown" aria-label="<?php echo esc_attr( dodoo_t( 'Filtra per categoria', 'Filter by category', 'Filtrar por categoría' ) ); ?>">
			Categorie <span class="dw-cat-nav-caret" aria-hidden="true">▾</span>
		</button>
		<div class="dw-cat-dropdown" id="dw-cat-dropdown" hidden>
			<div class="dw-cat-dropdown-grid">
				<?php foreach ( $categories as $cat ) : ?>
					<a class="dw-cat-dropdown-card" href="<?php echo esc_url( $cat['url'] ); ?>">
						<span class="dw-cat-dropdown-name"><?php echo wp_kses_post( $cat['label'] ); ?></span>
						<span class="dw-cat-dropdown-count"><?php echo esc_html( $cat['count'] ); ?> articoli</span>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
	<script>
	(function () {
		var toggle = document.getElementById( 'dw-cat-nav-toggle' );
		var panel = document.getElementById( 'dw-cat-dropdown' );
		if ( ! toggle || ! panel ) {
			return;
		}
		toggle.addEventListener( 'click', function () {
			var open = toggle.getAttribute( 'aria-expanded' ) === 'true';
			toggle.setAttribute( 'aria-expanded', open ? 'false' : 'true' );
			panel.hidden = open;
		} );
		document.addEventListener( 'click', function ( e ) {
			if ( ! panel.contains( e.target ) && e.target !== toggle ) {
				toggle.setAttribute( 'aria-expanded', 'false' );
				panel.hidden = true;
			}
		} );
	})();
	</script>
	<?php
	return ob_get_clean();
}
add_shortcode( 'dw_cat_nav', 'dw_categories_dropdown_markup' );

/**
 * Stampa il pannello dropdown subito dopo <body>, su tutte le pagine
 * (non solo la home): posizionato via CSS sotto l'header del parent.
 */
function dw_print_categories_dropdown() {
	if ( is_admin() ) {
		return;
	}
	echo dw_categories_dropdown_markup();
}
add_action( 'wp_body_open', 'dw_print_categories_dropdown', 5 );
