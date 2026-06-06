<?php
/**
 * Fix CF7 quote form mail: HTML template, logo, Risk Wisdom branding.
 * Run on server after deploy: php fix-cf7-mail.php
 */

define( 'WP_USE_THEMES', false );
require __DIR__ . '/wp-load.php';

if ( ! class_exists( 'WPCF7_ContactForm' ) ) {
	echo "Contact Form 7 is not active.\n";
	exit( 1 );
}

/**
 * Logo URL for email (must be absolute HTTPS for Outlook/Gmail).
 */
function riskwisdom_cf7_email_logo_url() {
	$logo = get_theme_mod( 'logo' );

	if ( $logo ) {
		$logo = str_replace(
			array( 'http://localhost/riskwisdom', 'https://localhost/riskwisdom' ),
			'https://riskwisdom.com.au',
			$logo
		);
		return $logo;
	}

	return 'https://riskwisdom.com.au/wp-content/uploads/2026/02/riskwisdom-fp-2.jpg';
}

/**
 * Build branded HTML email body for a quote form.
 *
 * @param string $form_title Form title shown in heading.
 * @param array  $fields     List of [ 'label' => '', 'tag' => '' ].
 * @param string $intro      Short line under the heading.
 */
function riskwisdom_cf7_email_body( $form_title, array $fields, $intro = 'A new quote request was submitted on your website.' ) {
	$logo_url = esc_url( riskwisdom_cf7_email_logo_url() );
	$site_url = 'https://riskwisdom.com.au';

	$rows = '';
	foreach ( $fields as $field ) {
		$rows .= sprintf(
			'<tr>
				<td style="padding:12px 16px;border-bottom:1px solid #e8ecf0;color:#4a5568;width:160px;vertical-align:top;font-weight:600;font-size:14px;">%s</td>
				<td style="padding:12px 16px;border-bottom:1px solid #e8ecf0;color:#1a202c;font-size:14px;">%s</td>
			</tr>',
			esc_html( $field['label'] ),
			esc_html( $field['tag'] )
		);
	}

	return sprintf(
		'<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"></head>
<body style="margin:0;padding:0;background-color:#eef2f6;font-family:Arial,Helvetica,sans-serif;">
<table role="presentation" width="100%%" cellpadding="0" cellspacing="0" style="background-color:#eef2f6;padding:32px 16px;">
<tr><td align="center">
<table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%%;background-color:#ffffff;border-radius:10px;overflow:hidden;box-shadow:0 4px 16px rgba(26,58,92,0.12);">
<tr>
<td style="background-color:#1a3a5c;padding:28px 24px;text-align:center;">
<a href="%3$s" style="text-decoration:none;">
<img src="%1$s" alt="Risk Wisdom" width="220" style="display:block;margin:0 auto;max-width:220px;height:auto;border:0;">
</a>
</td>
</tr>
<tr>
<td style="padding:32px 28px 8px;">
<h1 style="margin:0 0 8px;color:#1a3a5c;font-size:22px;font-weight:700;line-height:1.3;">%2$s</h1>
<p style="margin:0 0 24px;color:#718096;font-size:14px;line-height:1.5;">%5$s</p>
<table role="presentation" width="100%%" cellpadding="0" cellspacing="0" style="border:1px solid #e8ecf0;border-radius:8px;overflow:hidden;">
%4$s
</table>
</td>
</tr>
<tr>
<td style="padding:8px 28px 32px;">
<p style="margin:0;color:#718096;font-size:13px;line-height:1.6;">Please reply to the customer as soon as possible.</p>
</td>
</tr>
<tr>
<td style="background-color:#f7fafc;padding:22px 28px;text-align:center;border-top:1px solid #e8ecf0;">
<p style="margin:0 0 6px;color:#4a5568;font-size:14px;">Thanks,</p>
<p style="margin:0 0 10px;color:#1a3a5c;font-size:16px;font-weight:700;">Risk Wisdom</p>
<p style="margin:0;"><a href="%3$s" style="color:#2b6cb0;font-size:13px;text-decoration:none;">riskwisdom.com.au</a></p>
</td>
</tr>
</table>
</td></tr>
</table>
</body>
</html>',
		$logo_url,
		esc_html( $form_title ),
		esc_url( $site_url ),
		$rows,
		esc_html( $intro )
	);
}

