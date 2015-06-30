<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\NewrubricaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contact-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'lastname') ?>

    <?= $form->field($model, 'firstname') ?>

    <?= $form->field($model, 'company') ?>   
    
    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'phone_prefix') ?>

    <?= $form->field($model, 'phone') ?>

    <?= $form->field($model, 'mobile_prefix') ?>

    <?= $form->field($model, 'mobile') ?>     

    <?= $form->field($model, 'general_prefix') ?>

    <?= $form->field($model, 'general') ?>         


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
