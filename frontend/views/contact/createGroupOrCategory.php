<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Contact */

$errorCode = $_REQUEST['errorCode'];
$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Contact',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contacts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact-create">

    <h1><?= Html::encode($this->title) ?></h1>

    </br>

    <div class="contact-form">

    	<p class="error-summary"> 
            Warning: Before you create a contact you have to create at least 
            <?= ($errorCode > 1)? ' a Contact Group' : null ?>  <?= ($errorCode == 3)? ' and' : null ?>
            <?= ($errorCode != 2)? ' a Contact Category' : null ?>.
    	    </br></br> Press button to create! 
    	</p>    

    	</br></br>

    	<div class="form-group">

	        <?= ($errorCode == 1 || $errorCode == 3)? Html::a(Yii::t('app', 'Create Category'), ['/contact_category/create'], 
    	        ['class' => 'btn btn-success']) : null ?>  

	        <?= ($errorCode == 2 || $errorCode == 3)? Html::a(Yii::t('app', 'Create Group'), ['/contact_group/create'], 
    	        ['class' => 'btn btn-success']) : null ?>

	    </div>


	</div>


</div>
