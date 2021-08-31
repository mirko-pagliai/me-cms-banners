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

namespace MeCms\Banners\Test\TestCase\Model\Validation;

use MeCms\TestSuite\ValidationTestCase;

/**
 * BannersPositionValidatorTest class
 */
class BannersPositionValidatorTest extends ValidationTestCase
{
    /**
     * @var array
     */
    protected $example = ['title' => 'my-title'];

    /**
     * Fixtures
     * @var array
     */
    public $fixtures = [
        'plugin.MeCms/Banners.BannersPositions',
    ];

    /**
     * Test validation for `title` property
     * @test
     */
    public function testValidatorForTitle(): void
    {
        foreach (['ab', str_repeat('a', 101)] as $title) {
            $errors = $this->Table->newEntity(compact('title') + $this->example)->getErrors();
            $this->assertEquals(['title' => ['lengthBetween' => 'Must be between 3 and 100 chars']], $errors);
        }

        foreach (['abc', str_repeat('a', 100)] as $title) {
            $errors = $this->Table->newEntity(compact('title') + $this->example)->getErrors();
            $this->assertEmpty($errors);
        }
    }
}
