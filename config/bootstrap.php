<?php
declare(strict_types=1);

/*
 *  This file is part of me-cms-banners.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright   Copyright (c) Mirko Pagliai
 * @link        https://github.com/mirko-pagliai/me-cms-banners
 * @license     https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Cache\Cache;
use Cake\Core\Configure;

//Sets the default banners directory
if (!defined('BANNERS')) {
    define('BANNERS', WWW_ROOT . 'img' . DS . 'banners' . DS);
}

//Sets the default banners web address
if (!defined('BANNERS_WWW')) {
    define('BANNERS_WWW', 'banners/');
}

//Sets the cache
if (!Cache::getConfig('banners')) {
    Cache::setConfig('banners', [
        'className' => 'File',
        'duration' => '+999 days',
        'prefix' => '',
        'mask' => 0777,
        'path' => CACHE . 'me_cms_banners',
    ]);
}

//Sets directories to be created and must be writable
$writableDirs = Configure::read('WRITABLE_DIRS', []);
if (!in_array(BANNERS, $writableDirs)) {
    Configure::write('WRITABLE_DIRS', array_merge($writableDirs, [BANNERS]));
}

if (!defined('I18N_BANNERS')) {
    define('I18N_BANNERS', __d('me_cms/banners', 'Banners'));
}
