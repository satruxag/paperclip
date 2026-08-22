<?php
/**
 * Step 2 del brief: hero + sezione autore in evidenza, disponibili come
 * shortcode ([dw_hero], [dw_author_box]) per uso manuale nel page builder.
 *
 * NON vengono più auto-iniettati su wp_body_open: il ramo vera front page
 * di index.php del parent (is_front_page() && is_home() && !is_paged())
 * costruisce già un proprio hero (.frontpage-lead, H1 sull'articolo in
 * evidenza) e un proprio box autore (.editorial-meta-zone/.emz-author, con
 * nome, ruolo, badge e stats) tramite le sue 4 WP_Query custom. Iniettare
 * anche l'hero/author-box del child in testa al <body> produceva due H1 e
 * due blocchi bio "Rosario Giordano" impilati sulla stessa pagina (bug
 * strutturale corretto in ROS-32).
 */

defined( 'ABSPATH' ) || exit;

/**
 * Markup hero: headline + 2 CTA (consulenza / ultimi tutorial).
 */
function dw_hero_markup() {
	ob_start();
	?>
	<section class="dw-hero">
		<div class="dw-hero-inner">
			<?php echo get_avatar( get_option( 'admin_email' ), 120, '', 'Rosario Giordano', array( 'class' => 'dw-hero-avatar' ) ); ?>
			<h1 class="dw-hero-headline">Sysadmin &amp; sviluppatore enterprise IT</h1>
			<p class="dw-hero-subheadline">Tutorial quotidiani e consulenza su commissione, da 20 anni di esperienza su infrastrutture enterprise reali.</p>
			<div class="dw-hero-cta">
				<a href="#dw-servizi" class="dw-btn dw-btn-primary">Consulenza</a>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'post' ) ?: home_url( '/blog/' ) ); ?>" class="dw-btn dw-btn-secondary">Ultimi tutorial</a>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}
add_shortcode( 'dw_hero', 'dw_hero_markup' );

/**
 * Markup sezione autore in evidenza: bio breve, aree di competenza, social.
 */
function dw_author_highlight_markup() {
	ob_start();
	?>
	<section class="dw-author-highlight">
		<div class="dw-author-highlight-inner">
			<?php echo get_avatar( get_option( 'admin_email' ), 96, '', 'Rosario Giordano', array( 'class' => 'dw-author-highlight-avatar' ) ); ?>
			<div class="dw-author-highlight-body">
				<h2>Rosario Giordano</h2>
				<p class="dw-author-highlight-role">Ingegnere informatico · Sysadmin enterprise · Sviluppatore · Social media manager · Analista</p>
				<p>20 anni di esperienza su infrastrutture enterprise reali: dalla gestione sistemistica quotidiana allo sviluppo di software e webapp su commissione. Su questo sito condivido tutorial tecnici e sono disponibile per consulenze mirate.</p>
				<ul class="dw-author-highlight-skills">
					<li>Sysadmin enterprise</li>
					<li>Cloud</li>
					<li>Sicurezza</li>
					<li>Sviluppo software &amp; webapp</li>
				</ul>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}
add_shortcode( 'dw_author_box', 'dw_author_highlight_markup' );
