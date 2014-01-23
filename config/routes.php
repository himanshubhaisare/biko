<?php

//Default parameters
$router->setDefaultModule('frontend');
$router->setDefaultNamespace('Biko\Frontend\Controllers');

//Not-Found paths
$router->notFound(array("controller" => "index", "action" => "route404"));

//Register "frontend" resources
$router->addModuleResource('frontend', 'Biko\Frontend\Controllers\Index',    '/index');
$router->addModuleResource('frontend', 'Biko\Frontend\Controllers\Catalogs', '/category');
$router->addModuleResource('frontend', 'Biko\Frontend\Controllers\Help',     '/help');
$router->addModuleResource('frontend', 'Biko\Frontend\Controllers\Cart',     '/cart');

//Register "backend" resources
$router->addModuleResource('backend', 'Biko\Backend\Controllers\Session');
$router->addModuleResource('backend', 'Biko\Backend\Controllers\Dashboard',  '/admin/dashboard');
$router->addModuleResource('backend', 'Biko\Backend\Controllers\Products',   '/admin/products');
$router->addModuleResource('backend', 'Biko\Backend\Controllers\Categories', '/admin/categories');
