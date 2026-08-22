<?php
/**
 * Step 5 del brief: pagina "Chi sono" dedicata.
 *
 * A differenza di hero/CTA (iniettati su wp_body_open perché la front page
 * del parent non passa mai dal loop), una pagina WP normale (page.php del
 * parent) usa the_content() nel loop: qui basta uno shortcode da inserire
 * nel contenuto della pagina "Chi sono" creata in WP admin, senza duplicare
 * markup né toccare i template del parent.
 */

defined( 'ABSPATH' ) || exit;

/**
 * Markup pagina Chi sono: foto, bio estesa, storia professionale,
 * stack/competenze, case study/clienti, CTA contatto diretto.
 */
function dw_chi_sono_markup() {
	ob_start();
	?>
	<section class="dw-chi-sono">
		<div class="dw-chi-sono-header">
			<?php echo get_avatar( get_option( 'admin_email' ), 160, '', 'Rosario Giordano', array( 'class' => 'dw-chi-sono-avatar' ) ); ?>
			<div>
				<h1 class="dw-chi-sono-name">Rosario Giordano</h1>
				<p class="dw-chi-sono-role">Sysadmin &amp; sviluppatore enterprise IT</p>
			</div>
		</div>

		<div class="dw-chi-sono-bio">
			<p>Da oltre 20 anni lavoro su infrastrutture IT enterprise reali: gestione sistemi, cloud, sicurezza e sviluppo software su misura. Ho iniziato come sysadmin su ambienti on-premise e negli anni ho seguito l'evoluzione del settore verso cloud, automazione e AI, senza mai abbandonare il lato pratico del lavoro quotidiano in trincea.</p>
			<p>Questo sito nasce per condividere tutorial, note tecniche e approfondimenti nati da problemi reali affrontati sul campo — non teoria astratta, ma soluzioni verificate in produzione.</p>
		</div>

		<div class="dw-chi-sono-skills">
			<h2>Competenze</h2>
			<ul class="dw-chi-sono-skills-list">
				<li>Sysadmin &amp; infrastrutture on-premise/cloud</li>
				<li>Sicurezza &amp; hardening sistemi</li>
				<li>Sviluppo software &amp; applicazioni web</li>
				<li>Database &amp; networking</li>
				<li>Automazione &amp; AI applicata all'IT</li>
			</ul>
		</div>

		<div class="dw-chi-sono-cta">
			<h2>Lavoriamo insieme</h2>
			<p>Disponibile per consulenze mirate su infrastrutture, sviluppo e sicurezza.</p>
			<a href="mailto:<?php echo esc_attr( get_option( 'admin_email' ) ); ?>" class="dw-btn dw-btn-primary">Contattami</a>
		</div>
	</section>
	<?php
	return ob_get_clean();
}
add_shortcode( 'dw_chi_sono', 'dw_chi_sono_markup' );
