<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Contact_group */
/* @var $form yii\widgets\ActiveForm */
$visibility = array();
$visibility['privato']='Privato';
$visibility['gruppo']='Gruppo';
$visibility['tenant']='Tenant';

$read_write = array();
$read_write['RW'.Yii::$app->user->id]='Read';
$read_write['RW']='Read/Write';


?>

<div class="Contact_group-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'visibility')->dropDownList($visibility) ?>

    <?= $form->field($model, 'read_write')->radioList($read_write) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
