<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Contact_group;
use common\models\Contact_to_contact_group;

/* @var $this yii\web\View */
/* @var $model common\models\Newrubrica */
/* @var $form yii\widgets\ActiveForm */

$gruppi = Contact_group::getGruppi();
?>

<div class="contact-form">


    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'lastname')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'firstname')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'company')->textInput(['maxlength' => 255]) ?>   
    
    <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'phone_prefix')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'mobile_prefix')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'mobile')->textInput(['maxlength' => 255]) ?>     

    <?= $form->field($model, 'general_prefix')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'general')->textInput(['maxlength' => 255]) ?>         

    <?= $form->field($model, 'contact_category_id')->dropDownList($categorie) ?>

    <?= $form->field($model, 'gruppi')->checkBoxList($gruppi) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
