<?php

/**
 * This file is part of me-cms-banners.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright   Copyright (c) Mirko Pagliai
 * @link        https://github.com/mirko-pagliai/me-cms-banners
 * @license     https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

/** @var \Cake\Routing\RouteBuilder $routes */
$routes->setRouteClass(DashedRoute::class);

$routes->scope('/', ['plugin' => 'MeCms/Banners'], function (RouteBuilder $routes) {
    //Banner
    if (!$routes->nameExists('banner')) {
        $routes->connect('/banner/:id', ['controller' => 'Banners', 'action' => 'open'], ['_name' => 'banner'])
            ->setPatterns(['id' => '\d+'])
            ->setPass(['id']);
    }
});

$routes->plugin('MeCms/Banners', ['path' => '/me-cms-banners'], function (RouteBuilder $routes) {
    //Admin routes
    $routes->prefix(ADMIN_PREFIX, function (RouteBuilder $routes) {
        $routes->setExtensions(['json']);

        $routes->fallbacks('DashedRoute');
    });
});
