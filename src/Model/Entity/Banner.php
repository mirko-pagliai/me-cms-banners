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

namespace MeCms\Banners\Model\Entity;

use Cake\ORM\Entity;
use Tools\Exceptionist;

/**
 * Banner entity
 * @property int $id
 * @property int $position_id
 * @property string $filename
 * @property string $target
 * @property string $description
 * @property bool $active
 * @property bool $thumbnail
 * @property int $click_count
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \MeCms\Banners\Model\Entity\BannersPosition $position
 */
class Banner extends Entity
{
    /**
     * Fields that can be mass assigned
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
        'modified' => false,
    ];

    /**
     * Virtual fields that should be exposed
     * @var array
     */
    protected $_virtual = ['path', 'www'];

    /**
     * Gets the banner full path (virtual field)
     * @return string
     * @throws \Tools\Exception\PropertyNotExistsException
     */
    protected function _getPath(): ?string
    {
        Exceptionist::objectPropertyExists($this, 'filename');

        return BANNERS . $this->get('filename');
    }

    /**
     * Gets description as string
     * @param string|null $description Description
     * @return string
     */
    protected function _getDescription(?string $description): string
    {
        return (string)$description;
    }

    /**
     * Gets the banner web address (virtual field)
     * @return string
     * @throws \Tools\Exception\PropertyNotExistsException
     */
    protected function _getWww(): ?string
    {
        Exceptionist::objectPropertyExists($this, 'filename');

        return BANNERS_WWW . $this->get('filename');
    }
}
