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
$this->extend('/Admin/Banners/common/index');
?>

<div class="row">
    <?php foreach ($banners as $banner) : ?>
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item p-1 text-truncate text-center">
                        <?= $this->Html->link($banner->get('filename'), ['action' => 'edit', $banner->get('id')]) ?>
                    </li>
                    <li class="list-group-item p-1 small text-center">
                        <samp><?= I18N_ID ?> <?= $banner->get('id') ?></samp>
                    </li>
                    <li class="list-group-item p-1 small text-center">
                        <?= I18N_POSITION ?>:
                        <?= $this->Html->link($banner->get('position')->get('title'), [
                            '?' => ['position' => $banner->get('position')->get('id')],
                        ], ['title' => I18N_BELONG_ELEMENT]) ?>
                    </li>
                    <li class="list-group-item p-1 small text-center">
                        (<?= $banner->get('created')->i18nFormat() ?>)
                    </li>
                </ul>

                <?php
                $class = 'card-img-bottom';
                if ($banner->has('thumbnail')) {
                    echo $this->Thumb->resize($banner->get('path'), ['width' => 400], compact('class'));
                } else {
                    echo $this->Html->img($banner->get('www'), compact('class'));
                }

                $actions = [
                    $this->Html->button('', ['action' => 'edit', $banner->get('id')], [
                        'class' => 'btn-link',
                        'icon' => 'pencil-alt',
                        'title' => I18N_EDIT,
                    ]),
                ];

                if ($banner->has('target')) {
                    $actions[] = $this->Html->button('', $banner->get('target'), [
                        'class' => 'btn-link',
                        'icon' => 'external-link-alt',
                        'title' => I18N_OPEN,
                        'target' => '_blank',
                    ]);
                }

                $actions[] = $this->Html->button('', ['action' => 'download', $banner->get('id')], [
                    'class' => 'btn-link',
                    'icon' => 'download',
                    'title' => I18N_DOWNLOAD,
                ]);

                //Only admins can delete banners
                if ($this->Auth->isGroup('admin')) {
                    $actions[] = $this->Form->postButton('', ['action' => 'delete', $banner->get('id')], [
                        'class' => 'btn-link text-danger',
                        'icon' => 'trash-alt',
                        'title' => I18N_DELETE,
                        'confirm' => I18N_SURE_TO_DELETE,
                    ]);
                }
                ?>

                <div class="btn-toolbar mt-1 justify-content-center" role="toolbar">
                    <div class="btn-group" role="group">
                        <?= implode(PHP_EOL, $actions) ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
