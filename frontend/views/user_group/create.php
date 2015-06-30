<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\User_group */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'User Group',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
