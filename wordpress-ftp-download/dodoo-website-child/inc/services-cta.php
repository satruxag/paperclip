<?php
/**
 * Step 6 del brief: sezione CTA servizi in homepage.
 *
 * L'hero (homepage-hero.php) contiene già un link "Consulenza" verso
 * l'ancora #dw-servizi, live da prima di questo fix ma puntato a nulla
 * (ancora inesistente). Questo modulo aggiunge la sezione mancante subito
 * dopo l'author box, chiudendo il link rotto.
 */

defined( 'ABSPATH' ) || exit;

/**
 * Markup sezione CTA servizi: 3 aree di consulenza + contatto.
 */
function dw_services_cta_markup() {
	ob_start();
	?>
	<section class="dw-services-cta" id="dw-servizi">
		<div class="dw-services-cta-inner">
			<h2>Consulenza su commissione</h2>
			<p class="dw-services-cta-intro">Disponibile per interventi mirati su infrastrutture enterprise, sviluppo software e sicurezza.</p>
			<div class="dw-services-cta-grid">
				<div class="dw-services-cta-card">
					<span class="dw-services-cta-icon" aria-hidden="true"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="8" rx="2"/><rect x="2" y="14" width="20" height="8" rx="2"/><line x1="6" y1="6" x2="6.01" y2="6"/><line x1="6" y1="18" x2="6.01" y2="18"/></svg></span>
					<h3>Sysadmin &amp; Cloud</h3>
					<p>Gestione, hardening e ottimizzazione di infrastrutture on-premise e cloud.</p>
				</div>
				<div class="dw-services-cta-card">
					<span class="dw-services-cta-icon" aria-hidden="true"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg></span>
					<h3>Sviluppo software</h3>
					<p>Applicazioni web, automazioni e integrazioni su misura.</p>
				</div>
				<div class="dw-services-cta-card">
					<span class="dw-services-cta-icon" aria-hidden="true"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></span>
					<h3>Sicurezza</h3>
					<p>Analisi, audit e messa in sicurezza di sistemi e applicazioni.</p>
				</div>
			</div>
			<a href="mailto:<?php echo esc_attr( get_option( 'admin_email' ) ); ?>" class="dw-btn dw-btn-primary">Richiedi un preventivo</a>
		</div>
	</section>
	<?php
	return ob_get_clean();
}
add_shortcode( 'dw_services_cta', 'dw_services_cta_markup' );

/*
 * ROS-183: la stampa automatica su wp_body_open è stata rimossa.
 *
 * Prima di ROS-183 questa sezione (titolo "Consulenza su commissione")
 * veniva iniettata come PRIMO elemento del <body>, prima di header e hero:
 * la homepage si apriva con una CTA invece che con la presentazione di
 * Rosario Giordano, e il template generava un secondo blocco
 * #dw-servizi duplicato (la sezione CTA "Richiedi una Consulenza" già
 * presente in fondo alla homepage via parent theme inc/services-cta.php).
 *
 * La sezione resta disponibile come shortcode [dw_services_cta] per usi
 * puntuali, ma non viene più stampata automaticamente.
 */
