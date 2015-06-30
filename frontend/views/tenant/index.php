<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TenantSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tenant');
$this->params['breadcrumbs'][] = $this->title;
if(isset($_REQUEST['m']))
    $message = $_REQUEST['m'];
else $message=0;
?>

<div class="tenant-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if($message==1){ ?>
        <p class="success"> <?= 'Tenant creato con successo! Le credenziali d\'accesso sono state inviate a '. 
                            \Yii::$app->user->identity->email ?> 
        </p>
    <?php } ?>  
      
    <?php if($message==2){ ?>          
        <p class="error-summary"> <?= 'Non è stato possibile inviare l\'email con le credenziali di registrazione' ?> 
        </p>
    <?php } ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Tenant',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
