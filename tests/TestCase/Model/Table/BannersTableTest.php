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

use MeCms\Banners\Model\Entity\BannersPosition;
use MeCms\Banners\Model\Validation\BannerValidator;
use MeCms\TestSuite\TableTestCase;

/**
 * BannersTableTest class
 */
class BannersTableTest extends TableTestCase
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
     * Test for event methods
     * @test
     */
    public function testEventMethods()
    {
        $entity = $this->Table->get(1);
        $this->assertFileExists($entity->get('path'));
        $this->assertTrue($this->Table->delete($entity));
        $this->assertFileDoesNotExist($entity->get('path'));
    }

    /**
     * Test for `buildRules()` method
     * @test
     */
    public function testBuildRules()
    {
        $example = ['position_id' => 1, 'filename' => 'pic.jpg'];

        $entity = $this->Table->newEntity($example);
        $this->assertNotEmpty($this->Table->save($entity));

        //Saves again the same entity
        $entity = $this->Table->newEntity($example);
        $this->assertFalse($this->Table->save($entity));
        $this->assertEquals(['filename' => ['_isUnique' => I18N_VALUE_ALREADY_USED]], $entity->getErrors());

        $entity = $this->Table->newEntity(['position_id' => 999, 'filename' => 'pic2.jpg']);
        $this->assertFalse($this->Table->save($entity));
        $this->assertEquals(['position_id' => ['_existsIn' => I18N_SELECT_VALID_OPTION]], $entity->getErrors());
    }

    /**
     * Test for `initialize()` method
     * @test
     */
    public function testInitialize()
    {
        $this->assertEquals('banners', $this->Table->getTable());
        $this->assertEquals('filename', $this->Table->getDisplayField());
        $this->assertEquals('id', $this->Table->getPrimaryKey());

        $this->assertBelongsTo($this->Table->Positions);
        $this->assertEquals('position_id', $this->Table->Positions->getForeignKey());
        $this->assertEquals('INNER', $this->Table->Positions->getJoinType());

        $this->assertHasBehavior(['Timestamp', 'CounterCache']);

        $this->assertInstanceOf(BannerValidator::class, $this->Table->getValidator());
    }

    /**
     * Test for associations
     * @test
     */
    public function testAssociations()
    {
        $position = $this->Table->findById(2)->contain('Positions')->extract('position')->first();
        $this->assertInstanceOf(BannersPosition::class, $position);
        $this->assertEquals(1, $position->id);
    }

    /**
     * Test for `find()` methods
     * @test
     */
    public function testFindMethods()
    {
        $query = $this->Table->find('active');
        $this->assertStringEndsWith('FROM banners Banners WHERE Banners.active = :c0', $query->sql());
        $this->assertTrue($query->getValueBinder()->bindings()[':c0']['value']);
    }

    /**
     * Test for `queryFromFilter()` method
     * @test
     */
    public function testQueryFromFilter()
    {
        $query = $this->Table->queryFromFilter($this->Table->find(), ['position' => 2]);
        $this->assertStringEndsWith('FROM banners Banners WHERE position_id = :c0', $query->sql());
        $this->assertEquals(2, $query->getValueBinder()->bindings()[':c0']['value']);

        $query = $this->Table->queryFromFilter($this->Table->find(), ['filename' => 'image.jpg']);
        $this->assertStringEndsWith('FROM banners Banners WHERE Banners.filename like :c0', $query->sql());
        $this->assertEquals('%image.jpg%', $query->getValueBinder()->bindings()[':c0']['value']);

        //With some invalid datas
        $query = $this->Table->queryFromFilter($this->Table->find(), ['filename' => 'ab']);
        $this->assertEmpty($query->getValueBinder()->bindings());
    }
}
