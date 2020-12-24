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

namespace MeCms\Banners\Test\TestCase\Controller\Admin;

use MeCms\Banners\Model\Entity\BannersPosition;
use MeCms\TestSuite\ControllerTestCase;

/**
 * BannersPositionsControllerTest class
 */
class BannersPositionsControllerTest extends ControllerTestCase
{
    /**
     * Fixtures
     * @var array
     */
    public $fixtures = [
        'plugin.MeCms/Banners.BannersPositions',
    ];

    /**
     * Tests for `isAuthorized()` method
     * @test
     */
    public function testIsAuthorized()
    {
        $this->assertGroupsAreAuthorized([
            'admin' => true,
            'manager' => false,
            'user' => false,
        ]);
    }

    /**
     * Tests for `index()` method
     * @test
     */
    public function testIndex()
    {
        $this->get($this->url + ['action' => 'index']);
        $this->assertResponseOkAndNotEmpty();
        $this->assertTemplate('Admin' . DS . 'BannersPositions' . DS . 'index.php');
        $this->assertContainsOnlyInstancesOf(BannersPosition::class, $this->viewVariable('positions'));
    }

    /**
     * Tests for `add()` method
     * @test
     */
    public function testAdd()
    {
        $url = $this->url + ['action' => 'add'];

        $this->get($url);
        $this->assertResponseOkAndNotEmpty();
        $this->assertTemplate('Admin' . DS . 'BannersPositions' . DS . 'add.php');
        $this->assertInstanceof(BannersPosition::class, $this->viewVariable('position'));

        //POST request. Data are valid
        $this->post($url, ['title' => 'new-position-title', 'descriptions' => 'position description']);
        $this->assertRedirect(['action' => 'index']);
        $this->assertFlashMessage(I18N_OPERATION_OK);

        //POST request. Data are invalid
        $this->post($url, ['title' => 'aa']);
        $this->assertResponseOkAndNotEmpty();
        $this->assertResponseContains(I18N_OPERATION_NOT_OK);
        $this->assertInstanceof(BannersPosition::class, $this->viewVariable('position'));
    }

    /**
     * Tests for `edit()` method
     * @test
     */
    public function testEdit()
    {
        $url = $this->url + ['action' => 'edit', 1];

        $this->get($url);
        $this->assertResponseOkAndNotEmpty();
        $this->assertTemplate('Admin' . DS . 'BannersPositions' . DS . 'edit.php');
        $this->assertInstanceof(BannersPosition::class, $this->viewVariable('position'));

        //POST request. Data are valid
        $this->post($url, ['title' => 'another-title']);
        $this->assertRedirect(['action' => 'index']);
        $this->assertFlashMessage(I18N_OPERATION_OK);

        //POST request. Data are invalid
        $this->post($url, ['title' => 'aa']);
        $this->assertResponseOkAndNotEmpty();
        $this->assertResponseContains(I18N_OPERATION_NOT_OK);
        $this->assertInstanceof(BannersPosition::class, $this->viewVariable('position'));
    }

    /**
     * Tests for `delete()` method
     * @test
     */
    public function testDelete()
    {
        //POST request. This position has no banner
        $this->post($this->url + ['action' => 'delete', 3]);
        $this->assertRedirect(['action' => 'index']);
        $this->assertFlashMessage(I18N_OPERATION_OK);
        $this->assertTrue($this->Table->findById(3)->isEmpty());

        //POST request. This position has some banners, so it cannot be deleted
        $this->post($this->url + ['action' => 'delete', 1]);
        $this->assertRedirect(['action' => 'index']);
        $this->assertFlashMessage(I18N_BEFORE_DELETE);
        $this->assertFalse($this->Table->findById(1)->isEmpty());
    }
}
