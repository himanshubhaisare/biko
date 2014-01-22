<?php

use Phalcon\Loader;

$loader = new Loader();

$loader->registerNamespaces(array(
	'Biko\Frontend\Controllers' => __DIR__ . '/../apps/frontend/controllers/',
	'Biko\Backend\Controllers'  => __DIR__ . '/../apps/backend/controllers/',
	'Biko\Backend\Forms'        => __DIR__ . '/../apps/backend/forms/',
	'Biko\Models'               => __DIR__ . '/../shared/models/',
	'Biko'                      => __DIR__ . '/../library/Biko/',
));

$loader->register();