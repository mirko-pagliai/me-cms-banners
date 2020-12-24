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

namespace MeCms\Banners\Controller;

use Cake\Database\Expression\QueryExpression;
use Cake\Http\Response;
use MeCms\Controller\AppController;

/**
 * Banners controller
 * @property \MeCms\Banners\Model\Table\BannersTable $Banners
 */
class BannersController extends AppController
{
    /**
     * Opens a banner (redirects to the banner target)
     * @param string $id Banner ID
     * @return \Cake\Http\Response|null
     */
    public function open(string $id): ?Response
    {
        $banner = $this->Banners->findActiveById($id)
            ->select(['target'])
            ->where(['target !=' => ''])
            ->cache('view_' . md5($id))
            ->firstOrFail();

        //Increases the click count
        $expression = new QueryExpression('click_count = click_count + 1');
        $this->Banners->updateAll([$expression], [compact('id')]);

        //Redirects
        return $this->redirect($banner->get('target'));
    }
}
