<?php
define( 'DB_NAME', 'riskwisdom_2026' );
define( 'DB_USER', 'riskwisdom_2026' );
define( 'DB_PASSWORD', 'gx?9Bb026' );
define( 'DB_HOST', 'localhost' );
$mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
$r = $mysqli->query( "SELECT option_value FROM wp_options WHERE option_name='wp_mail_smtp'" );
$row = $r->fetch_assoc();
$data = unserialize( $row['option_value'] );
echo json_encode( $data, JSON_PRETTY_PRINT );
