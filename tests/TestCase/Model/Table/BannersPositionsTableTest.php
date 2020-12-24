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

namespace MeCms\Banners\Test\TestCase\Model\Table;

use MeCms\Banners\Model\Validation\BannersPositionValidator;
use MeCms\TestSuite\TableTestCase;

/**
 * BannersPositionsTableTest class
 */
class BannersPositionsTableTest extends TableTestCase
{
    /**
     * @var bool
     */
    public $autoFixtures = false;

    /**
     * Fixtures
     * @var array
     */
    public $fixtures = [
        'plugin.MeCms/Banners.Banners',
        'plugin.MeCms/Banners.BannersPositions',
    ];

    /**
     * Test for `buildRules()` method
     * @test
     */
    public function testBuildRules()
    {
        $example = ['title' => 'my-title'];

        $entity = $this->Table->newEntity($example);
        $this->assertNotEmpty($this->Table->save($entity));

        //Tries to save again the same entity
        $entity = $this->Table->newEntity($example);
        $this->assertFalse($this->Table->save($entity));
        $this->assertEquals(['title' => ['_isUnique' => I18N_VALUE_ALREADY_USED]], $entity->getErrors());
    }

    /**
     * Test for `initialize()` method
     * @test
     */
    public function testInitialize()
    {
        $this->assertEquals('banners_positions', $this->Table->getTable());
        $this->assertEquals('title', $this->Table->getDisplayField());
        $this->assertEquals('id', $this->Table->getPrimaryKey());

        $this->assertHasMany($this->Table->Banners);
        $this->assertEquals('position_id', $this->Table->Banners->getForeignKey());

        $this->assertHasBehavior('Timestamp');

        $this->assertInstanceOf(BannersPositionValidator::class, $this->Table->getValidator());
    }
}
