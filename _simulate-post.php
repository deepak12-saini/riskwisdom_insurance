<?php
$_SERVER['HTTP_HOST'] = 'localhost';
$_SERVER['REQUEST_URI'] = '/riskwisdom/';
$_SERVER['REQUEST_METHOD'] = 'POST';
$_POST = array(
	'_wpcf7' => '2234',
	'_wpcf7_version' => '6.1.6',
	'_wpcf7_locale' => 'en_US',
	'_wpcf7_unit_tag' => 'wpcf7-f2234-p2318-o3',
	'_wpcf7_container_post' => '2318',
	'text-340' => 'Test',
	'menu-993' => '18-25 years',
	'radio-102' => 'No',
	'tel-105' => '9877670043',
	'Occupation' => 'IT',
	'textarea-570' => 'test',
);

define( 'WP_USE_THEMES', false );
error_reporting( E_ALL );
ini_set( 'display_errors', '1' );

try {
	require __DIR__ . '/wp-load.php';
	if ( function_exists( 'wpcf7_control_init' ) ) {
		wpcf7_control_init();
	}
	$form = wpcf7_contact_form( 2234 );
	if ( $form ) {
		$result = $form->submit();
		echo wp_json_encode( $result, JSON_PRETTY_PRINT );
	}
} catch ( Throwable $e ) {
	echo 'EXCEPTION: ' . $e->getMessage() . "\n" . $e->getFile() . ':' . $e->getLine();
}
