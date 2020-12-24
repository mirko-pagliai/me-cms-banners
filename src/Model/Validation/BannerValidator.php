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

namespace MeCms\Banners\Model\Validation;

use MeCms\Validation\AppValidator;

/**
 * Banner validator class
 */
class BannerValidator extends AppValidator
{
    /**
     * Valid extensions
     */
    protected const VALID_EXTENSIONS = ['gif', 'jpg', 'jpeg', 'png'];

    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct();

        $this->add('position_id', [
            'naturalNumber' => [
                'message' => I18N_SELECT_VALID_OPTION,
                'rule' => 'naturalNumber',
            ],
        ])->requirePresence('position_id', 'create');

        $this->add('filename', [
            'maxLength' => [
                'message' => __d('me_cms', 'Must be at most {0} chars', 255),
                'rule' => ['maxLength', 255],
            ],
            'extension' => [
                'message' => __d('me_cms', 'Valid extensions: {0}', implode(', ', self::VALID_EXTENSIONS)),
                'rule' => ['extension', self::VALID_EXTENSIONS],
            ],
        ])->requirePresence('filename', 'create');

        $this->add('target', [
            'maxLength' => [
                'message' => __d('me_cms', 'Must be at most {0} chars', 255),
                'rule' => ['maxLength', 255],
            ],
            'url' => [
                'message' => __d('me_cms', 'Must be a valid url'),
                'rule' => ['url', true],
            ],
        ])->allowEmptyString('target');

        $this->add('thumbnail', [
            'boolean' => [
                'message' => I18N_SELECT_VALID_OPTION,
                'rule' => 'boolean',
            ],
        ]);
    }
}
