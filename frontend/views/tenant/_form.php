<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model common\models\Tenants */
/* @var $form yii\widgets\ActiveForm */
//$tenantUsers = User::getUsers();

?>

<div class="tenant-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
    <?= $model->isNewRecord ? $form->field($model, 'username') : null ?>

    <?php //  <?= $form->field($model, 'tenantUsers')->checkBoxList($tenantUsers) ?> 


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    	<?= $model->isNewRecord ? null : Html::a(Yii::t('app', 'Create User'), ['createuser', 'tenantname' => $model->name, 'tenantid' => $model->id], 
    		['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
