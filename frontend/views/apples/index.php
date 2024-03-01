<?php

use frontend\models\Apples;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var Apples[] $models */

$this->title = 'Apples';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apples-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php ActiveForm::begin(['action' => Yii::$app->urlManager->createUrl(['apples/create']), 'method' => 'post']); ?>
    <p><?= Html::submitButton('Create Apples', ['class' => 'btn btn-success']) ?></p>
    <?php ActiveForm::end(); ?>

    <div id="w0" class="grid-view">
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th></th>
                <th>Created At</th>
                <th>Fell At</th>
                <th>Status</th>
                <th>Size</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($models as $apple): ?>
                <tr data-key="1">
                    <td><?= $apple->icon ?></td>
                    <td><span class="not-set"><?= $apple->created_at ?></span></td>
                    <td><span class="not-set"><?= $apple->fellAt ?></span></td>
                    <td><?= $apple->appleStatus ?></td>
                    <td><?= $apple->size ?></td>
                    <td>
                        <?php if ($apple->isOnTree()): ?>
                            <?php ActiveForm::begin(['options' => [
                                'style' => 'display: inline'
                            ], 'action' => Yii::$app->urlManager->createUrl(["apples/fall", 'id' => $apple->id]), 'method' => 'post']); ?>
                            <button type="submit" class="btn btn-primary">Fall</button>
                            <?php ActiveForm::end(); ?>
                        <?php endif; ?>

                        <?php if ($apple->isEatable()): ?>
                            <?php ActiveForm::begin(['options' => [
                                'style' => 'display: inline'
                            ], 'action' => Yii::$app->urlManager->createUrl(["apples/eat", 'id' => $apple->id]), 'method' => 'post']); ?>
                            <input type="number" value="0" min="0" max="100" name="percent_eaten" />
                            <button type="submit" class="btn btn-success">Eat</button>
                            <?php ActiveForm::end(); ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
