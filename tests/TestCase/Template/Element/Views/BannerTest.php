<?php
declare(strict_types=1);

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

namespace MeCms\Banners\Test\TestCase\View\Helper;

use MeCms\TestSuite\TestCase;
use MeCms\View\View;

/**
 * BannerTest class
 */
class BannerTest extends TestCase
{
    /**
     * Fixtures
     * @var array
     */
    public $fixtures = [
        'plugin.MeCms/Banners.Banners',
        'plugin.MeCms/Banners.BannersPositions',
    ];

    /**
     * Test for `views/banner.php` template element
     * @test
     */
    public function testBannerElement()
    {
        $banner = $this->getMockForModel('MeCms/Banners.Banners')->find()->contain('Positions')->first();
        $element = (new View())->element('MeCms/Banners.views/banner', compact('banner'));
        $this->assertNotEmpty($element);
    }
}