$form_templates = array(
	2234 => array(
		'title'  => 'Life Insurance Quote',
		'fields' => array(
			array( 'label' => 'Name', 'tag' => '[text-340]' ),
			array( 'label' => 'Email', 'tag' => '[quote-email]' ),
			array( 'label' => 'Age', 'tag' => '[menu-993]' ),
			array( 'label' => 'Do you smoke?', 'tag' => '[radio-102]' ),
			array( 'label' => 'Phone', 'tag' => '[tel-105]' ),
			array( 'label' => 'Occupation', 'tag' => '[Occupation]' ),
			array( 'label' => 'Message', 'tag' => '[textarea-570]' ),
		),
	),
	2478 => array(
		'title'  => 'Income Insurance Quote',
		'fields' => array(
			array( 'label' => 'Name', 'tag' => '[text-340]' ),
			array( 'label' => 'Email', 'tag' => '[quote-email]' ),
			array( 'label' => 'Phone', 'tag' => '[tel-105]' ),
			array( 'label' => 'Occupation', 'tag' => '[Occupation]' ),
			array( 'label' => 'Gross Income', 'tag' => '[GrossIncome]' ),
			array( 'label' => 'Message', 'tag' => '[textarea-570]' ),
		),
	),
	2862 => array(
		'title'  => 'Business Insurance Quote',
		'fields' => array(
			array( 'label' => 'Name', 'tag' => '[text-340]' ),
			array( 'label' => 'Email', 'tag' => '[quote-email]' ),
			array( 'label' => 'Phone', 'tag' => '[tel-105]' ),
			array( 'label' => 'Occupation', 'tag' => '[Occupation]' ),
			array( 'label' => 'Gross Income', 'tag' => '[GrossIncome]' ),
			array( 'label' => 'Message', 'tag' => '[textarea-570]' ),
		),
	),
	2863 => array(
		'title'  => 'Trauma Insurance Quote',
		'fields' => array(
			array( 'label' => 'Name', 'tag' => '[text-340]' ),
			array( 'label' => 'Email', 'tag' => '[quote-email]' ),
			array( 'label' => 'Phone', 'tag' => '[tel-105]' ),
			array( 'label' => 'Occupation', 'tag' => '[Occupation]' ),
			array( 'label' => 'Do you smoke?', 'tag' => '[radio-102]' ),
			array( 'label' => 'Message', 'tag' => '[textarea-570]' ),
		),
	),
	2866 => array(
		'title'  => 'TPD Insurance Quote',
		'fields' => array(
			array( 'label' => 'Name', 'tag' => '[text-340]' ),
			array( 'label' => 'Email', 'tag' => '[quote-email]' ),
			array( 'label' => 'Phone', 'tag' => '[tel-105]' ),
			array( 'label' => 'Do you smoke?', 'tag' => '[radio-102]' ),
			array( 'label' => 'Occupation', 'tag' => '[Occupation]' ),
			array( 'label' => 'Message', 'tag' => '[textarea-570]' ),
		),
	),
	2515 => array(
		'title'  => 'Contact Us',
		'intro'  => 'A new message was submitted from the Contact Us page.',
		'fields' => array(
			array( 'label' => 'Name', 'tag' => '[your-name]' ),
			array( 'label' => 'Email', 'tag' => '[your-email]' ),
			array( 'label' => 'Phone', 'tag' => '[phone]' ),
			array( 'label' => 'Subject', 'tag' => '[your-subject]' ),
			array( 'label' => 'Message', 'tag' => '[your-message]' ),
		),
	),
);

foreach ( $form_templates as $form_id => $template ) {
	$contact_form = wpcf7_contact_form( $form_id );

	if ( ! $contact_form ) {
		echo "Form {$form_id}: not found\n";
		continue;
	}

	$title      = $contact_form->title();
	$properties = $contact_form->get_properties();

	$properties['mail']['active']     = true;
	$properties['mail']['subject']    = 'Risk Wisdom: ' . $template['title'];
	$properties['mail']['sender']     = 'Risk Wisdom <info@riskwisdom.com.au>';
	$properties['mail']['recipient']  = 'info@riskwisdom.com.au';
	$intro = $template['intro'] ?? 'A new quote request was submitted on your website.';
	$properties['mail']['body']       = riskwisdom_cf7_email_body( $template['title'], $template['fields'], $intro );
	$properties['mail']['use_html']   = true;
	$properties['messages']['spam']   = 'Your message was blocked by our spam filter. Please call us or try again.';

	if ( in_array( (int) $form_id, array( 2234, 2478, 2862, 2863, 2866 ), true ) ) {
		$properties['mail']['additional_headers'] = "Reply-To: [quote-email]\n";
	}

	$contact_form->set_properties( $properties );
	$contact_form->save();

	delete_post_meta( $form_id, '_config_validation' );

	echo "Form {$form_id} ({$title}): HTML mail template updated\n";
}

echo "Logo URL: " . riskwisdom_cf7_email_logo_url() . "\n";
echo "Done.\n";
