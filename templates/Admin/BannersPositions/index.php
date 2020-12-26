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
$this->extend('MeCms./Admin/common/index');
$this->assign('title', __d('me_cms/banners', 'Banners positions'));

$this->append('actions', $this->Html->button(
    I18N_ADD,
    ['action' => 'add'],
    ['class' => 'btn-success', 'icon' => 'plus']
));
$this->append('actions', $this->Html->button(
    __d('me_cms/banners', 'Upload banners'),
    ['controller' => 'Banners', 'action' => 'upload'],
    ['class' => 'btn-success', 'icon' => 'plus']
));
?>

<table class="table table-hover">
    <thead>
        <tr>
            <th class="text-center"><?= $this->Paginator->sort('id', I18N_ID) ?></th>
            <th><?= $this->Paginator->sort('title', I18N_TITLE) ?></th>
            <th class="text-center"><?= $this->Paginator->sort('description', I18N_DESCRIPTION) ?></th>
            <th class="text-center"><?= $this->Paginator->sort('banner_count', __d('me_cms/banners', 'Banners')) ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($positions as $position) : ?>
            <tr>
                <td class="text-nowrap text-center">
                    <code><?= $position->id ?></code>
                </td>
                <td>
                    <strong>
                        <?= $this->Html->link($position->title, ['action' => 'edit', $position->id]) ?>
                    </strong>
                    <?php
                        $actions = [];
                        $actions[] = $this->Html->link(
                            I18N_EDIT,
                            ['action' => 'edit', $position->id],
                            ['icon' => 'pencil-alt']
                        );
                        $actions[] = $this->Form->postLink(I18N_DELETE, ['action' => 'delete', $position->id], [
                            'class' => 'text-danger',
                            'icon' => 'trash-alt',
                            'confirm' => I18N_SURE_TO_DELETE,
                        ]);
                        $actions[] = $this->Html->link(
                            I18N_UPLOAD,
                            [ 'controller' => 'Banners', 'action' => 'upload', '?' => ['position' => $position->id]],
                            ['icon' => 'upload']
                        );

                        echo $this->Html->ul($actions, ['class' => 'actions']);
                    ?>
                </td>
                <td class="text-center">
                    <?= $position->description ?>
                </td>
                <td class="text-nowrap text-center">
                    <?php
                    if ($position->banner_count) {
                        echo $this->Html->link(
                            $position->banner_count,
                            ['controller' => 'Banners', 'action' => 'index', '?' => ['position' => $position->id]],
                            ['title' => I18N_BELONG_ELEMENT]
                        );
                    } else {
                        echo $position->banner_count;
                    }
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->element('MeTools.paginator') ?>
