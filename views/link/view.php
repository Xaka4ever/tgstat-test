<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Link */

$this->title = 'View Link: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Links', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="link-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <table class="table table-striped">
        <tr>
            <th>ID</th>
            <td><?= Html::encode($model->id) ?></td>
        </tr>
        <tr>
            <th>URL</th>
            <td><?= Html::encode($model->url) ?></td>
        </tr>
        <tr>
            <th>Short Token</th>
            <td><?= Html::encode($model->short_token) ?></td>
        </tr>
        <tr>
            <th>Date Create</th>
            <td><?= Html::encode($model->date_create) ?></td>
        </tr>
    </table>
</div>
