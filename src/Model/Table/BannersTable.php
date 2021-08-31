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

namespace MeCms\Banners\Model\Table;

use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Query as CakeQuery;
use Cake\ORM\RulesChecker;
use MeCms\Banners\Model\Table\BannersPositionsTable;
use MeCms\Banners\Model\Validation\BannerValidator;
use MeCms\Model\Table\AppTable;
use MeCms\ORM\Query;

/**
 * Banners model
 * @property \Cake\ORM\Association\BelongsTo $Positions
 */
class BannersTable extends AppTable
{
    /**
     * Cache configuration name
     * @var string
     */
    protected $cache = 'banners';

    /**
     * Called after an entity has been deleted
     * @param \Cake\Event\Event $event Event object
     * @param \Cake\Datasource\EntityInterface $entity Entity object
     * @return void
     */
    public function afterDelete(Event $event, EntityInterface $entity): void
    {
        @unlink(BANNERS . $entity->get('filename'));

        parent::afterDelete($event, $entity);
    }

    /**
     * Returns a rules checker object that will be used for validating
     *  application integrity
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        return $rules->add($rules->existsIn(['position_id'], 'Positions', I18N_SELECT_VALID_OPTION))
            ->add($rules->isUnique(['filename'], I18N_VALUE_ALREADY_USED));
    }

    /**
     * "active" find method
     * @param \MeCms\ORM\Query $query Query object
     * @return \MeCms\ORM\Query $query Query object
     */
    public function findActive(Query $query): Query
    {
        return $query->where([sprintf('%s.active', $this->getAlias()) => true]);
    }

    /**
     * Initialize method
     * @param array $config The configuration for the table
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('banners');
        $this->setDisplayField('filename');
        $this->setPrimaryKey('id');

        $this->belongsTo('Positions', ['className' => BannersPositionsTable::class])
            ->setForeignKey('position_id')
            ->setJoinType('INNER');

        $this->addBehavior('Timestamp');
        $this->addBehavior('CounterCache', ['Positions' => ['banner_count']]);

        $this->_validatorClass = BannerValidator::class;
    }

    /**
     * Build query from filter data
     * @param \Cake\ORM\Query $query Query object
     * @param array $data Filter data (`$this->getRequest()->getQueryParams()`)
     * @return \Cake\ORM\Query $query Query object
     */
    public function queryFromFilter(CakeQuery $query, array $data = []): CakeQuery
    {
        $query = parent::queryFromFilter($query, $data);

        //"Position" field
        if (!empty($data['position']) && is_positive($data['position'])) {
            $query->where(['position_id' => $data['position']]);
        }

        //"Filename" field
        if (!empty($data['filename']) && strlen($data['filename']) > 2) {
            $query->where([sprintf('%s.%s LIKE', $this->getAlias(), 'filename') => '%' . $data['filename'] . '%']);
        }

        return $query;
    }
}
