<?php

/** @var yii\web\View $this */
/** @var common\services\Apple\AppleView[] $apples */

use common\domain\Apple\AppleStatus;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Яблоки';
?>

<div class="apple-index">

    <h1 class="mb-3"><?= Html::encode($this->title) ?></h1>

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title mb-3">Генерация яблок</h5>

            <form method="post" action="<?= Url::to(['apple/generate']) ?>" class="d-flex gap-2 align-items-center flex-wrap">
                <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()) ?>

                <label class="m-0">
                    Кол-во (если пусто — случайно 1..20):
                    <input
                            type="number"
                            name="count"
                            min="1"
                            max="100"
                            class="form-control d-inline-block"
                            style="width: 160px; margin-left: 8px;"
                    >
                </label>

                <button class="btn btn-primary" type="submit">Сгенерировать</button>
            </form>
        </div>
    </div>

    <table class="table table-bordered table-striped align-middle">
        <thead>
        <tr>
            <th style="width: 70px;">ID</th>
            <th>Цвет</th>
            <th>Статус</th>
            <th>Дата появления</th>
            <th>Дата падения</th>
            <th>Съедено (%)</th>
            <th>Размер</th>
            <th>Гнилое?</th>
            <th style="width: 320px;">Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($apples as $a): ?>
            <tr>
                <td><?= (int)$a->id ?></td>
                <td><?= Html::encode($a->color) ?></td>
                <td>
                    <?php if ($a->status === AppleStatus::ON_TREE): ?>
                        <span class="badge bg-success">на дереве</span>
                    <?php else: ?>
                        <span class="badge bg-secondary">на земле</span>
                    <?php endif; ?>
                </td>
                <td><?= date('Y-m-d H:i:s', $a->createdAtUnix) ?></td>
                <td><?= $a->fellAtUnix ? date('Y-m-d H:i:s', $a->fellAtUnix) : '-' ?></td>
                <td><?= Html::encode((string)$a->eatenPercent) ?></td>
                <td><?= Html::encode((string)$a->size) ?></td>
                <td>
                    <?php if ($a->isRotten): ?>
                        <span class="badge bg-danger">да</span>
                    <?php else: ?>
                        <span class="badge bg-primary">нет</span>
                    <?php endif; ?>
                </td>
                <td>
                    <div class="d-flex gap-2 flex-wrap">

                        <form method="post" action="<?= Url::to(['apple/fall', 'id' => $a->id]) ?>">
                            <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()) ?>
                            <button class="btn btn-warning btn-sm" type="submit">Упасть</button>
                        </form>

                        <form method="post" action="<?= Url::to(['apple/eat', 'id' => $a->id]) ?>" class="d-flex gap-2 align-items-center">
                            <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()) ?>
                            <input type="number" name="percent" min="1" max="100" step="1" class="form-control form-control-sm" placeholder="%" style="width: 80px;">
                            <button class="btn btn-success btn-sm" type="submit">Съесть</button>
                        </form>

                    </div>
                </td>
            </tr>
        <?php endforeach; ?>

        <?php if (count($apples) === 0): ?>
            <tr>
                <td colspan="9" class="text-center py-4">
                    Яблок пока нет. Нажми “Сгенерировать”.
                </td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

</div>
