<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Contact_group */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'contact group',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contact groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="Contact_group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
