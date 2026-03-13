<?php
header('Access-Control-Allow-Origin: *');
jsonOutput([
	'installed' => true,
	'maintenance' => false,
	'needsDbUpgrade' => false,
	'version' => '20.0.0.1',
	'versionstring' => '20.0.0',
	'edition' => '',
	'productname' => 'Nextcloud'
]);