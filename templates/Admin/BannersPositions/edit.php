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
$this->extend('MeCms./common/form');
$this->assign('title', $title = __d('me_cms/banners', 'Edit banners position'));
?>

<?= $this->Form->create($position); ?>
<fieldset>
    <?= $this->Form->control('title', ['label' => I18N_TITLE]) ?>
    <?= $this->Form->control('description', ['label' => I18N_DESCRIPTION]) ?>
</fieldset>
<?= $this->Form->submit($title) ?>
<?= $this->Form->end() ?>
