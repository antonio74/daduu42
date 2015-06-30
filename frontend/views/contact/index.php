<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\NewrubricaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Contacts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}', [
                'modelClass' => 'contact', ]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

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

            /* This column has been added to display the category name and not its ID, and to create a link to contact category */
            ['attribute' => 'contact_category_id',
             'format' => 'raw',
             'value' => function ($data) {
                        return Html::a($data->contact_category->name, ['/contact_category/view', 'id' =>$data->contact_category->id]);
                    },
            ],

            ['class' => 'yii\grid\ActionColumn']
        ],
    ]); ?>

</div>
