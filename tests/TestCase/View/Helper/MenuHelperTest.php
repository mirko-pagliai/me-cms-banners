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

use MeCms\TestSuite\MenuHelperTestCase;

/**
 * MenuHelperTest class
 */
class MenuHelperTest extends MenuHelperTestCase
{
    /**
     * Tests for `banners()` method
     * @test
     */
    public function testBanners(): void
    {
        $this->assertEmpty($this->Helper->banners());

        $this->writeAuthOnSession(['group' => ['name' => 'manager']]);
        [$links,,, $handledControllers] = $this->Helper->banners();
        $this->assertNotEmpty($links);
        $this->assertTextNotContains('List positions', $links);
        $this->assertTextNotContains('Add position', $links);
        $this->assertEquals(['Banners', 'BannersPositions'], $handledControllers);

        $this->writeAuthOnSession(['group' => ['name' => 'admin']]);
        [$links] = $this->Helper->banners();
        $this->assertTextContains('List positions', $links);
        $this->assertTextContains('Add position', $links);
    }
}
