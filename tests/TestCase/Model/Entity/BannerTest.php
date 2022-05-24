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

namespace MeCms\Banners\Test\TestCase\Model\Entity;

use MeCms\TestSuite\EntityTestCase;

/**
 * BannerTest class
 */
class BannerTest extends EntityTestCase
{
    /**
     * Called before every test method
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->Entity->set('filename', 'example.gif');
    }

    /**
     * Test for fields that cannot be mass assigned
     * @test
     */
    public function testNoAccessibleProperties(): void
    {
        $this->assertHasNoAccessibleProperty(['id', 'modified']);
    }

    /**
     * Test for `_getPath()` method
     * @test
     */
    public function testGetPathVirtualField(): void
    {
        $this->assertEquals(BANNERS . 'example.gif', $this->Entity->get('path'));
    }

    /**
     * Test for `_getDescription()` method
     * @test
     */
    public function testDescriptionAccessor(): void
    {
        $this->assertNotNull($this->Entity->get('description'));
        $this->assertSame('', $this->Entity->set('description', null)->get('description'));
    }

    /**
     * Test for `_getWww()` method
     * @test
     */
    public function testGetWwwVirtualField(): void
    {
        $this->assertEquals(BANNERS_WWW . 'example.gif', $this->Entity->get('www'));
    }
}
