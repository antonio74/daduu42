<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use common\models\Gruppo;

/* @var $this yii\web\View */
/* @var $model common\models\Contact */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contacts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$gruppi = $model->stringaGruppi();
?>

<div class="contact-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'lastname',
            'firstname',
            'company',
            'email:email',
            'phone_prefix',
            'phone',
            'mobile_prefix',
            'mobile',
            'general_prefix',
            'general',

            [ 'label' => 'Category', 'value' => $model->contact_category->name ],
            [ 'label' =>'Groups', 'value' => $gruppi],
        ],
    ]) ?>


</div>
