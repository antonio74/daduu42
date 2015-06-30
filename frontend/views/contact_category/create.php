<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Contact_category */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'contact category',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="Contact_category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
