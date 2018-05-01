<?php

$this->breadcrumbs = array(
    'Users' => array('index'),
    'Create',
);

$this->menu = array(
    array('label' => Yii::t('translate', 'List Employees'), 'url' => array('index')),
);
?>

<?php $this->pageTitlecrumbs = Yii::t('translate', 'Create Employee'); ?>

<?php echo $this->renderPartial('_form', array('model' => $model, 'model_permission' => $model_permission)); ?>